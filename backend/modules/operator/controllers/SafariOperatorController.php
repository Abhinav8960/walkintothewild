<?php

namespace backend\modules\operator\controllers;


use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorForm;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
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
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariOperator::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdate($id)
    {
        $safarioperator_model = $this->findModel($id);
        $model = new SafariOperatorForm($safarioperator_model);
        $model->status = StatusInterface::STATUS_ACTIVE;
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
                            SafariOperatorPark::updateAll(['status' => 2], ['safari_operator_id' => $model->safarioperator_model->id]);
                            foreach ($parks as $park) {
                                $safarioperatorpark = new SafariOperatorPark();
                                $safarioperatorpark->safari_operator_id = $model->safarioperator_model->id;
                                $safarioperatorpark->park_id = $park;
                                $safarioperatorpark->save(false);
                            }
                        }
                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            SafariOperatorActivities::updateAll(['status' => 2], ['safari_operator_id' => $model->safarioperator_model->id]);
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



    public function actionValidate($id = null)
    {
        $model = new SafariOperatorForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new SafariOperatorForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
