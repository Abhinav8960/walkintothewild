<?php

namespace support\modules\flag\controllers;

use common\models\postscomment\form\UserPostCommentFlagActionForm;
use common\models\postscomment\UserPostComment;
use common\models\postscomment\UserPostCommentFlag;
use common\models\postscomment\UserPostCommentSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * UserPostController.
 */
class UserPostController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserPostCommentSearch();
        $dataProvider = $searchModel->flagedsearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id)
    {
        $user_post_flag_action_model = UserPostCommentFlag::find()->where(['id' => $id])->limit(1)->one();
        $model = new UserPostCommentFlagActionForm($user_post_flag_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_post_flag_action_model->save(false)) {
                        if ($model->user_post_flag_action_model->status == -1) {
                            if ($user_post_comment = $user_post_flag_action_model->comment) {
                                $user_post_comment->deleted_by = UserPostComment::DELETED_BY_ADMIN;  //Main Comment Model it will be set to status also
                                $user_post_comment->status = UserPostComment::STATUS_DELETE;
                                if ($user_post_comment->save()) {
                                    $replies = UserPostComment::find()->where(['parent_id' => $user_post_comment->id, 'status' => 1])->all();
                                    if ($replies) {
                                        foreach ($replies as $rep) {
                                            $rep->deleted_by = UserPostComment::PARENT_DELETED;
                                            $rep->status = UserPostComment::STATUS_DELETE;
                                            $rep->save(false);
                                        }
                                    }
                                    UserPostCommentFlag::updateAll(['status' => 3], ['user_post_comment_id' => $user_post_comment->id, 'status' => 1]);
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
            $model->user_post_flag_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $flag_comment = UserPostComment::find()->where(['id' => $id])->one();
        if (empty($flag_comment)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>  UserPostCommentFlag::find()->where(['user_post_comment_id' => $id, 'status' => 1]),
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
