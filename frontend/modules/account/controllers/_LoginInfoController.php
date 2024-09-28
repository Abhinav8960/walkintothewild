<?php

namespace frontend\modules\account\controllers;

use frontend\models\profile\ChangePasswordForm;
use Yii;

/**
 * Login Info controller for the `account` module
 */
class LoginInfoController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user_model = Yii::$app->user->identity;
        $model = new ChangePasswordForm($user_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Password Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
