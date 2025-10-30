<?php

namespace backend\modules\trierror\controllers;

use Yii;
use common\models\trierror\SiteUntracedRequest;
use common\models\trierror\SiteUntracedRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiteRobotsController implements the CRUD actions for SiteRobots model.
 */
class SiteUntracedRequestController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SiteRobots models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SiteUntracedRequestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        //$this->create_robots_txt();

         $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Record']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SiteUntracedRequest::findOne(['id' => $id])) !== null) {
            return $model;
        }

         $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
