<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

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
        try {
            $endpoint = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            
            $data = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $params['phone_number'],
                'type' => $params['type'] ?? 'text',
            ];

            // Handle different message types
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

            $headers = [
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: application/json',
            ];

            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, Json::encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode == 200) {
                $result = Json::decode($response);
                return [
                    'success' => true,
                    'message_id' => $result['messages'][0]['id'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error' => $response,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getMessages($params = [])
    {
        // Implementation for retrieving messages
    }

    public function markMessageAsRead($messageId)
    {
        // Implementation for marking messages as read
    }
}