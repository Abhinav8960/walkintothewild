<?php

namespace backend\modules\moderation\controllers;

use common\models\moderation\form\ModerationForm;
use Yii;
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
                    if ($model->moderation_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Extracted Successfully');
                        if ($model->moderation_model->type == 1) {
                            Yii::$app->moderation->textFeedback($model->moderation_model->text, $model->moderation_model->id);
                        } elseif ($model->moderation_model->type == 2) {
                            Yii::$app->moderation->videoFeedback($model->moderation_model->video_url, $model->moderation_model->id);
                        } elseif ($model->moderation_model->type == 3) {
                            Yii::$app->moderation->imageFeedback($model->moderation_model->image_url, $model->moderation_model->id);
                        }
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
