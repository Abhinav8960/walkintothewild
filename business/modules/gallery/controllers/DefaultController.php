<?php

namespace business\modules\gallery\controllers;


use common\models\partnergallery\form\PartnerGalleryForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use common\models\partnergalleryimage\form\PartnerGalleryImageForm;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\models\partnergalleryimage\PartnerGalleryImageSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $searchModel = new PartnerGalleryImageSearch();
        // $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $partner_gallery_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreateGallery($partner_gallery_id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $model = new PartnerGalleryImageForm();
        $model->partner_gallery_id = $partner_gallery_model->id;
        $model->status = PartnerGalleryImage::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_image_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Successfully Uploaded');
                        return $this->redirect(['view', 'id' => $partner_gallery_model->id]);
                    }
                }
            }
        } else {
            $model->partner_gallery_image_model->loadDefaultValues();
        }

        return $this->render('create_gallery', [
            'model' => $model,
        ]);
    }

    public function actionSwtich($id)
    {
        $model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->status == PartnerGallery::STATUS_ACTIVE) {
            $model->status = PartnerGallery::STATUS_SUSPEND;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Successfully Inacive !!!');
        } else {
            $model->status = PartnerGallery::STATUS_ACTIVE;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Successfully Active!!!');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdateGalleryImage($id)
    {
        $partner_gallery_image_model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$partner_gallery_image_model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new PartnerGalleryImageForm($partner_gallery_image_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_image_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Successfully Uploaded');
                        return $this->redirect(['view', 'id' => $partner_gallery_image_model->partner_gallery_id]);
                    }
                }
            }
        } else {
            $model->partner_gallery_image_model->loadDefaultValues();
        }

        return $this->render('update_gallery', [
            'model' => $model,
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
