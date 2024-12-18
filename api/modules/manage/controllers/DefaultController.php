<?php

namespace api\modules\manage\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use common\interfaces\NewStatusInterface;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Default controller for the `manage` module
 */
class DefaultController extends RestController
{
    public $action_ids = ['index'];

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [

                    'index' => ['GET'],
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
        $safari_operator = $this->module->operatormodel();
        return Yii::$app->api->sendResponse($data = $safari_operator);
    }


    public function actionEditRequest()
    {
        $safari_operator = $this->module->operatormodel();
        $safari_operator_id = $safari_operator->id;

        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $model = new SafariOperatorRequestForm($safari_operator_model);
        $model->user_id = $safari_operator->user_id;
        $model->status = SafariOperator::STATUS_ACTIVE;
        //     $model->action_url = '/manage/default/edit-request';
        //     $model->action_validate_url = '/manage/default/validate';
        $model->referrer_url = \Yii::$app->request->referrer;

        $model->attributes = $this->request;
        $model->logo = UploadedFile::getInstanceByName('logo');
        if ($model->validate()) {
            $model->initializeForm();

            // Revome All Previouse Request if Any Pending for Approval
            SafariOperatorRequest::updateAll(['status' => NewStatusInterface::STATUS_DELETE], ['safari_operator_id' => $safari_operator_model->id, 'status' => 1, 'is_approved' => 0]);

            if ($model->safari_operator_request_model->save(false)) {
                $model->uploadFile();
                $parks = $model->park_id;
                SafariOperatorRequestPark::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                if ($parks) {
                    foreach ($parks as $park) {
                        $safarioperatorrequestpark = new SafariOperatorRequestPark();
                        $safarioperatorrequestpark->safari_operator_request_id = $model->safari_operator_request_model->id;
                        $safarioperatorrequestpark->park_id = $park;
                        $safarioperatorrequestpark->save(false);
                    }
                }


                $activities = $model->offers_other_wildlifeactivities;
                SafariOperatorRequestActivities::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                if ($activities) {
                    foreach ($activities as $activity) {
                        $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
                        $safarioperatorrequestactivity->safari_operator_request_id = $model->safari_operator_request_model->id;
                        $safarioperatorrequestactivity->wildlife_activity_id = $activity;
                        $safarioperatorrequestactivity->save(false);
                    }
                }

                // $to_mail = $model->safari_operator_request_model->email;
                // $subject = 'Information Update Successfully!';
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                // $req = ['username' => $model->safari_operator_request_model->business_name];

                // MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // \Yii::$app->session->setFlash('success', 'Safari Operator Update Request Sent Successfully, Please Wait Until Approval');
                // return $this->redirect(['index']);
                $model->safari_operator_request_model->is_approved = 1;
                if ($model->safari_operator_request_model->save(false)) {
                    $safari_operator = $model->safari_operator_request_model->safariapproved($model->safari_operator_request_model);
                    if ($safari_operator) {
                        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Information Updated Successfully"]);
                    }
                }
            }
        }
    }

    /**
     * Validate Safari Operator Edit Form
     */
    // public function actionValidate()
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $model = new SafariOperatorRequestForm($safari_operator);

    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    /**
     * Business Request
     */
    // public function actionViewrequest($id = null)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $user = Yii::$app->user->identity;
    //     $business_request = SafariOperatorRequest::find()->where(['user_id' => $user->id])->andFilterWhere(['id' => $id])->orderby(['id' => SORT_DESC])->one();
    //     if (!$business_request) {
    //         Yii::$app->session->setFlash('success', 'No Business Request Found!');
    //         return $this->redirect(['index']);
    //     }

    //     return $this->render('viewrequest', [
    //         'user' => $user,
    //         'safari_operator_request' => $business_request,
    //         'safari_operator' => $safari_operator
    //     ]);
    // }
}
