<?php

namespace frontend\controllers;

use frontend\models\profile\UserForm;
use Yii;
use yii\web\UploadedFile;


/**
 * RareAnimalController.
 */
class UserController extends FrontendBaseController
{

    protected function findModel()
    {
        return Yii::$app->user->identity;
    }

    public function actionUpdate()
    {
        $user_model = $this->findModel();
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
                        return $this->redirect(['update']);
                    }
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            //'imagepath' => $model->imagepath,
        ]);
    }
}
