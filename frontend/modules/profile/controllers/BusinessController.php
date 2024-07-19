<?php

namespace frontend\modules\profile\controllers;

use Yii;
use yii\web\UploadedFile;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use frontend\controllers\FrontendBaseController;

/**
 * BusinessController.
 */
class BusinessController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->is_safari_operator != 1) {
            return $this->redirect(['/']);
        }

        $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id])->limit(1)->one();
        $query = OperatorQuote::find()->where(['operator_id' => $safari_operator->id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $review_query = SafariOperatorRating::find()->where(['safari_operator_id' => $safari_operator->id]);
        $review_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $review_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        $follow_query = SafariOperatorFollow::find()->where([
            'safari_operator_id' => $safari_operator->id,
            'status' => 1
        ]);
        $follow_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $follow_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'user' => $this->module->user(),
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider,
            'review_dataProvider' => $review_dataProvider,
            'follow_dataProvider' => $follow_dataProvider
        ]);
    }

    public function actionFlagview($id)
    {
        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id])->limit(1)->one();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'safari_operator' => $safari_operator,
            ]);
        }
    }

    public function actionEditRequest($safari_operator_id)
    {
        $searchModel = new SafariOperatorRequestSearch();
        $searchModel->safari_operator_id = $safari_operator_id;
        $searchModel->user_id = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search($this->request->queryParams);



        $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
        $model = new SafariOperatorRequestForm($safari_operator_model);
        $model->user_id = Yii::$app->user->identity->id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/profile/business/edit-request?safari_operator_id=' . $safari_operator_id . '';
        $model->action_validate_url = '/profile/business/validate?safari_operator_id=' . $safari_operator_id . '';
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
                        SafariOperatorRequestPark::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                        if ($parks) {
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safari_operator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        SafariOperatorRequestActivities::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
                        if ($activities) {
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
            'user' => $this->module->user(),
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
}
