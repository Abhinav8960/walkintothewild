<?php

namespace support\modules\whatsapp\controllers;

use common\components\WhatsappApi;
use common\models\whatsapp\WhatsappContacts;
use common\models\whatsapp\WhatsappConversations;
use common\models\whatsapp\WhatsappMessages;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class DefaultController extends Controller
{
    private $whatsappApi;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-contacts' => ['GET'],
                    'get-messages' => ['GET'],
                    'send-message' => ['POST'],
                    'mark-as-read' => ['POST'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->whatsappApi = new WhatsappApi();
    }
    
    public function actionIndex()
    {
        $contacts = WhatsappContacts::find()
            ->where(['status' => 1])
            ->all();

        return $this->render('index', [
            'contacts' => $contacts
        ]);
    }

    public function actionGetContacts()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $contacts = WhatsappContacts::find()
            ->where(['status' => 1])
            ->asArray()
            ->all();

        return ['success' => true, 'contacts' => $contacts];
    }

    public function actionGetMessages($contactId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $conversation = WhatsappConversations::find()
            ->where(['contact_id' => $contactId])
            ->one();

        if (!$conversation) {
            return ['success' => false, 'error' => 'Conversation not found'];
        }

        $messages = WhatsappMessages::find()
            ->where(['conversation_id' => $conversation->id])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();

        return ['success' => true, 'messages' => $messages];
    }

    public function actionSendMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $contactId = Yii::$app->request->post('contact_id');
        $message = Yii::$app->request->post('message');
        $type = Yii::$app->request->post('type', 'text');

        if (!$contactId || !$message) {
            return ['success' => false, 'error' => 'Missing required parameters'];
        }

        $contact = WhatsappContacts::findOne($contactId);
        if (!$contact) {
            return ['success' => false, 'error' => 'Contact not found'];
        }

        // Send message via API
        $result = $this->whatsappApi->sendMessage([
            'phone_number' => $contact->phone_number,
            'message' => $message,
            'type' => $type
        ]);

        if ($result['success']) {
            // Save message to database
            $conversation = WhatsappConversations::find()
                ->where(['contact_id' => $contactId])
                ->one();

            if (!$conversation) {
                $conversation = new WhatsappConversations([
                    'contact_id' => $contactId,
                    'status' => 'active'
                ]);
                $conversation->save();
            }

            $whatsappMessage = new WhatsappMessages([
                'wamid' => $result['message_id'],
                'conversation_id' => $conversation->id,
                'contact_id' => $contactId,
                'direction' => 'outbound',
                'message_type' => $type,
                'content' => $message,
                'status' => 'sent'
            ]);

            if ($whatsappMessage->save()) {
                return [
                    'success' => true,
                    'message' => $whatsappMessage->attributes
                ];
            }
        }

        return [
            'success' => false,
            'error' => $result['error'] ?? 'Failed to send message'
        ];
    }

    public function actionMarkAsRead()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $messageId = Yii::$app->request->post('message_id');
        if (!$messageId) {
            return ['success' => false, 'error' => 'Message ID is required'];
        }

        $message = WhatsappMessages::findOne($messageId);
        if (!$message) {
            return ['success' => false, 'error' => 'Message not found'];
        }

        $message->status = 'read';
        if ($message->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => 'Failed to mark message as read'];
    }
}
