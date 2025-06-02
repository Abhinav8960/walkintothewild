<?php

namespace api\modules\manage\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\partnergallery\PartnerGallery;
use api\models\partnergallery\PartnerGallerySearch;
use api\models\partnergalleryimage\PartnerGalleryImage;
use api\models\partnergalleryimage\PartnerGalleryImageSearch;
use common\models\partnergallery\form\PartnerGalleryForm;
use common\models\partnergalleryimage\form\PartnerGalleryImageForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * GalleryController for the `manage` module
 */
class GalleryController extends RestController
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'gallery-images', 'create', 'create-gallery'],
                'rules' => [
                    [
                        'actions' => ['index', 'gallery-images', 'create', 'create-gallery'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'gallery-images' => ['GET'],
                    'create' => ['POST'],
                    'create-gallery' => ['POST']
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;

        return $this->dataProviderSender($searchModel, $rootIndexName = "partner_gallery");
    }

    public function actionCreate()
    {
        $safari_operator_model = $this->module->operatormodel();

        $model = new PartnerGalleryForm();
        $model->safari_operator_id = $safari_operator_model->id;
        $model->status = PartnerGallery::STATUS_ACTIVE;

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_model->save()) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery Created Successfully!!!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Created!!!"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionCreateGallery($slug)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $pgi_query = PartnerGalleryImage::find()->where(['partner_gallery_id' => $partner_gallery_model->id]);
        $maxSequence = $pgi_query->max('sequence');
        $pgi_thumbnail = $pgi_query->andWhere(['set_as_thumbnail' => 1])->limit(1)->one();

        $model = new PartnerGalleryImageForm();
        $model->partner_gallery_id = $partner_gallery_model->id;
        $model->status = PartnerGalleryImage::STATUS_ACTIVE;
        $model->sequence = $maxSequence ? ($maxSequence + 1) : 1;

        if (empty($pgi_thumbnail)) {
            $model->set_as_thumbnail = 1;
        }

        $model->attributes = $this->request;


        $model->file = UploadedFile::getInstanceByName('file');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_image_model->save()) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Successfully Uploaded!!!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Uploaded!!!"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionGalleryImages($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;

        return $this->dataProviderSender($searchModel, $rootIndexName = "partner_gallery_images");
    }
}
