# AWS CloudWatch Logging Implementation

## Overview

AWS CloudWatch is used for centralized logging in the application.

## Step-by-Step Implementation

### 1. Install AWS SDK

AWS SDK is already included in `composer.json`:

```json
{
  "require": {
    "aws/aws-sdk-php": "^3.345"
  }
}
```

### 2. Configure AWS Credentials

Set up AWS credentials via environment variables, IAM roles, or config:

```php
// In config
'cloudwatch' => [
    'region' => 'us-east-1',
    'logGroup' => 'walkintothewild-logs',
    'logStream' => 'application-logs',
],
```

### 3. Create CloudWatchLogTarget Component

Create `common/components/CloudWatchLogTarget.php`:

```php
<?php
namespace common\components;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\Exception\AwsException;
use Yii;
use yii\log\Target;

class CloudWatchLogTarget extends Target
{
    public $awsAccessKeyId;
    public $awsSecretAccessKey;
    public $region = 'us-east-1';
    public $logGroup = 'walkintothewild-logs';
    public $logStream = 'application-logs';

    private $client;
    private $sequenceToken;

    public function init()
    {
        parent::init();

        $config = [
            'region' => $this->region,
            'version' => 'latest',
        ];

        if ($this->awsAccessKeyId && $this->awsSecretAccessKey) {
            $config['credentials'] = [
                'key' => $this->awsAccessKeyId,
                'secret' => $this->awsSecretAccessKey,
            ];
        }

        $this->client = new CloudWatchLogsClient($config);
        $this->ensureLogGroupAndStream();
    }

    protected function ensureLogGroupAndStream()
    {
        try {
            $this->client->createLogGroup(['logGroupName' => $this->logGroup]);
        } catch (AwsException $e) {
            // Log group might already exist
        }

        try {
            $this->client->createLogStream([
                'logGroupName' => $this->logGroup,
                'logStreamName' => $this->logStream,
            ]);
        } catch (AwsException $e) {
            // Log stream might already exist
        }

        $response = $this->client->describeLogStreams([
            'logGroupName' => $this->logGroup,
            'logStreamNamePrefix' => $this->logStream,
        ]);

        if (!empty($response['logStreams'])) {
            $this->sequenceToken = $response['logStreams'][0]['uploadSequenceToken'] ?? null;
        }
    }

    public function export()
    {
        $messages = array_map([$this, 'formatMessage'], $this->messages);

        $logEvents = [];
        foreach ($messages as $message) {
            $logEvents[] = [
                'message' => $message,
                'timestamp' => round(microtime(true) * 1000),
            ];
        }

        $params = [
            'logGroupName' => $this->logGroup,
            'logStreamName' => $this->logStream,
            'logEvents' => $logEvents,
        ];

        if ($this->sequenceToken) {
            $params['sequenceToken'] = $this->sequenceToken;
        }

        try {
            $response = $this->client->putLogEvents($params);
            $this->sequenceToken = $response['nextSequenceToken'];
        } catch (AwsException $e) {
            Yii::error('CloudWatch logging failed: ' . $e->getMessage());
        }
    }
}
```

### 4. Configure Logging

Add to `common/config/main.php`:

```php
'log' => [
    'targets' => [
        [
            'class' => 'common\components\CloudWatchLogTarget',
            'levels' => ['error', 'warning', 'info'],
            'logVars' => [],
        ],
    ],
],
```

### 5. Use Logging

Log messages will automatically be sent to CloudWatch:

```php
Yii::info('User logged in', __METHOD__);
```

## Notes

- Ensure proper IAM permissions for CloudWatch access.
- Monitor costs as CloudWatch has usage charges.
- Use log levels appropriately.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\aws-cloudwatch-logging.md
