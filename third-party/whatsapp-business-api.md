# WhatsApp Business API Implementation

## Overview

WhatsApp integration is implemented using Facebook's WhatsApp Business API for sending messages.

## Step-by-Step Implementation

### 1. Set Up WhatsApp Business Account

- Create a Facebook Business account.
- Set up WhatsApp Business API through a BSP (Business Solution Provider) or directly.
- Get API credentials: Access Token and Phone Number ID.

### 2. Configure API Credentials

Add to `common/config/params.php`:

```php
'whatsapp' => [
    'accessToken' => 'YOUR_ACCESS_TOKEN',
    'phoneNumberId' => 'YOUR_PHONE_NUMBER_ID',
],
```

### 3. Create WhatsappApi Component

Create `common/components/WhatsappApi.php`:

```php
<?php
namespace common\components;

use Yii;
use yii\base\Component;

class WhatsappApi extends Component
{
    public $apiUrl = 'https://graph.facebook.com/v23.0';
    public $accessToken;
    public $phoneNumberId;

    public function init()
    {
        parent::init();
        $this->accessToken = Yii::$app->params['whatsapp']['accessToken'];
        $this->phoneNumberId = Yii::$app->params['whatsapp']['phoneNumberId'];
    }

    public function sendMessage($params)
    {
        $endpoint = "{$this->apiUrl}/{$this->phoneNumberId}/messages";

        $data = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $params['phone_number'],
            'type' => $params['type'] ?? 'text',
        ];

        switch ($data['type']) {
            case 'text':
                $data['text'] = ['body' => $params['message']];
                break;
            case 'template':
                $data['template'] = $params['template'];
                break;
            case 'image':
                $data['image'] = ['link' => $params['media_url']];
                break;
        }

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
```

### 4. Create Models for WhatsApp Data

Create `common/models/whatsapp/WhatsappContacts.php` and `WhatsappMessages.php` for storing contacts and message logs.

### 5. Create Backend Module

Create a backend module for managing WhatsApp messages in `backend/modules/whatsapp/`.

### 6. Handle Webhooks

Implement webhook endpoints to receive message status updates and incoming messages.

### 7. Send Messages

Use the API component to send messages:

```php
$whatsapp = new WhatsappApi();
$whatsapp->sendMessage([
    'phone_number' => '1234567890',
    'message' => 'Hello from Walk Into The Wild',
]);
```

## Notes

- WhatsApp Business API has rate limits and costs.
- Templates must be approved for marketing messages.
- Handle opt-in/opt-out compliance.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\whatsapp-business-api.md
