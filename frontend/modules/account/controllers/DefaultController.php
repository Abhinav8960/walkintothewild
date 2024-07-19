<?php

namespace frontend\modules\account\controllers;

use Yii;
use yii\web\UploadedFile;
use frontend\models\profile\UserForm;

/**
 * Default controller for the `account` module
 */
class DefaultController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user_model = Yii::$app->user->identity;
        $model = new UserForm($user_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->profile_image = UploadedFile::getInstance($model, 'profile_image');
                $model->cover_image = UploadedFile::getInstance($model, 'cover_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
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
