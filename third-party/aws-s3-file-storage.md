# AWS S3 File Storage Implementation

## Overview

AWS S3 is used for storing and serving files like images, videos, and recordings.

## Step-by-Step Implementation

### 1. Install Flysystem S3 Adapter

Included in `composer.json`:

```json
{
  "require": {
    "league/flysystem-aws-s3-v3": "^3.0"
  }
}
```

### 2. Configure AWS Credentials

Set up credentials via environment or IAM roles.

### 3. Configure File System Component

Add to `common/config/main.php`:

```php
'components' => [
    'fs' => [
        'class' => 'creocoder\flysystem\AwsS3Filesystem',
        'key' => getenv('AWS_ACCESS_KEY_ID'),
        'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
        'bucket' => 'your-bucket-name',
        'region' => 'us-east-1',
        'prefix' => 'uploads/', // Optional prefix
    ],
],
```

### 4. Upload Files

Use the filesystem component to upload:

```php
$filesystem = Yii::$app->fs;
$stream = fopen($filePath, 'r+');
$filesystem->writeStream('path/in/bucket/file.jpg', $stream);
fclose($stream);
```

### 5. Generate URLs

Get public URLs for files:

```php
$url = $filesystem->getUrl('path/to/file.jpg');
```

### 6. Handle Call Recordings

For call recordings, upload to S3 after calls:

```php
// In your call processing
$filesystem->writeStream('recordings/' . $filename, $recordingStream);
```

## Notes

- Configure bucket policies for public access if needed.
- Use CloudFront for CDN if required.
- Monitor S3 costs and usage.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\aws-s3-file-storage.md
