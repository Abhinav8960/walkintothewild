<?php

namespace api\modules\manage\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\partnergallery\PartnerGallery;
use api\models\partnergallery\PartnerGallerySearch;
use api\models\partnergalleryimage\PartnerGalleryImage;
use api\models\partnergalleryimage\PartnerGalleryImageSearch;
use Yii;
use yii\filters\AccessControl;

/**
 * GalleryController for the `manage` module
 */
class GalleryController extends RestController
{
    public $action_ids = ['index'];

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
                'only' => ['index', 'gallery-images'],
                'rules' => [
                    [
                        'actions' => ['index', 'gallery-images'],
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
