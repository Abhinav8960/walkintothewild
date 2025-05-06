import json
import boto3
import os
import subprocess

s3 = boto3.client('s3')

THUMBNAIL_FOLDER = 'thumbnail/'
THUMBNAIL_SIZES = {
    'low': '64x36',
    'medium': '128x72',
    'standard': '256x144',
}
TARGET_BUCKET_NAME = 'witw-staging-thumbnail'  # Replace with your target bucket name

# Supported video and image formats
SUPPORTED_VIDEO_FORMATS = ['video/mp4', 'video/mpeg', 'video/quicktime']
SUPPORTED_IMAGE_FORMATS = ['image/jpeg', 'image/png', 'image/gif']


def lambda_handler(event, context):
    try:
        # Get the bucket name and object key from the event
        source_bucket_name = event['Records'][0]['s3']['bucket']['name']
        object_key = event['Records'][0]['s3']['object']['key']

        # Check if the uploaded file is already in the thumbnail folder
        if object_key.startswith(THUMBNAIL_FOLDER):
            print(
                f"Skipping processing for {object_key} as it is in the thumbnail folder.")
            return {
                'statusCode': 200,
                'body': json.dumps('Processing skipped.')
            }

        # Get the object metadata to check its content type
        try:
            response = s3.head_object(
                Bucket=source_bucket_name, Key=object_key)
            content_type = response['ContentType']
        except Exception as e:
            print(
                f"Error fetching metadata for {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
            return {
                'statusCode': 500,
                'body': json.dumps('Error fetching object metadata.')
            }

        # Determine if the file is a video or an image
        if content_type in SUPPORTED_VIDEO_FORMATS:
            print(f"Processing video: {object_key}")
            process_media(source_bucket_name,
                          object_key, content_type, is_video=True)
        elif content_type in SUPPORTED_IMAGE_FORMATS:
            print(f"Processing image: {object_key}")
            process_media(source_bucket_name,
                          object_key, content_type, is_video=False)
        else:
            print(
                f"Skipping {object_key} as it is not a supported video or image format.")
            return {
                'statusCode': 200,
                'body': json.dumps('Not a supported video or image format.')
            }

        return {
                'statusCode': 200,
                'body': json.dumps('Processing complete.')
        }

    except Exception as e:
        print(
            f"Unexpected error processing object {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
        return {
                'statusCode': 500,
                'body': json.dumps('Unexpected error occurred.')
        }


def process_media(source_bucket_name, object_key, content_type, is_video):
    # Download the file from S3 to /tmp
    local_file_path = f'/tmp/{os.path.basename(object_key)}'
    try:
        s3.download_file(source_bucket_name, object_key, local_file_path)
        print(f"Downloaded {object_key} to {local_file_path}")
    except Exception as e:
        print(
            f"Error downloading {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
        raise

    for quality, size in THUMBNAIL_SIZES.items():
        thumbnail_base_name = f'thumbnail_{quality}_{os.path.splitext(
            os.path.basename(object_key))[0]}'
        thumbnail_key_prefix = os.path.join(
            THUMBNAIL_FOLDER, os.path.dirname(object_key))
        thumbnail_local_path = f'/tmp/{thumbnail_base_name}.jpg'  # FFmpeg outputs to image

        thumbnail_key = os.path.join(
            thumbnail_key_prefix, f'{thumbnail_base_name}.jpg')
        try:
            if is_video:
                subprocess.run([
                    '/opt/bin/ffmpeg',
                    '-i', local_file_path,
                    '-ss', '00:00:01',  # Capture thumbnail at 1 second
                    '-vf', f'scale={size}',
                    '-vframes', '1',
                    thumbnail_local_path
                ], check=True, capture_output=True)
                print(
                    f"Video thumbnail ({quality}) created at {thumbnail_local_path}")
            else:  # is_video is False, so it's an image
                subprocess.run([
                    '/opt/bin/ffmpeg',
                    '-i', local_file_path,
                    '-vf', f'scale={size}',
                    '-vframes', '1',
                    thumbnail_local_path  # Output as JPG
                ], check=True, capture_output=True)
                print(
                    f"Image thumbnail ({quality}) created at {thumbnail_local_path}")
            upload_thumbnail(
                thumbnail_local_path, TARGET_BUCKET_NAME, thumbnail_key, 'image/jpeg')  # Always upload as jpeg
        except subprocess.CalledProcessError as e:
            print(
                f"Error generating thumbnail ({quality}) for {object_key}. Error: {e.stderr.decode('utf-8')}")
            raise

    # Clean up local files
    try:
        os.remove(local_file_path)
        print("Cleaned up original local file.")
        for quality in THUMBNAIL_SIZES:
            thumbnail_base_name = f'thumbnail_{quality}_{os.path.splitext(
                os.path.basename(object_key))[0]}'
            thumbnail_local_path = f'/tmp/{thumbnail_base_name}.jpg'
            if os.path.exists(thumbnail_local_path):
                os.remove(thumbnail_local_path)
                print(f"Cleaned up local thumbnail file: {thumbnail_local_path}")
    except OSError as e:
        print(f"Error cleaning up local files: {e}")


def upload_thumbnail(local_path, target_bucket, target_key, content_type):  # content type is always image/jpeg
    try:
        s3.upload_file(local_path, target_bucket, target_key,
                       ExtraArgs={'ContentType': content_type})
        print(f"Thumbnail uploaded to s3://{target_bucket}/{target_key}")
    except Exception as e:
        print(
            f"Error uploading thumbnail to bucket {target_bucket} with key {target_key}. Error: {str(e)}")
        raise
