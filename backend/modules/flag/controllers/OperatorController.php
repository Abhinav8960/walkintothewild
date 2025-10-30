<?php

namespace backend\modules\flag\controllers;

use common\models\operator\form\SafariOperatorRatingActionForm;
use common\models\operator\SafariOperatorRatingReport;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\operator\SafariOperatorRating;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\sharesafari\form\FlagActionForm;

/**
 * OperatorController.
 */
class OperatorController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariOperatorRatingSearch();
        $searchModel->flaged = 1;
        $searchModel->is_deleted = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id)
    {
        $comment_action_model = SafariOperatorRatingReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new SafariOperatorRatingActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        if ($model->comment_action_model->status == -1) {
                            if ($safari_operator_rating = $comment_action_model->rating) {
                                $safari_operator_rating->is_deleted = 1;
                                if ($safari_operator_rating->save()) {
                                    SafariOperatorRatingReport::updateAll(['status' => 3], ['safari_operator_rating_id' => $safari_operator_rating->id, 'status' => 1]);
                                    if ($operator = $safari_operator_rating->operator) {
                                        $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id, 'is_deleted' => 0])->average('rating');
                                        $count = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id, 'is_deleted' => 0])->count();
                                        $operator->google_rating = $avg;
                                        $operator->google_review_count = $count;
                                        $operator->save(false);
                                        $message = Yii::$app->messageManager->getMessage('common.successfully',['{var}' => 'Action Taken']);
                                        \Yii::$app->session->setFlash('success', $message);
                                        return $this->redirect(['index']);
                                    }
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
        $review = SafariOperatorRating::find()->where(['id' => $id])->one();
        if (empty($review)) {
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>  SafariOperatorRatingReport::find()->where(['safari_operator_rating_id' => $id, 'status' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'review' => $review

        ]);
    }

    public function actionFlagview($id)
    {
        $review = SafariOperatorRating::find()->where(['id' => $id])->one();
        if (empty($review)) {
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }

        if ($this->request->isPost && isset($_POST['flag_action'])) {
            $post_data = $_POST['flag_action'];
            $is_comment_mark_as_delete = 'mark_as_not_delete';
            foreach ($post_data as $key => $new_status) {
                $flag = SafariOperatorRatingReport::findOne($key);
                $flag->status = $new_status;
                if ($flag->save(false)) {
                    if ($new_status == 2 && $is_comment_mark_as_delete = 'mark_as_not_delete') {
                        $comment = SafariOperatorRating::findOne($flag->safari_operator_rating_id);
                        $comment->status = $new_status;
                        if ($comment->save()) {
                            $is_comment_mark_as_delete = 'mark_as_delete';
                        }
                    }
                }
            }
            $message = Yii::$app->messageManager->getMessage('common.successfully',['{var}' => 'Action Taken']);
            \Yii::$app->session->setFlash('success', $message);
        }

        //form model
        $model = new FlagActionForm();

        $review_flags = SafariOperatorRatingReport::find()->where(['safari_operator_rating_id' => $id])->orderBy('id DESC')->all();

        return $this->render('flagview', [
            'review' => $review,
            'model' => $model,
            'review_flags' => $review_flags
        ]);
    }
}
