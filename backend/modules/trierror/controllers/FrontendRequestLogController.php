<?php

namespace backend\modules\trierror\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

use common\models\trierror\FrontendRequestLog;
use common\models\trierror\FrontendRequestLogSearch;
use common\models\cms\article\Article;
use common\models\cms\article\MasterArticleTopic;
use common\models\cms\article\MasterArticleTag;
use common\models\park\Park;
use common\models\operator\SafariOperator;
use common\models\trierror\SitePages;
use common\models\cms\article\ArticleAuthor;
use common\models\sharesafari\ShareSafari;
use yii\helpers\Url;

/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class FrontendRequestLogController extends Controller
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
     * Lists all FrontendRequestLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $request_code_data = FrontendRequestLog::find()->select('request_code')->distinct()->asArray()->all();

        $request_codes_list = [];
        if (count($request_code_data) > 0) {
            $request_codes_list["0"] = "-- Select All --";
            foreach ($request_code_data as $val) {
                $request_codes_list[$val['request_code']] = ucwords(str_replace("_", " ", $val['request_code']));
            }
        }

        $request_group_data = FrontendRequestLog::find()->select('request_group')->distinct()->asArray()->all();

        $request_group_type = [];
        if (count($request_group_data) > 0) {
            $request_group_type["0"] = "Select All";
            foreach ($request_group_data as $grp) {
                $request_group_type[$grp['request_group']] = ucwords($grp['request_group']);
            }
        }

        $searchModel = new FrontendRequestLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'request_codes_list' => $request_codes_list,
            'request_group_type' => $request_group_type
        ]);
    }

    /**
     * Displays a single FrontendRequestLog model.
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

    public function actionUserView($id)
    {
        $model = FrontendRequestLog::find()->where(['user_id' => $id])->andWhere(['request_code' => 302])->groupBy('route')->orderBy('created_at DESC')->asArray()->all();
        return $this->render('user-view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new FrontendRequestLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FrontendRequestLog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FrontendRequestLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FrontendRequestLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FrontendRequestLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FrontendRequestLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FrontendRequestLog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
