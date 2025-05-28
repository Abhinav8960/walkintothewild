<?php

namespace business\modules\gallery\controllers;

use common\models\partnergallery\form\PartnerGalleryForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => $this->isOwner(),
                        'roles' => ['@'],
                    ],

                ],

            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $safari_operator_model = $this->module->operatormodel();

        $model = new PartnerGalleryForm();
        $model->safari_operator_id = $safari_operator_model->id;
        $model->status = PartnerGallery::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Gallery added successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->partner_gallery_model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
            'safari_operator_model' => $safari_operator_model,
        ]);
    }

    public function actionView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $partner_gallery_model,
        ]);
    }

    private function isOwner()
    {
        $id = Yii::$app->request->get('id');
        $safari_operator_model = $this->module->operatormodel();
        $model = PartnerGallery::findOne(['id' => $id]);
        if ($model && $model->safari_operator_id == $safari_operator_model->id) {
            return true;
        }
        return false;
    }
}
