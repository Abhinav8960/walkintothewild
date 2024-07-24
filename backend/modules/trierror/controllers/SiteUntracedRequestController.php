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

    public function actionCreate()
    {
        $model = new SiteRobots();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $postData = Yii::$app->request->post('SiteRobots');
                    //remove old entry
                    $isExist = SiteRobots::find()->where(['status' => 1])->andWhere(['url' => trim($postData['url'])])->one();
                    if(!$isExist){
                        $model->url = trim($postData['url']);
                        if ($model->save(false)) {
                            //record is update
                            $this->create_robots_txt();
                        }
                    }

                    \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function create_robots_txt(){
        //recreae robots.txt
        $content = "Sitemap: ".Yii::$app->params['frontend_url']."sitemap_index.xml";
        $all_url = SiteRobots::find()->where(['status' => true])->all();
        if(count($all_url) > 0){
            $content .= "\nUser-agent: *";
            foreach($all_url as $row){
                $content .= "\n"."Disallow: : ".$row->url;
            }
        }

        $backend_actual_url = \Yii::getAlias('@webroot');
        $backend_actual_url = str_replace("backend", "frontend", $backend_actual_url)."/";
        $filepath = $backend_actual_url."/robots.txt";
        $fp = fopen($filepath, "w");
        fwrite($fp, $content);
        fclose($fp);
        chmod($filepath, 0777);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        //$this->create_robots_txt();

        \Yii::$app->session->setFlash('success', 'Record delete successfully');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SiteUntracedRequest::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
