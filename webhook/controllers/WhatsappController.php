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
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        // Handle webhook verification
        // if (isset($_GET['hub_mode']) && $_GET['hub_mode'] === 'subscribe') {
        //     if ($_GET['hub_verify_token'] === "white-elephant") {
        //         echo $_GET['hub_challenge'];
        //         exit;
        //     }
        //     throw new \yii\web\BadRequestHttpException('Invalid verification token');
        // }

        // Get payload
        $payload = file_get_contents('php://input');
        $data = json_decode($payload, true);

        \Yii::info(time() . ' WhatsApp Webhook Payload: ' . $payload, 'whatsapp-webhook');

        if (empty($data['entry'][0]['changes'][0]['value'])) {
            return;
        }

        $value = $data['entry'][0]['changes'][0]['value'];

        try {
            // Handle messages
            if (isset($value['messages'])) {
                foreach ($value['messages'] as $message) {
                    if (!isset($message['id']) || !isset($value['contacts'][0])) {
                        continue;
                    }
                    $this->handleIncomingMessage($value, $message);
                }
            }

            // Handle message status updates
            if (isset($value['statuses'])) {
                foreach ($value['statuses'] as $status) {
                    if (!isset($status['id'])) {
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

        // Create message record
        $whatsappMessage = new WhatsappMessages([
            'wamid' => $message['id'],
            'contact_id' => $contact->id,
            'direction' => WhatsappMessages::DIRECTION_INBOUND,
            'status' => WhatsappMessages::STATUS_DELIVERED
        ]);

        // Handle different message types
        switch ($message['type']) {
            case 'text':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_TEXT;
                $whatsappMessage->content = $message['text']['body'];
                break;
            case 'image':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_IMAGE;
                $whatsappMessage->media_url = $message['image']['id'];
                break;
            case 'video':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_VIDEO;
                $whatsappMessage->media_url = $message['video']['id'];
                break;
            case 'document':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_DOCUMENT;
                $whatsappMessage->media_url = $message['document']['id'];
                break;
            case 'audio':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_AUDIO;
                $whatsappMessage->media_url = $message['audio']['id'];
                break;
            case 'location':
                $whatsappMessage->message_type = WhatsappMessages::MESSAGE_TYPE_LOCATION;
                $whatsappMessage->content = json_encode($message['location']);
                break;
            default:
                $whatsappMessage->message_type = $message['type'];
                $whatsappMessage->content = json_encode($message);
        }

        if ($whatsappMessage->save()) {
            // Update contact last message time
            $contact->last_message_at = date('Y-m-d H:i:s');
            $contact->save(false);
        }
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
            }
            $message->save();
        }
    }

    /**
     * Get existing contact or create new one
     * @param array $contactData Contact data from webhook
     * @return WhatsappContacts
     */
    protected function getOrCreateContact($contactData)
    {
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

        $contact->save();
        return $contact;
    }
}
