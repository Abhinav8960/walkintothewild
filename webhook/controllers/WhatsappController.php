<?php

namespace webhook\controllers;

use common\models\whatsapp\WhatsappContacts;
use common\models\whatsapp\WhatsappMessages;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;
use Netflie\WhatsAppCloudApi\WebHook;


/**
 * WhatsApp Webhook Controller
 * Handles incoming messages and status updates from WhatsApp Cloud API v23.0
 */
class WhatsappController extends Controller
{
    private $whatsappAccessToken;
    
    public function init()
    {
        parent::init();
        $this->whatsappAccessToken = \Yii::$app->params['whatsapp']['accessToken'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET']
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            // Disable CSRF validation for the webhook action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        // Handle webhook verification
        if (isset($_GET['hub_mode']) && $_GET['hub_mode'] === 'subscribe') {
            if (isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === "white-elephant") {
                echo $_GET['hub_challenge'] ?? '';
                exit;
            }
            throw new \yii\web\BadRequestHttpException('Invalid verification token');
        }

        // Get payload
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);

        \Yii::info(time() . ' WhatsApp Webhook Payload: ' . $payload, 'whatsapp-webhook');

        // Validate payload structure
        if (empty($data['entry'][0]['changes'][0]['value'])) {
            \Yii::warning('Invalid webhook payload structure', 'whatsapp-webhook');
            return;
        }

        $value = $data['entry'][0]['changes'][0]['value'];

        try {
            // Handle messages
            if (isset($value['messages'])) {
                foreach ($value['messages'] as $message) {
                    if (!isset($message['id'])) {
                        \Yii::warning('Message without ID received', 'whatsapp-webhook');
                        continue;
                    }

                    // Check if we have contact information
                    if (!isset($value['contacts'][0])) {
                        \Yii::warning('Message received without contact information', 'whatsapp-webhook');
                        continue;
                    }

                    $this->handleIncomingMessage($value, $message);
                }
            }

            // Handle message status updates
            if (isset($value['statuses'])) {
                foreach ($value['statuses'] as $status) {
                    if (!isset($status['id'])) {
                        \Yii::warning('Status update without message ID received', 'whatsapp-webhook');
                        continue;
                    }
                    $this->handleMessageStatus($status);
                }
            }
        } catch (\Exception $e) {
            \Yii::error('Error processing webhook: ' . $e->getMessage(), 'whatsapp-webhook');
            throw $e;
        }
    }

    /**
     * Handle incoming WhatsApp message
     */
    protected function handleIncomingMessage($value, $message)
    {
        // Get or create contact
        $contact = $this->getOrCreateContact($value['contacts'][0]);
        if (!$contact) {
            \Yii::error('Failed to create or get contact', 'whatsapp-webhook');
            return;
        }

        // Check if message already exists
        $existingMessage = WhatsappMessages::find()
            ->where(['wamid' => $message['id']])
            ->one();

        if ($existingMessage) {
            \Yii::info('Message already exists: ' . $message['id'], 'whatsapp-webhook');
            return;
        }

        // Create message record
        $whatsappMessage = new WhatsappMessages([
            'wamid' => $message['id'],
            'contact_id' => $contact->id,
            'direction' => WhatsappMessages::DIRECTION_INBOUND,
            'status' => WhatsappMessages::STATUS_DELIVERED,
            'timestamp' => isset($message['timestamp']) ? date('Y-m-d H:i:s', $message['timestamp']) : date('Y-m-d H:i:s')
        ]);

        // Handle different message types
        switch ($message['type']) {
            case 'text':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_TEXT;
                $whatsappMessage->content = $message['text']['body'] ?? '';
                break;

            case 'image':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_IMAGE;
                if (isset($message['image'])) {
                    $whatsappMessage->mime_type = $message['image']['mime_type'] ?? null;
                    $whatsappMessage->sha256 = $message['image']['sha256'] ?? null;
                    $whatsappMessage->media_id = $message['image']['id'] ?? null;
                    
                    // Upload to S3
                    $s3Key = $this->uploadMediaToS3($message['image']['id'], 'image', $whatsappMessage->mime_type);
                    if ($s3Key) {
                        $whatsappMessage->media_url = $s3Key;
                    }
                }
                break;

            case 'video':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_VIDEO;
                if (isset($message['video'])) {
                    $whatsappMessage->mime_type = $message['video']['mime_type'] ?? null;
                    $whatsappMessage->sha256 = $message['video']['sha256'] ?? null;
                    $whatsappMessage->media_id = $message['video']['id'] ?? null;
                    
                    // Upload to S3
                    $s3Key = $this->uploadMediaToS3($message['video']['id'], 'video', $whatsappMessage->mime_type);
                    if ($s3Key) {
                        $whatsappMessage->media_url = $s3Key;
                    }
                }
                break;

            case 'document':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_DOCUMENT;
                if (isset($message['document'])) {
                    $whatsappMessage->filename = $message['document']['filename'] ?? null;
                    $whatsappMessage->mime_type = $message['document']['mime_type'] ?? null;
                    $whatsappMessage->sha256 = $message['document']['sha256'] ?? null;
                    $whatsappMessage->media_id = $message['document']['id'] ?? null;
                    
                    // Upload to S3
                    $s3Key = $this->uploadMediaToS3($message['document']['id'], 'document', $whatsappMessage->mime_type, $whatsappMessage->filename);
                    if ($s3Key) {
                        $whatsappMessage->media_url = $s3Key;
                    }
                }
                break;

            case 'audio':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_AUDIO;
                if (isset($message['audio'])) {
                    $whatsappMessage->mime_type = $message['audio']['mime_type'] ?? null;
                    $whatsappMessage->sha256 = $message['audio']['sha256'] ?? null;
                    $whatsappMessage->media_id = $message['audio']['id'] ?? null;
                    // Fix: Handle voice property correctly - it should be boolean
                    $whatsappMessage->voice = isset($message['audio']['voice']) ?
                        (bool)$message['audio']['voice'] : false;
                    
                    // Upload to S3
                    $s3Key = $this->uploadMediaToS3($message['audio']['id'], 'audio', $whatsappMessage->mime_type);
                    if ($s3Key) {
                        $whatsappMessage->media_url = $s3Key;
                    }
                }
                break;

            case 'location':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_LOCATION;
                if (isset($message['location'])) {
                    $whatsappMessage->latitude = (string) $message['location']['latitude'] ?? null;
                    $whatsappMessage->longitude = (string) $message['location']['longitude'] ?? null;
                }
                break;

            default:
                \Yii::warning('Unknown message type: ' . $message['type'], 'whatsapp-webhook');
                $whatsappMessage->message_type = $message['type'];
                $whatsappMessage->content = json_encode($message);
        }

        if ($whatsappMessage->save()) {
            // Update contact last message time
            $contact->last_message_at = date('Y-m-d H:i:s');
            $contact->save(false);

            \Yii::info('Message saved successfully: ' . $message['id'], 'whatsapp-webhook');
        } else {
            \Yii::error('Failed to save message: ' . json_encode($whatsappMessage->errors), 'whatsapp-webhook');
        }
    }

