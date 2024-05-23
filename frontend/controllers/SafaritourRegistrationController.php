<?php

namespace frontend\controllers;

use common\interfaces\StatusInterface;
use frontend\models\registration\form\SafarotourRegistrationForm;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;
use yii\web\UploadedFile;
use yii\web\Controller;

/**
 *  Home controller
 */
class SafaritourRegistrationController extends Controller
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new SafarotourRegistrationForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

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
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/coming-soon']);
                    }
                } else {
                    print_r($model->errors);
                    exit();
                }
            }
        } else {
            $model->safarioperator_request_model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
