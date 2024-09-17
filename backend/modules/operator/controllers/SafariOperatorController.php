<?php

namespace backend\modules\operator\controllers;


use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorDeleteForm;
use common\models\operator\form\SafariOperatorForm;
use common\models\operator\OperatorQuoteSearch;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorFollowSearch;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\operator\SafariOperatorSearch;

/**
 * SafariOperatorController.
 */
class SafariOperatorController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariOperatorSearch();
        // $searchModel->report_days = 'today';
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View Operator
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * View Operator
     */
    public function actionQuote($id)
    {
        $model = $this->findModel($id);
        $searchModel = new OperatorQuoteSearch();
        $searchModel->operator_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('free_quote', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View Operator
     */
    public function actionSharedsafari($id)
    {
        $model = $this->findModel($id);
        return $this->render('shared_safari', ['model' => $model]);
    }

    /**
     * View Operator
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);

        $searchModel = new SafariOperatorRatingSearch();
        $searchModel->safari_operator_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('user_review', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * View Operator
     */
    public function actionFlagview($id, $safari_operator_id)
    {

        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = $this->findModel($safari_operator_id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }
    /**
     * View Operator
     */
    public function actionFollower($id)
    {
        $searchModel = new SafariOperatorFollowSearch();
        $searchModel->safari_operator_id = $id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = $this->findModel($id);

        return $this->render('follower', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = SafariOperator::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = SafariOperator::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariOperator::findOne(['id' => $id, 'status' => [SafariOperator::STATUS_ACTIVE, SafariOperator::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdate($id)
    {
        $safarioperator_model = $this->findModel($id);
        $model = new SafariOperatorForm($safarioperator_model);
        $model->status = SafariOperator::STATUS_ACTIVE;
        $model->action_url = '/operator/safari-operator/update?id=' . $id . '';
        $model->action_validate_url = '/operator/safari-operator/validate?id=' . $id . '';

        $model->referrer_url = \Yii::$app->request->referrer;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            SafariOperatorPark::updateAll(['status' => SafariOperatorPark::STATUS_SUSPEND], ['safari_operator_id' => $model->safarioperator_model->id]);
                            foreach ($parks as $park) {
                                $safarioperatorpark = new SafariOperatorPark();
                                $safarioperatorpark->safari_operator_id = $model->safarioperator_model->id;
                                $safarioperatorpark->park_id = $park;
                                $safarioperatorpark->save(false);
                            }
                        }
                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            SafariOperatorActivities::updateAll(['status' => SafariOperatorActivities::STATUS_SUSPEND], ['safari_operator_id' => $model->safarioperator_model->id]);
                            foreach ($activities as $activity) {
                                $safarioperatoractivity = new SafariOperatorActivities();
                                $safarioperatoractivity->safari_operator_id = $model->safarioperator_model->id;
                                $safarioperatoractivity->wildlife_activity_id = $activity;
                                $safarioperatoractivity->save(false);
                            }
                        }

                        $to_mail = $model->safarioperator_model->email;
                        $subject = 'Safari Tour Operator Submission Received: Let`s Walk into the Wild!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->safarioperator_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        \Yii::$app->session->setFlash('success', 'Safari Operator Update Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safarioperator_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    public function actionValidate($id)
    {
        $formmodel = $this->findModel($id);
        $model = new SafariOperatorForm($formmodel);


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionDelete($id)
    {
        $safari_operator_delete_model = $this->findModel($id);
        $model = new SafariOperatorDeleteForm($safari_operator_delete_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_operator_delete_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_operator_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }
}
