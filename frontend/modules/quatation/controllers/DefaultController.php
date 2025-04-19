<?php

namespace frontend\modules\quatation\controllers;

use Yii;
use frontend\controllers\FrontendBaseController;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    public function actionIndex()
    {       
        $model = new \common\models\quatation\form\QuotationRequestsForm();
        if ($model->load(Yii::$app->request->post())) {          
            if ($model->validate()) {
                if($model->save()){

                    Yii::$app->session->setFlash('success', 'Quotation request submitted successfully.');
                    return $this->redirect(['index']);
                }
                Yii::$app->session->setFlash('error', 'Failed to submit quotation request.');

            } else {
               
                Yii::$app->session->setFlash('error', 'Failed to submit quotation request.');
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
        // return $this->redirect(Yii::$app->request->referrer);
    }

   
}
