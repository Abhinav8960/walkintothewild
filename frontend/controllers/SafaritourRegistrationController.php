<?php

namespace frontend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\SafariOperator;
use frontend\models\registration\form\SafaritourRegistrationForm;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;

/**
 *  Home controller
 */
class SafaritourRegistrationController extends FrontendBaseController
{

    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['/site/auth?authclient=google']);
        }
        if (Yii::$app->user->identity) {
            if (($model = SafariOperator::findOne(['user_id' => Yii::$app->user->identity->id])) !== null) {
                return $this->redirect([Yii::$app->params['backend_url']]);
            }
        }
        $model = new SafaritourRegistrationForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/safaritour-registration';
        $model->action_validate_url = '/safaritour-registration/validate';

        $model->referrer_url = \Yii::$app->request->referrer;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_request_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            foreach ($activities as $activity) {
                                $safarioperatorrequestpark = new SafariOperatorRequestActivities();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->wildlife_activity_id = $activity;
                                $safarioperatorrequestpark->save(false);
                            }
                        }

                        $to_mail = $model->safarioperator_request_model->email;
                        // $subject = 'Welcome to ' . $model->safarioperator_request_model->business_name . ' – Your Registration is Successful!';
                        $subject = 'Safari Tour Operator Submission Received: Let`s Walk into the Wild!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->safarioperator_request_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        //$model->uploadFile();
                        // \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/thankyou']);
                    }
                }
            }
        } else {
            $model->safarioperator_request_model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }





    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $model = new SafaritourRegistrationForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new SafaritourRegistrationForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
