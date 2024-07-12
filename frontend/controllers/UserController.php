<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\profile\UserForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RareAnimalController.
 */
class UserController extends Controller
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
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save(false)) {
                        $model->uploadFile($model->user_model->id);
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
