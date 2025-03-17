<?php

namespace backend\modules\moderation\controllers;

use common\models\moderation\form\ModerationForm;
use yii\web\Controller;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionCreate()
    {
        $model = new ModerationForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->moderation_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Extracted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->moderation_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
