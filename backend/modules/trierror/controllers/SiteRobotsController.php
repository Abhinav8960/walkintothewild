<?php

namespace backend\modules\trierror\controllers;

use Yii;
use common\models\trierror\SiteRobots;
use common\models\trierror\SearchSiteRobots;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiteRobotsController implements the CRUD actions for SiteRobots model.
 */
class SiteRobotsController extends Controller
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
        $searchModel = new SearchSiteRobots();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SiteRobots model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SiteRobots model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SiteRobots();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $postData = Yii::$app->request->post('SiteRobots');
                    //remove old entry
                    $isExist = SiteRobots::find()->where(['status' => 1])->andWhere(['url' => trim($postData['url'])])->one();
                    if (!$isExist) {
                        $model->url = trim($postData['url']);
                        if ($model->save(false)) {
                            //record is update
                            $this->create_robots_txt();
                        }
                    }

                    $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function create_robots_txt()
    {
        //recreae robots.txt
        $content = "Sitemap: " . Yii::$app->params['frontend_url'] . "storage/sitemap/sitemap.xml";
        $all_url = SiteRobots::find()->where(['status' => true])->all();
        if (count($all_url) > 0) {
            $content .= "\nUser-agent: *";
            foreach ($all_url as $row) {
                $content .= "\n" . "Disallow: : " . $row->url;
            }
        }

        $backend_actual_url = \Yii::getAlias('@webroot');
        $backend_actual_url = str_replace("backend", "frontend", $backend_actual_url) . "/";
        $filepath = $backend_actual_url . "robots.txt";
        $fp = fopen($filepath, "w");
        fwrite($fp, $content);
        fclose($fp);
        chmod($filepath, 0777);
    }

    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        $this->create_robots_txt();

        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Record']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(['index']);
    }

    /**
     * Finds the SiteRobots model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SiteRobots the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SiteRobots::findOne(['id' => $id])) !== null) {
            return $model;
        }

         $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
