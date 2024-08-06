<?php

namespace backend\modules\trierror\controllers;

use Yii;
use common\models\trierror\SitePages;
use common\models\trierror\SearchSitePages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SitePagesController implements the CRUD actions for SitePages model.
 */
class SitePagesController extends Controller
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
     * Lists all SitePages models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$content_types_data = \yii\helpers\ArrayHelper::map(SitePages::find()->select(['id', 'content_type'])->orderBy('content_type', 'asc')->groupBy('content_type', 'id')->all(), 'id', 'content_type');

        $content_types_data = SitePages::find()->select('category')->distinct()->asArray()->all();

        $content_type = [];
        if (count($content_types_data) > 0) {
            $content_type["select_all"] = "Select All";
            foreach ($content_types_data as $val) {
                $content_type[$val['category']] = ucwords($val['category']);
            }
        }

        $searchModel = new SearchSitePages();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'content_type' => $content_type
        ]);
    }

    /**
     * Creates a new SitePages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SitePages();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $postData = Yii::$app->request->post('SitePages');

                    //remove old entry
                    SitePages::updateAll(['status' => 0], ['url' => trim($postData['url']), 'content_type' => 'manual_url']);

                    $model->content_id = 0;
                    $model->content_type = 'manual_url';
                    $model->url = trim($postData['url']);
                    $model->last_update_at = date("Y-m-d H:i:s");
                    $model->counter = 0;
                    if ($model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        \Yii::$app->session->setFlash('success', 'Record delete successfully');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SitePages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
