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
            'query' =>  PackageCommentReport::find()->where(['package_comment_id' => $id, 'status' => [1, 20]]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('view', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
