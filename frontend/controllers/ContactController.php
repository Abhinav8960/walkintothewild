<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;

/**
 * Contact controller
 */
class ContactController extends Controller
{
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->contactquery();
                Yii::$app->session->setFlash('success', 'Query Successfully submitted');
                return $this->redirect('/park');
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
