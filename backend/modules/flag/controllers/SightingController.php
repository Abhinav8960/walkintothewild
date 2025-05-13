<?php

namespace backend\modules\flag\controllers;

use common\models\sighting\form\SightingCommentFlagActionForm;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingCommentFlag;
use common\models\sighting\SightingCommentSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * SightingController.
 */
class SightingController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SightingCommentSearch();
        $dataProvider = $searchModel->flagedsearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id)
    {
        $sighting_flag_action_model = SightingCommentFlag::find()->where(['id' => $id])->limit(1)->one();
        $model = new SightingCommentFlagActionForm($sighting_flag_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->sighting_flag_action_model->save(false)) {
                        if ($model->sighting_flag_action_model->status == -1) {
                            if ($sighting_comment = $sighting_flag_action_model->comment) {
                                $sighting_comment->deleted_by = SightingComment::DELETED_BY_ADMIN;
                                $sighting_comment->status = SightingComment::STATUS_DELETE;
                                if ($sighting_comment->save()) {
                                    $replies = SightingComment::find()->where(['parent_id' => $sighting_comment->id, 'status' => 1])->all();
                                    if ($replies) {
                                        foreach ($replies as $rep) {
                                            $rep->deleted_by = SightingComment::PARENT_DELETED;
                                            $rep->status = SightingComment::STATUS_DELETE;
                                            $rep->save(false);
                                        }
                                    }
                                    SightingCommentFlag::updateAll(['status' => 3], ['sighting_comment_id' => $sighting_comment->id, 'status' => 1]);
                                    \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
                                    return $this->redirect(['index']);
                                }
                            }
                        }
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        } else {
            $model->sighting_flag_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $flag_comment = SightingComment::find()->where(['id' => $id])->one();
        if (empty($flag_comment)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>  SightingCommentFlag::find()->where(['sighting_comment_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'flag_comment' => $flag_comment,
        ]);
    }
}
