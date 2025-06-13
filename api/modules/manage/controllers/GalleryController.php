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
use yii\web\BadRequestHttpException;
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
                'only' => ['index', 'gallery-images', 'create', 'create-gallery', 'status-change', 'update-sequence', 'update-thumbnail', 'update-gallery-image', 'edit-gallery', 'gallery-delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'gallery-images', 'create', 'create-gallery', 'status-change', 'update-sequence', 'update-thumbnail', 'update-gallery-image', 'edit-gallery', 'gallery-delete'],
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
                    'create-gallery' => ['POST'],
                    'status-change' => ['POST'],
                    'update-sequence' => ['POST'],
                    'update-thumbnail' => ['POST'],
                    'update-gallery-image' => ['POST'],
                    'edit-gallery' => ['POST'],
                    'gallery-delete' => ['POST'],
                    'send-for-approval' => ['POST']
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
        $model->can_send_for_approval = PartnerGallery::DEFAULT_APPROVAL_STATUS;

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_model->save()) {
                return Yii::$app->api->sendResponse($data = ['status' => 1, 'slug' => $model->partner_gallery_model->slug, 'private_url' => Yii::$app->params['api_url'] . '/manage/gallery/' . $model->partner_gallery_model->slug . '/gallery-images'], ['message' => "Gallery Created Successfully!!!"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Created!!!"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionEditGallery($slug)
    {
        $safari_operator_model = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator_model->id,  'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $model = new PartnerGalleryForm($partner_gallery_model);
        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_model->save()) {
                return Yii::$app->api->sendResponse($data = ['status' => 1, 'slug' => $model->partner_gallery_model->slug, 'private_url' => Yii::$app->params['api_url'] . '/manage/gallery/' . $model->partner_gallery_model->slug . '/gallery-images'], ['message' => "Gallery Updated Successfully!!!"]);
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
        $model->scenario = 'create';
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

    public function actionUpdateGalleryImage($slug, $id)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $partner_gallery_image_model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$partner_gallery_image_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Image Not Found!!!"]);
        }

        $model = new PartnerGalleryImageForm($partner_gallery_image_model);

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_image_model->save()) {
                $partner_gallery_model->can_send_for_approval = PartnerGallery::DEFAULT_APPROVAL_STATUS;
                if ($partner_gallery_model->save(false)) {
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Successfully Updated!!!"]);
                }
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Updated!!!"]);
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

        return $this->dataProviderSenderwithaddionalKey($searchModel, $rootIndexName = "partner_gallery_images", $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "search", $addtionalKeys = ["gallery" => $partner_gallery_model]);
    }

    public function actionStatusChange($slug, $id)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Image Not Found!!!"]);
        }

        $model->status = PartnerGalleryImage::STATUS_SUSPEND;
        if ($model->save(false)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Delete image Successfully !!!"]);
        }


        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Please Try Again!!!"]);
    }

    public function actionUpdateSequence($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();

        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $ids = Yii::$app->request->post('ids');
        $sequence_ids = array_filter(explode(',', $ids));

        $allImages = PartnerGalleryImage::find()->select(['id'])->where(['partner_gallery_id' => $partner_gallery_model->id])->orderBy(['sequence' => SORT_ASC])->asArray()->all();

        $allIds = array_column($allImages, 'id');

        $finalSequence = array_merge(
            $sequence_ids,
            array_diff($allIds, $sequence_ids)
        );

        $count = 1;
        foreach ($finalSequence as $id) {
            PartnerGalleryImage::updateAll(['sequence' => $count], ['id' => $id]);
            $count++;
        }
        return Yii::$app->api->sendResponse(['status' => 1], ['message' => "Image order updated successfully!!!"]);
    }


    public function actionUpdateThumbnail($slug, $id)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();

        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $update_model = PartnerGalleryImage::updateAll(['set_as_thumbnail' => 0], ['partner_gallery_id' => $partner_gallery_model->id]);

        $model = PartnerGalleryImage::find()->where(['id' => $id, 'partner_gallery_id' => $partner_gallery_model->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$model) {
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => "Gallery Image Not Found!!!"]);
        }

        $model->set_as_thumbnail = 1;
        if ($model->save(false)) {
            return Yii::$app->api->sendResponse(['status' => 1], ['message' => "Set thumbnail successfully!!!"]);
        }

        return Yii::$app->api->sendResponse(['status' => 0], ['message' => "Please Try Again!!!"]);
    }

    public function actionGalleryDelete($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }
        $partner_gallery_model->status = PartnerGallery::STATUS_DELETE;
        if ($partner_gallery_model->save(false)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery Deleted Successfully!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Deleted!!!"]);
    }

    public function actionSendForApproval($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $partner_gallery_model->can_send_for_approval = PartnerGallery::CANNOT_SEND_FOR_APPROVAL;
        if ($partner_gallery_model->save(false)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery Send For Approval!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Please Try Again!!!"]);
    }
}
