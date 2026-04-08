# AWS SQS and Lambda Broadcasting Implementation

## Overview

AWS SQS (Simple Queue Service) and Lambda are used for asynchronous broadcasting of emails and notifications. The system sends messages to SQS, which triggers Lambda functions to process emails via SES and send status back.

## Step-by-Step Implementation

### 1. Install AWS SDK for PHP

AWS SDK is already included in `composer.json`:

```json
{
  "require": {
    "aws/aws-sdk-php": "^3.345"
  }
}
```

Run `composer update` if needed.

### 2. Set Up AWS Credentials

Configure AWS credentials in your environment or config:

- Use IAM roles if running on EC2.
- Or set environment variables: `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`.
- For local development, use AWS CLI or SDK config.

### 3. Create SQS Queue

- Go to AWS SQS Console.
- Create a standard queue for broadcasting messages.
- Note the queue URL.

### 4. Configure SQS in Yii2

Add SQS component to `common/config/main.php`:

```php
'components' => [
    'sqs' => [
        'class' => 'Aws\Sqs\SqsClient',
        'region' => 'your-region', // e.g., 'us-east-1'
        'version' => 'latest',
    ],
],
```

### 5. Send Messages to SQS

Create a helper to send messages to SQS:

```php
<?php
namespace common\Helper;

use Yii;
use Aws\Sqs\SqsClient;

class SqsHelper
{
    public static function sendBroadcastMessage($channels, $data)
    {
        $sqs = Yii::$app->sqs;
        $queueUrl = 'your-queue-url';

        $message = [
            'channels' => $channels, // e.g., ['email', 'notification']
            'data' => $data,
        ];

        $sqs->sendMessage([
            'QueueUrl' => $queueUrl,
            'MessageBody' => json_encode($message),
        ]);
    }
}
```

### 6. Create Lambda Function

- Go to AWS Lambda Console.
- Create a new function with Node.js runtime.
- Set up trigger from SQS.
- Code example:

```javascript
const AWS = require("aws-sdk");
const ses = new AWS.SES();

exports.handler = async (event) => {
  for (const record of event.Records) {
    const message = JSON.parse(record.body);
    const { channels, data } = message;

    if (channels.includes("email")) {
      // Send email via SES
      await ses
        .sendEmail({
          Source: "noreply@yourdomain.com",
          Destination: { ToAddresses: [data.email] },
          Message: {
            Subject: { Data: data.subject },
            Body: { Text: { Data: data.body } },
          },
        })
        .promise();
    }

    // Send status back via another SQS or HTTP callback
    // For example, post to your API endpoint
  }
};
```

### 7. Handle Status Callbacks

In your Yii2 application, create an endpoint to receive status updates from Lambda:

```php
// In controller
public function actionBroadcastStatus()
{
    $status = Yii::$app->request->post();
    // Update database with email/notification status
}
```

### 8. Integrate with Broadcasting Logic

In your broadcasting code, use the SqsHelper:

```php
SqsHelper::sendBroadcastMessage(['email', 'notification'], [
    'email' => 'user@example.com',
    'subject' => 'Notification',
    'body' => 'Message content',
]);
```

## Notes

- Ensure proper IAM permissions for SQS and SES.
- Handle message visibility timeouts and dead-letter queues.
- Monitor Lambda execution and costs.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\aws-sqs-lambda-broadcasting.md
