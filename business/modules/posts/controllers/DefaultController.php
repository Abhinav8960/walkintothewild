<?php

namespace business\modules\posts\controllers;

use common\models\UserPosts;
use common\models\UserPostSearch;
use Yii;
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
}
