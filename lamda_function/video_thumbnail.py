import json
import boto3
import os
import subprocess

s3 = boto3.client('s3')

THUMBNAIL_FOLDER = 'thumbnail/'
THUMBNAIL_SIZE = '128x72'  # Example thumbnail size for videos
TARGET_BUCKET_NAME = 'witw-staging-thumbnail' # Replace with your target bucket name

# Supported video formats (you might need to adjust this based on your needs)
SUPPORTED_VIDEO_FORMATS = ['video/mp4', 'video/mpeg', 'video/quicktime']

def lambda_handler(event, context):
    try:
        # Get the bucket name and object key from the event
        source_bucket_name = event['Records'][0]['s3']['bucket']['name']
        object_key = event['Records'][0]['s3']['object']['key']

        # Check if the uploaded file is already in the thumbnail folder
        if object_key.startswith(THUMBNAIL_FOLDER):
            print(f"Skipping processing for {object_key} as it is in the thumbnail folder.")
            return {
                'statusCode': 200,
                'body': json.dumps('Processing skipped.')
            }

        # Get the object metadata to check its content type
        try:
            response = s3.head_object(Bucket=source_bucket_name, Key=object_key)
            content_type = response['ContentType']
        except Exception as e:
            print(f"Error fetching metadata for {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
            return {
                'statusCode': 500,
                'body': json.dumps('Error fetching object metadata.')
            }

        # Process only if the file is a supported video format
        if content_type in SUPPORTED_VIDEO_FORMATS:
            print(f"Processing video: {object_key}")

            # Download the video file from S3 to /tmp
            local_file_path = f'/tmp/{os.path.basename(object_key)}'
            try:
                s3.download_file(source_bucket_name, object_key, local_file_path)
                print(f"Downloaded {object_key} to {local_file_path}")
            except Exception as e:
                print(f"Error downloading {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
                return {
                    'statusCode': 500,
                    'body': json.dumps('Error downloading video from S3.')
                }

            # Generate the thumbnail using ffmpeg
            thumbnail_local_path = f'/tmp/thumbnail_{os.path.basename(object_key)}.jpg'
            try:
                subprocess.run([
                    '/opt/bin/ffmpeg',
                    '-i', local_file_path,
                    '-ss', '00:00:01',  # Capture thumbnail at 1 second
                    '-vf', f'scale={THUMBNAIL_SIZE}',
                    '-vframes', '1',
                    thumbnail_local_path
                ], check=True, capture_output=True)
                print(f"Thumbnail created at {thumbnail_local_path}")
            except subprocess.CalledProcessError as e:
                print(f"Error generating thumbnail for {object_key}. Error: {e.stderr.decode('utf-8')}")
                return {
                    'statusCode': 500,
                    'body': json.dumps('Error generating video thumbnail.')
                }

            # Create the new object key for the thumbnail in the target bucket
            # Maintain the same object path as the original, but in the 'thumbnail/' folder
            thumbnail_key = os.path.join(THUMBNAIL_FOLDER, object_key) + '.jpg'

            # Upload the thumbnail to the target S3 bucket
            try:
                s3.upload_file(thumbnail_local_path, TARGET_BUCKET_NAME, thumbnail_key, ExtraArgs={'ContentType': 'image/jpeg'})
                print(f"Thumbnail uploaded to s3://{TARGET_BUCKET_NAME}/{thumbnail_key}")
            except Exception as e:
                print(f"Error uploading thumbnail to bucket {TARGET_BUCKET_NAME}. Error: {str(e)}")
                return {
                    'statusCode': 500,
                    'body': json.dumps('Error uploading thumbnail to S3.')
                }

            # Clean up local files
            try:
                os.remove(local_file_path)
                os.remove(thumbnail_local_path)
                print("Cleaned up local files.")
            except OSError as e:
                print(f"Error cleaning up local files: {e}")

            return {
                'statusCode': 200,
                'body': json.dumps(f'Thumbnail created and uploaded to s3://{TARGET_BUCKET_NAME}/{thumbnail_key}')
            }
        else:
            print(f"Skipping {object_key} as it is not a supported video format.")
            return {
                'statusCode': 200,
                'body': json.dumps('Not a supported video format.')
            }

    except Exception as e:
        print(f"Unexpected error processing object {object_key} from bucket {source_bucket_name}. Error: {str(e)}")
        return {
            'statusCode': 500,
            'body': json.dumps('Unexpected error occurred.')
        }