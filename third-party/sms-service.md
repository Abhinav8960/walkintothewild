# SMS Service Implementation

## Overview

SMS service is implemented using Triline Infotech API for sending SMS messages in the project.

## Step-by-Step Implementation

### 1. Install HTTP Client Extension

Yii2 HTTP Client is used for API calls. It's included by default.

### 2. Configure SMS API Credentials

Add to `common/config/params.php`:

```php
'sms_api_key' => 'YOUR_TRILINE_API_KEY',
'sms_sender_id' => 'YOUR_SENDER_ID',
```

### 3. Create SmsChannel Class

Create `common/broadcast/channels/SmsChannel.php`:

```php
<?php
namespace common\broadcast\channels;

use common\models\SmsLog;
use yii\httpclient\Client;

class SmsChannel
{
    const CHANNEL_NAME = 'sms';

    public function send($event, $log)
    {
        $phone_no = $log->phone_no;
        $route = $log->route;
        $message = $this->generateMessage($log->template_id, $log->params);
        $template_id = $log->template_id;

        $url = "http://sms.trilineinfotech.com/api/smsapi?key=" . \Yii::$app->params['sms_api_key'] .
               "&route=" . $route .
               "&sender=" . \Yii::$app->params['sms_sender_id'] .
               "&number=" . $phone_no .
               "&sms=" . urlencode($message) .
               "&templateid=" . $template_id;

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        if ($response->isOk) {
            $log->is_ok = 1;
            $log->status = SmsLog::STATUS_SENT;
            $log->sms_send_time = time();
        } else {
            $log->status = SmsLog::STATUS_FAILED;
        }
        $log->save(false);
    }

    private function generateMessage($template_id, $params)
    {
        // Generate message from template
        // Implementation similar to email templates
    }
}
```

### 4. Create SmsLog Model

Create `common/models/SmsLog.php` to log SMS sends:

```php
<?php
namespace common\models;

use common\models\trierror\ActiveLogRecord;

class SmsLog extends ActiveLogRecord implements \common\interfaces\NewStatusInterface
{
    const STATUS_PENDING = 0;
    const STATUS_SENT = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_FAILED = 3;

    // Fields: phone_no, message, template_id, status, etc.
}
```

### 5. Integrate with Broadcasting System

Use the SmsChannel in your broadcasting queue service.

### 6. Handle Delivery Reports

Implement webhook or polling for delivery status updates.

## Notes

- Ensure DLT registration for Indian SMS compliance.
- Handle rate limits and error responses.
- Use templates for regulatory compliance.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\sms-service.md
