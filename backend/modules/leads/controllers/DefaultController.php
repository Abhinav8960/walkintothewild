<?php

namespace backend\modules\leads\controllers;

use common\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends  Controller
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'quotation', 'quotation-validate'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'quotation', 'quotation-validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LeadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams, 87);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $quotations = $model->quotation;
        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove()
    {
        $id = Yii::$app->request->post('id');
        $paymentUrl = Yii::$app->request->post('payment_url');

        $quotation = LeadPartnerQuotes::findOne($id);
        $installment = LeadPartnerQuoteInstallments::find()->where(['lead_partner_quote_id' => $id])->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($quotation) {
                $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_APPROVED; // Update status to approved
                $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s'); // Update status to approved
                $installment->payment_link = $paymentUrl; // Save the payment URL
                $quotation->save();
                $installment->save(false);
                $this->prepareChat($quotation);
            }
            $transaction->commit();
            return $this->asJson(['success' => true]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->asJson(['success' => false, 'message' => 'Failed to approve the quotation.']);
        }
    }

    public function actionDisapprove()
    {
        $id = Yii::$app->request->post('id');
        $reason = Yii::$app->request->post('reason');

        $quotation = LeadPartnerQuotes::findOne($id);
        if ($quotation) {
            $quotation->is_approved_by_admin = LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_REJECT; // Update status to approved
            $quotation->datetime_of_approval_by_admin = date('Y-m-d H:i:s'); // Update status to approved
            ; // Update status to disapproved
            $quotation->rejection_reason = $reason; // Save the rejection reason
            if ($quotation->save()) {
                return $this->asJson(['success' => true]);
            } else {
                return $this->asJson(['success' => false, 'message' => 'Failed to disapprove the quotation.']);
            }
        }
        return $this->asJson(['success' => false, 'message' => 'Quotation or chat not found.']);
    }

    private function prepareChat($quotation)
    {

        $chat_model = Chat::find()->andWhere(['lead_id' => $quotation->lead_id])->andWhere(['or', ['user_id' => [$quotation->lead->user_id, $quotation->partner_id]], ['recipient_user_id' => [$quotation->lead->user_id, $quotation->partner_id]]])->andWhere(['chat_type' => 2])->one();
        if (!$chat_model) {
            return Yii::$app->api->sendFailedResponse([], 'you can not send quote on this chat', 400);
        }

        $message = "Safaris: " . $quotation->safaris;

        if (isset($quotation->lead->park->title)) {
            $message = "Park: " . $quotation->lead->park->title;
            $message .= "Safaris: " . $quotation->safari;
        }
        $message .= "<br>";
        $message .= "Travelers: " . $quotation->travelers;
        $message .= "<br>";
        $message .= "Stay Category: " . @\common\models\GeneralModel::staycategoryoption()[$quotation->stay_category_id];
        $message .= "<br>";
        $message .= "Start Date: " . date('M d, Y', strtotime($quotation->start_date));
        $message .= "<br>";
        $message .= "End Date: " . date('M d, Y', strtotime($quotation->end_date));
        $message .= "<br>";
        $message .= "<b>Note</b>";
        $message .= "<br>";
        $x = \api\models\leads\LeadPartnerQuotes::find()->where(['id' => $quotation->id])->one();
        $data = $x->preparedata;
        // $this->storeMessage($chat_model->id, $quotation->lead->user_id, $message, $data);
        $chat_message = new ChatMessage();
        $chat_message->chat_id = $chat_model->id;
        $chat_message->message = $message;
        $chat_message->data = json_encode($data);
        $chat_message->status = 1;
        $chat_message->created_by = $quotation->partner->user_id;
        $chat_message->updated_by = $quotation->partner->user_id;

        if ($chat_message->save(false)) {
            $chat_message->created_by = $quotation->partner->user_id;
            $chat_message->updated_by = $quotation->partner->user_id;
            $chat_message->save(false);
            $chat = Chat::find()->where(['id' => $chat_model->id])->one();
            $chat->last_message = $message;
            $chat->last_message_at = time();
            $chat->status = 1;
            $chat->is_seen = 0;
            $chat->created_at = time();
            return $chat->save(false);
        }

        return false;
    }
}
