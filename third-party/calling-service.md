# Calling Service Implementation

## Overview

Calling functionality is implemented using Airphone and Deepcall APIs for click-to-call features.

## Step-by-Step Implementation

### 1. Configure API Credentials

Add to `common/config/params.php`:

```php
'airphone_api_token' => 'YOUR_AIRPHONE_TOKEN',
'airphone_api_host_url' => 'https://airphone.in',
'airphone_api_vnm' => 'YOUR_VNM_NUMBER',
'deepcall_api_token' => 'YOUR_DEEPCALL_TOKEN',
'deepcall_api_host_url' => 'https://s-ct3.sarv.com/v2/clickToCall/para',
```

### 2. Create CallingService Class

Create `common/calling/services/CallingService.php`:

```php
<?php
namespace common\calling\services;

use common\models\CallLog;
use Yii;

class CallingService
{
    // Properties for call details
    public $reference_id;
    public $chat_id;
    public $lead_id;
    // ... other properties

    public function __construct($chat_id, $lead_id, $operator_user_id, ...)
    {
        // Initialize properties
        $this->reference_id = Yii::$app->security->generateRandomString(5) . '_' . time();
        $this->chat_id = $chat_id;
        // ...
    }

    public function initiateCall()
    {
        $this->call_model = new CallLog();
        // Set call model properties

        // Choose service based on configuration
        if (Yii::$app->params['call_service'] == 'airphone') {
            return $this->callViaAirphone();
        } else {
            return $this->callViaDeepcall();
        }
    }

    private function callViaAirphone()
    {
        $url = Yii::$app->params['airphone_api_host_url'] . '/api/v1/click_to_call';
        $data = [
            'token' => Yii::$app->params['airphone_api_token'],
            'vnm' => Yii::$app->params['airphone_api_vnm'],
            'caller_1' => $this->request_caller_1_no,
            'caller_2' => $this->request_caller_2_no,
            // ... other params
        ];

        $response = $this->makeApiCall($url, $data);
        // Process response and update call log
    }

    private function callViaDeepcall()
    {
        $url = Yii::$app->params['deepcall_api_host_url'];
        $data = [
            'token' => Yii::$app->params['deepcall_api_token'],
            'caller_1' => $this->request_caller_1_no,
            'caller_2' => $this->request_caller_2_no,
            // ... other params
        ];

        $response = $this->makeApiCall($url, $data);
        // Process response
    }

    private function makeApiCall($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
```

### 3. Create CallLog Model

Create `common/models/CallLog.php` with fields for call details, service type, etc.

### 4. Integrate with Chat System

Call the service from chat controllers when initiating calls.

### 5. Handle Callbacks

Implement webhook endpoints for call status updates from the service providers.

## Notes

- Airphone and Deepcall are Indian telecom service providers.
- Handle call recording uploads to S3.
- Ensure proper user consent for calls.</content>
  <parameter name="filePath">c:\xampp\htdocs\walkintothewild\third-party\calling-service.md