    /**
     * Download media from WhatsApp and upload to S3
     * @param string $mediaId WhatsApp media ID
     * @param string $mediaType Type of media (image, video, document, audio)
     * @param string $mimeType MIME type of the file
     * @param string $filename Original filename (for documents)
     * @return string|null S3 key if successful, null if failed
     */
    protected function uploadMediaToS3($mediaId, $mediaType, $mimeType = null, $filename = null)
    {
        try {
            // Step 1: Get media URL from WhatsApp
            $mediaUrl = $this->getWhatsAppMediaUrl($mediaId);
            if (!$mediaUrl) {
                \Yii::error('Failed to get media URL for media ID: ' . $mediaId, 'whatsapp-webhook');
                return null;
            }

            // Step 2: Download media from WhatsApp
            $mediaContent = $this->downloadMediaFromWhatsApp($mediaUrl);
            if (!$mediaContent) {
                \Yii::error('Failed to download media from WhatsApp: ' . $mediaUrl, 'whatsapp-webhook');
                return null;
            }



            // Step 3: Generate S3 key
            $s3Key = $this->generateS3Key($mediaId, $mediaType, $mimeType, $filename);

            // Step 4: Upload to S3 using Flysystem component
            $wfs = \Yii::$app->wfs;

            try{                
                $success = $wfs->write($s3Key, $mediaContent);
                \Yii::info('Media uploaded to S3 successfully: ' . $s3Key, 'whatsapp-webhook');
                return $s3Key;

            }catch (\Exception $e) {
                \Yii::error('S3 filesystem not configured: ' . $e->getMessage(), 'whatsapp-webhook');
                return null;
            }
           

            // if ($success) {
            //     \Yii::info('Media uploaded to S3 successfully: ' . $s3Key, 'whatsapp-webhook');
            //     return $s3Key;
            // } else {
            //     $lastError = error_get_last();
            //     $errorMessage = $lastError ? $lastError['message'] : 'Unknown error occurred';
            //     \Yii::error('S3 upload failed for key: ' . $s3Key . '. Reason: ' . $errorMessage, 'whatsapp-webhook');
            //     return null;
            // }

        } catch (\Exception $e) {
            \Yii::error('Error uploading media to S3: ' . $e->getMessage(), 'whatsapp-webhook');
            return null;
        }
    }

    /**
     * Get media URL from WhatsApp API
     * @param string $mediaId
     * @return string|null
     */
    protected function getWhatsAppMediaUrl($mediaId)
    {
        $url = "https://graph.facebook.com/v18.0/{$mediaId}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->whatsappAccessToken
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            return $data['url'] ?? null;
        }
        
