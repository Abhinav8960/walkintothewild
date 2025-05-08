<?php

namespace backend\modules\sightings\controllers;

use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

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
        $searchModel = new SightingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('danger', 'Sighting not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->renderAjax('view', [
            'model' => $sighting,
        ]);
    }

    public function actionCommentListing($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('danger', 'Sighting not Found!!!');
            return $this->redirect(['index']);
        }

        $query = SightingComment::find()->where(['sighting_id' => $sighting->id, 'status' => 1])->andWhere(['parent_id' => null]);

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
        $query = SightingComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

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

    public function actionSightingDelete($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }

        $sighting->status = Sighting::STATUS_DELETE;
        
        if ($sighting->save(false)) {
            Yii::$app->session->setFlash('success', 'Sighting has been deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete the post. Please try again.');
        }

        return $this->redirect(['index']);
    }
}
