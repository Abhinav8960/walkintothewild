<?php

namespace backend\modules\operatordashboard\controllers;

use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorRequestForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use yii\web\UploadedFile;

/**
 * Safari controller for the `operatordashboard` module
 */
class SafariController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator = $this->findModel();

        return $this->render('index', ['safari_operator' => $safari_operator]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionParklist()
    {
        $safari_operator = $this->findModel();

        return $this->render('parklist', ['safari_operator' => $safari_operator]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionQuote()
    {
        $safari_operator = $this->findModel();

        $query = OperatorQuote::find()->where(['operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('quote', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSharedsafari()
    {
        $safari_operator = $this->findModel();

        return $this->render('sharedsafari', ['safari_operator' => $safari_operator]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionReview()
    {
        $safari_operator = $this->findModel();
        $query = SafariOperatorRating::find()->where(['safari_operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('review', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionFollower()
    {
        $safari_operator = $this->findModel();
        $query = SafariOperatorFollow::find()->where([
            'safari_operator_id' => $safari_operator->id,
            'status' => 1
        ]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('follower', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * Find Model of Operator
     */
    protected function findModel()
    {
        if (($model = SafariOperator::findOne(['user_id' => Yii::$app->user->identity->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // /**
    //  * Renders the index view for the module
    //  * @return string
    //  */
    // public function actionUpdateRequest()
    // {

    //     $safari_operator = $this->findModel();
    //     $searchModel = new SafariOperatorRequestSearch();
    //     $searchModel->safari_operator_id = $safari_operator->id;
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     return $this->render('update', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //         'safari_operator_id' => $safari_operator->id,
    //     ]);
    // }

    public function actionEditRequest($safari_operator_id)
    {
        $searchModel = new SafariOperatorRequestSearch();
        $searchModel->safari_operator_id = $safari_operator_id;
        $dataProvider = $searchModel->search($this->request->queryParams);



        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $model = new SafariOperatorRequestForm($safari_operator_model);
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/operatordashboard/safari/edit-request?safari_operator_id=' . $safari_operator_id . '';
        $model->action_validate_url = '/operatordashboard/safari/validate?safari_operator_id=' . $safari_operator_id . '';
        $model->referrer_url = \Yii::$app->request->referrer;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                if ($model->validate()) {
                    $model->initializeForm();

                    // Revome All Previouse Request if ANy Pending for Approval
                    SafariOperatorRequest::updateAll(['status' => StatusInterface::STATUS_DELETE], ['safari_operator_id' => $safari_operator_model->id, 'status' => 1, 'is_approved' => 0]);

                    if ($model->safari_operator_request_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            SafariOperatorRequestPark::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safari_operator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            SafariOperatorRequestActivities::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                            foreach ($activities as $activity) {
                                $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
                                $safarioperatorrequestactivity->safari_operator_request_id = $model->safari_operator_request_model->id;
                                $safarioperatorrequestactivity->wildlife_activity_id = $activity;
                                $safarioperatorrequestactivity->save(false);
                            }
                        }

                        $to_mail = $model->safari_operator_request_model->email;
                        $subject = 'Information Update Successfully!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->safari_operator_request_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        \Yii::$app->session->setFlash('success', 'Safari Operator Update Request Sent Successfully, Please Wait Until Approval');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_operator_request_model->loadDefaultValues();
        }

        return $this->render('edit', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionValidate($safari_operator_id = null)
    {

        if ($safari_operator_id != null) {
            $safari_operator_request_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
            $model = new SafariOperatorRequestForm($safari_operator_request_model);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    public function actionViewrequest($id)
    {
        $model = SafariOperatorRequest::find()->where(['id' => $id])->limit(1)->one();
        return $this->render('viewrequest', ['model' => $model]);
    }
}