        \Yii::error('Failed to get media URL. HTTP Code: ' . $httpCode . ', Response: ' . $response, 'whatsapp-webhook');
        return null;
    }

    /**
     * Download media content from WhatsApp
     * @param string $mediaUrl
     * @return string|null
     */
    protected function downloadMediaFromWhatsApp($mediaUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $mediaUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->whatsappAccessToken
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 minutes timeout
        
        $content = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $content !== false) {
            return $content;
        }
        
        \Yii::error('Failed to download media. HTTP Code: ' . $httpCode, 'whatsapp-webhook');
        return null;
    }

    /**
     * Generate S3 key for the media file
     * @param string $mediaId
     * @param string $mediaType
     * @param string $mimeType
     * @param string $filename
     * @return string
     */
    protected function generateS3Key($mediaId, $mediaType, $mimeType = null, $filename = null)
    {
        $date = date('Y/m/d');
        $extension = '';
        
        // Get file extension from filename or mime type
        if ($filename) {
            $extension = '.' . pathinfo($filename, PATHINFO_EXTENSION);
        } elseif ($mimeType) {
            $extension = $this->getExtensionFromMimeType($mimeType);
        }
        
        // Generate S3 key: whatsapp/media_type/year/month/day/media_id.extension
        return "whatsapp/{$mediaType}/{$date}/{$mediaId}{$extension}";
    }

    /**
     * Get file extension from MIME type
     * @param string $mimeType
     * @return string
     */
    protected function getExtensionFromMimeType($mimeType)
    {
        $mimeToExt = [
            'image/jpeg' => '.jpg',
            'image/jpg' => '.jpg',
            'image/png' => '.png',
            'image/gif' => '.gif',
            'image/webp' => '.webp',
            'video/mp4' => '.mp4',
            'video/mpeg' => '.mpeg',
            'video/quicktime' => '.mov',
            'audio/mpeg' => '.mp3',
            'audio/mp4' => '.m4a',
            'audio/ogg' => '.ogg',
            'audio/wav' => '.wav',
            'audio/webm' => '.webm',
            'application/pdf' => '.pdf',
            'application/msword' => '.doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
            'application/vnd.ms-excel' => '.xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
            'text/plain' => '.txt',
        ];
        
        return $mimeToExt[$mimeType] ?? '';
    }

    /**
     * Handle message status updates
     */
    protected function handleMessageStatus($status)
    {
        $message = WhatsappMessages::find()
            ->where(['wamid' => $status['id']])
            ->one();

        if ($message) {
            $oldStatus = $message->status;

            switch ($status['status']) {
                case 'sent':
                    $message->status = WhatsappMessages::STATUS_SENT;
                    break;
                case 'delivered':
                    $message->status = WhatsappMessages::STATUS_DELIVERED;
                    break;
                case 'read':
                    $message->status = WhatsappMessages::STATUS_READ;
                    break;
                case 'failed':
                    $message->status = WhatsappMessages::STATUS_FAILED;
                    break;
                default:
                    \Yii::warning('Unknown status: ' . $status['status'], 'whatsapp-webhook');
                    return;
            }

            if ($message->save()) {
                \Yii::info('Status updated from ' . $oldStatus . ' to ' . $message->status . ' for message: ' . $status['id'], 'whatsapp-webhook');
            } else {
                \Yii::error('Failed to update message status: ' . json_encode($message->errors), 'whatsapp-webhook');
            }
        } else {
            \Yii::warning('Message not found for status update: ' . $status['id'], 'whatsapp-webhook');
        }
    }

    /**
     * Get existing contact or create new one
     * @param array $contactData Contact data from webhook
     * @return WhatsappContacts|null
     */
    protected function getOrCreateContact($contactData)
    {
        if (!isset($contactData['wa_id'])) {
            \Yii::error('Contact data missing wa_id', 'whatsapp-webhook');
            return null;
        }

        $phoneNumber = $contactData['wa_id'];
        $contact = WhatsappContacts::find()
            ->where(['phone_number' => $phoneNumber])
            ->one();

        if (!$contact) {
            $contact = new WhatsappContacts([
                'phone_number' => $phoneNumber,
                'chat_status' => WhatsappContacts::CHAT_STATUS_ACTIVE,
                'status' => 1
            ]);
        }

        // Update contact information if available
        if (isset($contactData['profile'])) {
            if (isset($contactData['profile']['name'])) {
                $contact->name = $contactData['profile']['name'];
            }
            if (isset($contactData['profile']['picture'])) {
                $contact->profile_pic_url = $contactData['profile']['picture'];
            }
        }

        // If name is still not set, use phone number as name
        if (empty($contact->name)) {
            $contact->name = $phoneNumber;
        }

        if ($contact->save()) {
            return $contact;
        } else {
            \Yii::error('Failed to save contact: ' . json_encode($contact->errors), 'whatsapp-webhook');
            return null;
        }
    }
}