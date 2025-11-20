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

    /**
     * Get Gallery List
     *
     *
     * @OA\Get(
     *     path="/manage/gallery/list",
     *     tags={"Manage"},
     *     summary="Get Gallery List",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gallery List",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="partner_gallery",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/GallerySchema")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Gallery Not Found")
     *         )
     *     ),
     * )
     */
    public function actionIndex()
    {

        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->listing_status = 1;
        // $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;

        return $this->dataProviderSender($searchModel, $rootIndexName = "partner_gallery");
    }

    public function actionCreate()
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
            $message = Yii::$app->api->messageManager->getMessage('common.creation_failed',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionEditGallery($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator_model = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator_model->id,  'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model = new PartnerGalleryForm($partner_gallery_model);
        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_model->save()) {
                return Yii::$app->api->sendResponse($data = ['status' => 1, 'slug' => $model->partner_gallery_model->slug, 'private_url' => Yii::$app->params['api_url'] . '/manage/gallery/' . $model->partner_gallery_model->slug . '/gallery-images'], ['message' => "Gallery Updated Successfully!!!"]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.creation_failed',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionCreateGallery($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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
                $message = Yii::$app->api->messageManager->getMessage('common.upload_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.upload_failed');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionUpdateGalleryImage($slug, $id)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $partner_gallery_image_model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$partner_gallery_image_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery Image']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model = new PartnerGalleryImageForm($partner_gallery_image_model);

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->partner_gallery_image_model->save()) {
                $partner_gallery_model->can_send_for_approval = PartnerGallery::DEFAULT_APPROVAL_STATUS;
                if ($partner_gallery_model->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.updated');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionGalleryImages($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'listing_status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;

        return $this->dataProviderSenderwithaddionalKey($searchModel, $rootIndexName = "partner_gallery_images", $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "search", $addtionalKeys = ["gallery" => $partner_gallery_model]);
    }

    public function actionStatusChange($slug, $id)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery Image']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $model->status = PartnerGalleryImage::STATUS_SUSPEND;
        if ($model->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.deleted',['{var}'=>'Image']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.try_again');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function actionUpdateSequence($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();

        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => $message]);
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
        $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Image Order']);
        return Yii::$app->api->sendResponse(['status' => 1], ['message' => $message]);
    }


    public function actionUpdateThumbnail($slug, $id)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();

        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => $message]);
        }

        $update_model = PartnerGalleryImage::updateAll(['set_as_thumbnail' => 0], ['partner_gallery_id' => $partner_gallery_model->id]);

        $model = PartnerGalleryImage::find()->where(['id' => $id, 'partner_gallery_id' => $partner_gallery_model->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery Image']);
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => $message]);
        }

        $model->set_as_thumbnail = 1;
        if ($model->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.set_success',['{var}'=>'Thumbnail']);
            return Yii::$app->api->sendResponse(['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.try_again');
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => $message]);
    }

    public function actionGalleryDelete($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $partner_gallery_model->status = PartnerGallery::STATUS_DELETE;
        if ($partner_gallery_model->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.deleted',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.delete_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function actionSendForApproval($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);
        
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['slug' => $slug, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_found',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        if ($partner_gallery_model->can_send_for_approval == PartnerGallery::CANNOT_SEND_FOR_APPROVAL) {
            $message = Yii::$app->api->messageManager->getMessage('common.already_send_for_approval',['{var}'=>'This Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        $partner_gallery_model->can_send_for_approval = PartnerGallery::CANNOT_SEND_FOR_APPROVAL;
        if ($partner_gallery_model->save(false)) {
            $message = Yii::$app->api->messageManager->getMessage('common.send_for_approval',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.try_again');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }
}
