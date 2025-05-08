<?php

namespace business\modules\posts\controllers;

use common\models\postscomment\UserPostComment;
use common\models\UserPosts;
use common\models\UserPostSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new UserPostSearch();
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            \Yii::$app->session->setFlash('danger', 'Post not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->renderAjax('view', [
            'model' => $userpost,
        ]);
    }

    public function actionCommentListing($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            \Yii::$app->session->setFlash('danger', 'Post not Found!!!');
            return $this->redirect(['index']);
        }

        $query = UserPostComment::find()->where(['user_posts_id' => $userpost->id, 'status' => 1])->andWhere(['parent_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_comment_list', ['dataProvider' => $dataProvider]);
    }

    public function actionReplyListing($parent_id)
    {
        $query = UserPostComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_reply_list', ['dataProvider' => $dataProvider]);
    }
}
