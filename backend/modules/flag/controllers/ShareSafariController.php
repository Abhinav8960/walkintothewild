<?php

namespace backend\modules\flag\controllers;

use common\models\sharesafari\form\ShareSafariCommentActionForm;
use common\models\sharesafari\form\FlagActionForm;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariCommentSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ShareSafariController.
 */
class ShareSafariController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id)
    {
        $comment_action_model = ShareSafariCommentReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new ShareSafariCommentActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->comment_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {

        $dataProvider = new ActiveDataProvider([
            'query' =>  ShareSafariCommentReport::find()->where(['share_safari_comment_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('view', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = ShareSafariComment::find()->where(['id' => $id])->one();
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        if ($this->request->isPost && isset($_POST['flag_action'])) {
            $post_data = $_POST['flag_action'];
            $is_comment_mark_as_delete = 'mark_as_not_delete';
            foreach ($post_data as $key => $new_status) {
                $flag = ShareSafariCommentReport::findOne($key);
                $flag->status = $new_status;
                if ($flag->save(false)) {
                    if ($new_status == 2 && $is_comment_mark_as_delete = 'mark_as_not_delete') {
                        $comment = ShareSafariComment::findOne($flag->share_safari_comment_id);
                        $comment->status = $new_status;
                        if ($comment->save()) {
                            $is_comment_mark_as_delete = 'mark_as_delete';
                        }
                    }
                }
            }
            \Yii::$app->session->setFlash('success', 'Action Taken Successfully');
        }

        //form model
        $model = new FlagActionForm();

        $review_flags = ShareSafariCommentReport::find()->where(['share_safari_comment_id' => $id])->orderBy('id DESC')->all();

        return $this->render('flagview', [
            'review' => $review,
            'model' => $model,
            'review_flags' => $review_flags
        ]);
    }
}
