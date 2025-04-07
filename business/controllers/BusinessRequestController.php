<?php

namespace business\controllers;

use common\models\business\businessrequest\BusinessRequest;
use common\models\business\businessrequest\form\BusinessRequestForm;
use Yii;
use yii\web\Controller;

/**
 * BusinessRequestController.
 */
class BusinessRequestController extends Controller
{
    public function actionCreate()
    {
        $this->layout = 'blank';

        $model = new BusinessRequestForm();
        $model->status = BusinessRequest::STATUS_ACTIVE;
        $model->is_approved = 0;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->business_request_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Request Submitted Successfully');
                        return $this->redirect(['/']);
                    }
                }
            }
        } else {
            $model->business_request_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
