<?php

namespace frontend\controllers;

use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\RenderedContent;
use frontend\models\registration\BirdingOperatorRequestActivities;
use frontend\models\registration\BirdingOperatorRequestPark;
use frontend\models\registration\form\BirdingtourRegistrationForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 *  Home controller
 */
class BirdingtourRegistrationController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new BirdingtourRegistrationForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/birdingtour-registration';
        $model->action_validate_url = '/birdingtour-registration/validate';

        $model->referrer_url = \Yii::$app->request->referrer;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birdingoperator_request_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $birdingoperatorrequestpark = new BirdingOperatorRequestPark();
                                $birdingoperatorrequestpark->birding_operator_request_id = $model->birdingoperator_request_model->id;
                                $birdingoperatorrequestpark->park_id = $park;
                                $birdingoperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            foreach ($activities as $activity) {
                                $birdingoperatorrequestactivity = new BirdingOperatorRequestActivities();
                                $birdingoperatorrequestactivity->birding_operator_request_id = $model->birdingoperator_request_model->id;
                                $birdingoperatorrequestactivity->wildlife_activity_id = $activity;
                                $birdingoperatorrequestactivity->save(false);
                            }
                        }

                        $to_mail = $model->birdingoperator_request_model->email;
                        // $subject = 'Welcome to ' . $model->birdingoperator_request_model->business_name . ' – Your Registration is Successful!';
                        $subject = 'Birding Tour Operator Submission Received: Let`s Walk into the Wild!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_BIRDING_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->birdingoperator_request_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        //$model->uploadFile();
                        // \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/thankyou']);
                    }
                }
            }
        } else {
            $model->birdingoperator_request_model->loadDefaultValues();
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
        $model = new BirdingtourRegistrationForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new BirdingtourRegistrationForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
