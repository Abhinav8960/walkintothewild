<?php

namespace support\modules\whatsapp\controllers;

use common\components\WhatsappApi;
use common\models\whatsapp\WhatsappContacts;
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
    private $pageSize = 15;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-contacts' => ['GET'],
                    'search-contacts' => ['GET'],
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
        $this->whatsappApi = new \common\components\WhatsappApi();
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSearchContacts()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $search = Yii::$app->request->get('search');
            $page = max(1, (int)Yii::$app->request->get('page', 1));

            $query = WhatsappContacts::find()
                ->where(['status' => 1]);

            if (!empty($search)) {
                // Remove special characters and prepare the search term
                $searchTerm = '%' . strtr($search, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%';
                
                $query->andWhere([
                    'or',
                    ['like', 'name', $searchTerm, false],
                    ['like', 'phone_number', $searchTerm, false]
                ]);
            }

            $totalCount = $query->count();
            
            $contacts = $query
                ->orderBy(['last_message_at' => SORT_DESC])
                ->offset(($page - 1) * $this->pageSize)
                ->limit($this->pageSize)
                ->asArray()
                ->all();

            return [
                'success' => true,
                'contacts' => $contacts,
                'hasMore' => ($page * $this->pageSize) < $totalCount,
                'totalCount' => $totalCount,
                'currentPage' => $page
            ];
        } catch (\Exception $e) {
            Yii::error('Error in search contacts: ' . $e->getMessage(), 'whatsapp');
            return [
                'success' => false,
                'error' => 'Failed to search contacts'
            ];
        }
    }

    public function actionGetContacts()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = Yii::$app->request->get('page', 1);


        $query = WhatsappContacts::find()
            ->where(['status' => 1])
            ->orderBy(['last_message_at' => SORT_DESC]);

        $totalCount = $query->count();

        $contacts = $query->offset(($page - 1) * $this->pageSize)
            ->limit($this->pageSize)
            ->asArray()
            ->all();

        return [
            'success' => true,
            'contacts' => $contacts,
            'hasMore' => ($page * $this->pageSize) < $totalCount,
            'totalCount' => $totalCount
        ];
    }

    public function actionGetMessages($contactId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = Yii::$app->request->get('page', 1);


        $contact = WhatsappContacts::findOne($contactId);
        if (!$contact) {
            return ['success' => false, 'error' => 'Contact not found'];
        }

        $query = WhatsappMessages::find()
            ->where(['contact_id' => $contactId])
            ->orderBy(['created_at' => SORT_DESC]);

        $totalCount = $query->count();

        $messages = $query->offset(($page - 1) * $this->pageSize)
            ->limit($this->pageSize)
            ->asArray()
            ->all();

        // Reverse messages to show in chronological order
        $messages = array_reverse($messages);

        return [
            'success' => true,
            'messages' => $messages,
            'hasMore' => ($page * $this->pageSize) < $totalCount,
            'totalCount' => $totalCount
        ];
    }



    public function actionSendMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get raw input data for JSON requests
        $rawData = Yii::$app->request->getRawBody();
        $jsonData = json_decode($rawData, true);

        // Try both JSON and POST data
        $contactId = $jsonData['contact_id'] ?? Yii::$app->request->post('contact_id');
        $message = $jsonData['message'] ?? Yii::$app->request->post('message');
        $type = $jsonData['type'] ?? Yii::$app->request->post('type', 'text');

        // Log received data for debugging
        Yii::debug([
            'rawData' => $rawData,
            'jsonData' => $jsonData,
            'contactId' => $contactId,
            'message' => $message,
            'type' => $type
        ], 'whatsapp');

        if (!$contactId || !$message) {
            return [
                'success' => false,
                'error' => 'Missing required parameters',
                'debug' => [
                    'received_data' => [
                        'contact_id' => $contactId,
                        'message' => $message,
                        'type' => $type
                    ]
                ]
            ];
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

        // Remove duplicate if condition
        if ($result['success']) {
            // Update contact's last message timestamp
            $contact->last_message_at = new \yii\db\Expression('NOW()');
            $contact->save();

            // Save message to database
            $whatsappMessage = new WhatsappMessages([
                'wamid' => $result['message_id'],
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

        // Move this outside the if block
        return [
            'success' => false,
            'error' => $result['error'] ?? 'Failed to send message'
        ];
    }

    // ...existing code...

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
