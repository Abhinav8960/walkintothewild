<?php

namespace support\modules\whatsapp\controllers;


use common\interfaces\StatusInterface;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetMessages()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \common\whatsapp\models\WhatsappMessage::find()->where(['status' => StatusInterface::STATUS_ACTIVE]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('messages', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSendMessages()
    {
        if (Yii::$app->request->isPost) {
            $message = Yii::$app->request->post('message');
            if ($message) {
                // Logic to send the message via WhatsApp API
                $whatsappApi = new \common\whatsapp\components\WhatsappApi();
                $result = $whatsappApi->sendMessage([
                    'message' => $message,
                    // Add other required parameters like recipient, etc.
                ]);
                if (!$result['success']) {
                    Yii::$app->session->setFlash('error', 'Failed to send message: ' . $result['error']);
                }
                // This is a placeholder for actual sending logic
                Yii::$app->session->setFlash('success', 'Message sent successfully!');
            } else {
                Yii::$app->session->setFlash('error', 'Message cannot be empty.');
            }
        }

        return $this->render('send-messages');
    }
}
