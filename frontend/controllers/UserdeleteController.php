<?php

namespace frontend\controllers;

use common\models\UserDeleteRequestForm;
use Yii;

/**
 * UserdeleteController
 */
class UserdeleteController extends FrontendBaseController
{

    public function actionIndex()
    {
        $model = new UserDeleteRequestForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_delete_request->save()) {
                        \Yii::$app->session->setFlash('success', 'Your Information Will be deleted in upcoming 90 Days!!!');
                        return $this->redirect(['/']);
                    }
                }
            }
        }

        return $this->render('user_delete_form', [
            'model' => $model,
        ]);
    }
}
