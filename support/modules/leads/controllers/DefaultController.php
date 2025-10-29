<?php

namespace support\modules\leads\controllers;

use api\models\chat\Chat as ApiChat;
use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use api\models\partnergallery\PartnerGallerySearch;
use common\models\chat\form\ChatForm;
use common\models\chat\form\GalleryChatForm;
use common\models\leads\form\LeadPartnerQuotationForm;
use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuotes;
use common\models\leads\LeadPartners;
use common\models\leads\LeadSearch;
use common\models\operator\SafariOperator;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGalleryVersion;
use common\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
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
                        // 'allow' => $this->isOwner(),
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
    public function actionIndex($custom_status = null)
    {
        $searchModel = new LeadSearch();
        $searchModel->custom_status = isset($custom_status) ? $custom_status : 3;
        $dataProvider = $searchModel->supportsearch(Yii::$app->request->queryParams);

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
        $calllogs = \common\models\CallLog::find()->where(['call_source' => 'support_lead', 'lead_id' => $model->id])->orderby(['id' => SORT_DESC])->all();

        return $this->render('view', [
            'model' => $model,
            'quotations' => $quotations,
            'calllogs' => $calllogs,
        ]);
    }

    public function actionPartnerLeadChat($id, $safari_operator_id)
    {
        $model = $this->findModel($id);
        $quotations = $model->quotation;
        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $chat = ApiChat::find()->where(['lead_id' => $id])->andwhere(['or', ['user_id' => $safari_operator_model->user_id], ['recipient_user_id' => $safari_operator_model->user_id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();
        $calllogs = \common\models\CallLog::find()->where(['call_source' => 'support_lead', 'lead_id' => $model->id])->orderby(['id' => SORT_DESC])->all();

        return $this->render(
            'view',
            [
                'model' => $model,
                'quotations' => $quotations,
                'chat' => $chat,
                'safari_operator_model' => $safari_operator_model,
                'calllogs' => $calllogs,
            ]
        );
    }

    public function actionMakeacall($id)
    {
        $lead_model = $this->findModel($id);

        // Example parameters
        $transaction = Yii::$app->db->beginTransaction();
        try {

            if (!$lead_model->user->is_mobile_no_verified) {
                $message = Yii::$app->messageCache->getMessage('common.chat.user_number_not_verified');
                \Yii::$app->session->setFlash('error', $message);
                return $this->redirect(Yii::$app->request->referrer);
            }

            if (!Yii::$app->user->identity->is_mobile_no_verified) {
                $message = Yii::$app->messageCache->getMessage('common.chat.user_number_not_verified');
                \Yii::$app->session->setFlash('error', $message);
                return $this->redirect(Yii::$app->request->referrer);
            }


            $fromCLI = null;
            $has_direct_call = false;
            $chat_id = NULL;
            $lead_id = $lead_model->id;
            $call_initiated_user_id = Yii::$app->user->identity->id; // Example user ID who initiated the call
            $operator_user_id =  NULL; // Example operator user ID
            $call_initiated_partner_id = NULL; // can be null
            $request_caller_1_no = $lead_model->user->mobile_no;
            $request_caller_1_user_id = $lead_model->user->id;
            $request_caller_2_no = Yii::$app->user->identity->mobile_no; // Optional
            $request_caller_2_user_id = Yii::$app->user->identity->id; // Optional
            $call_source = 'support_lead';
            // Instantiate the CallingService
            $callingService = new \common\calling\services\CallingService(
                $chat_id,
                $lead_id,
                $operator_user_id,
                $call_initiated_user_id,
                $call_initiated_partner_id,
                $request_caller_1_no,
                $request_caller_1_user_id,
                $request_caller_2_no,
                $request_caller_2_user_id,
                $has_direct_call,
                $fromCLI,
                $call_source
            );
            // Call the callNow method
            $result = $callingService->callNowImmediately();
            $call_model = $callingService->call_model;
            if ($call_model) {
                $lead_model->support_call_count++;
                $lead_model->save(false);
            }
            $transaction->commit();
            return $this->redirect(Yii::$app->request->referrer);
        } catch (\Exception $e) {
            $transaction->rollBack();
            $message = Yii::$app->messageCache->getMessage('common.chat.call_initiation_failed');
            \Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdatecall($id, $call_log_id)
    {
        $lead_model = $this->findModel($id);
        $call_log = \common\models\CallLog::find()->where(['call_source' => 'support_lead', 'lead_id' => $id, 'id' => $call_log_id])->one();
        $model = new DynamicModel(['support_user_note']);
        $model->addRule(['support_user_note'], 'string', ['max' => 1000]);
        $model->support_user_note = $call_log->support_user_note;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $call_log->support_user_note = $model->support_user_note;
                if ($call_log->save(false)) {
                    $message = Yii::$app->messageCache->getMessage('common.updated',['{var}' => 'Call Detail']);
                    \Yii::$app->session->setFlash('success', $message);
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
        }
        return $this->render('_updatecall', [
            'model' => $model,
            'lead_model' => $lead_model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    private function isOwner()
    {
        $id = \Yii::$app->request->get('id');
        if (!empty($id)) {
            return Lead::find()->where([Lead::getTableSchema()->fullName . '.id' => $id])->joinWith(['assignOperator' => function ($q) {
                $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => \Yii::$app->user->identity->operator->id]);
                // $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => 87]);
            }])->exists();
        }
        return false;
    }

    public function actionUserList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $users = User::find()
            ->select(['id', 'name', 'email'])
            ->where(['status' => User::STATUS_ACTIVE])
            ->andFilterWhere([
                'or',
                ['like', 'name', $q],
                ['like', 'mobile_no', $q],
                ['like', 'username', $q],
                ['like', 'email', $q]
            ])
            ->orderBy(['name' => SORT_ASC])
            ->limit(20)
            ->asArray()
            ->all();

        $results = [];

        foreach ($users as $user) {
            $results[] = [
                'id' => $user['id'],
                'text' => $user['name'] . ' (' . $user['email'] . ')', // Show name with email in brackets
            ];
        }

        return ['results' => $results];
    }
}
