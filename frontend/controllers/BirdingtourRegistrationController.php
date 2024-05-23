<?php

namespace frontend\controllers;

use common\interfaces\StatusInterface;
use frontend\models\registration\BirdingOperatorRequestActivities;
use frontend\models\registration\BirdingOperatorRequestPark;
use frontend\models\registration\form\BirdingtourRegistrationForm;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 *  Home controller
 */
class BirdingtourRegistrationController extends Controller
{
    /**
     * Displays profile Page.
     *
     * @return mixed
     */
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new BirdingtourRegistrationForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

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
            $model->birdingoperator_request_model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
