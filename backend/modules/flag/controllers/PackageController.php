<?php

namespace backend\modules\flag\controllers;

use common\models\package\form\PackageCommentActionForm;
use common\models\package\PackageComment;
use common\models\package\PackageCommentReport;
use common\models\package\PackageCommentSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\sharesafari\form\FlagActionForm;

/**
 * PackageController.
 */
class PackageController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id)
    {
        $comment_action_model = PackageCommentReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new PackageCommentActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        if ($model->comment_action_model->status == -1) {
                            if ($package_comment = $comment_action_model->comment) {
                                $package_comment->is_deleted = 1;
                                if ($package_comment->save()) {
                                    PackageCommentReport::updateAll(['status' => 3], ['package_comment_id' => $package_comment->id, 'status' => 1]);
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
            $model->comment_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $review = PackageComment::find()->where(['id' => $id])->one();
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>  PackageCommentReport::find()->where(['package_comment_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'review' => $review,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = PackageComment::find()->where(['id' => $id])->one();
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }

        if ($this->request->isPost && isset($_POST['flag_action'])) {
            $post_data = $_POST['flag_action'];
            $is_comment_mark_as_delete = 'mark_as_not_delete';
            foreach ($post_data as $key => $new_status) {
                $flag = PackageCommentReport::findOne($key);
                $flag->status = $new_status;
                if ($flag->save(false)) {
                    if ($new_status == 2 && $is_comment_mark_as_delete = 'mark_as_not_delete') {
                        $comment = PackageComment::findOne($flag->package_comment_id);
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

        $review_flags = PackageCommentReport::find()->where(['package_comment_id' => $id])->orderBy('id DESC')->all();

        return $this->render('flagview', [
            'review' => $review,
            'model' => $model,
            'review_flags' => $review_flags
        ]);
    }
}
