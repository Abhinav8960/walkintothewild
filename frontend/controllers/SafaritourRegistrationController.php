<?php

namespace frontend\controllers;

use common\interfaces\StatusInterface;
use frontend\models\registration\form\SafarotourRegistrationForm;
use frontend\models\registration\SafariOperatorRequestPark;
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
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_request_model->save(false)) {


                        $parks = $model->park_id;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
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
}
