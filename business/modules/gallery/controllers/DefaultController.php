<?php

namespace business\modules\gallery\controllers;


use common\models\partnergallery\form\PartnerGalleryForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use common\models\partnergallery\PartnerGalleryVersion;
use common\models\partnergallery\PartnerGalleryVersionSearch;
use common\models\partnergalleryimage\form\PartnerGalleryImageForm;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\models\partnergalleryimage\PartnerGalleryImageSearch;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'switch', 'edit-gallery', 'send-for-approval', 'update-thumbnail', 'update-gallery-image', 'gallery-delete', 'draft-gallery', 'gallery-permanent-delete', 'move-to-draft'],
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
        $searchModel->edit_status = 1;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['IN', 'listing_status', [10, 1]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'draft_active' => true,
        ]);
    }

    public function actionApproved()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->listing_status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('approved', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'approved_active' => true,
        ]);
    }

    public function actionPendingForApproval()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->edit_status = 2;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['IN', 'listing_status', [10, 1]]);

        return $this->render('pending_for_approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pending_active' => true,
        ]);
    }


    public function actionCreate()
    {
        $safari_operator_model = $this->module->operatormodel();

        $model = new PartnerGalleryForm();
        $model->safari_operator_id = $safari_operator_model->id;
        $model->listing_status = PartnerGallery::STATUS_CREATE;
        $model->edit_status = 1;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_model->save()) {
                        $model->partner_gallery_model->versionsave();
                        $message = Yii::$app->messageCache->getMessage('common.created', ['{var}' => 'Gallery']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->partner_gallery_model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'safari_operator_model' => $safari_operator_model,
        ]);
    }

    public function actionView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $searchModel->partner_gallery_id = $partner_gallery_model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'partner_gallery_model' => $partner_gallery_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreateGallery($partner_gallery_id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
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

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_image_model->save()) {
                        $model->uploadFile();
                        $partner_gallery_model->gallery_images_count = $partner_gallery_model->gallery_count;
                        $partner_gallery_model->save(false);
                        \Yii::$app->session->setFlash('success', 'Successfully Uploaded');
                        return $this->redirect(['view', 'id' => $partner_gallery_model->id]);
                    }
                }
            }
        } else {
            $model->partner_gallery_image_model->loadDefaultValues();
        }

        return $this->renderAjax('create_gallery', [
            'model' => $model,
        ]);
    }


    public function actionSendForApproval($id)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'edit_status' => 1, 'safari_operator_id' => $safari_operator->id, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }
        $partner_gallery_model->edit_status = 2;
        $partner_gallery_model->remark = NULL;
        $partner_gallery_model->send_for_approval_time = date('Y-m-d H:i:s');

        if ($partner_gallery_model->save(false)) {
            $version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partner_gallery_model->id, 'listing_status' => 1])->limit(1)->one();
            if ($version) {
                $version->listing_status = 2;
                $version->send_for_approval_time =  $partner_gallery_model->send_for_approval_time;
                $version->save(false);
            }

            new \common\events\operator\GallerySendForApprovalEvent($safari_operator->id, $partner_gallery_model->title);

            \Yii::$app->session->setFlash('success', 'Gallery Send For Approval!!!');
            return $this->redirect(['index']);
        }
    }


    public function actionDraftGallery($id)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator->id, 'listing_status' => 1])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery not available for draft!!!');
        }
        $partner_gallery_model->edit_status = 1;

        if ($partner_gallery_model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Done!!!');
        } else {
            \Yii::$app->session->setFlash('error', 'Technical Issue!!!');
        }
        return $this->redirect(['index']);
    }


    public function actionEditGallery($id)
    {
        $safari_operator_model = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator_model->id,  'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $model = new PartnerGalleryForm($partner_gallery_model);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Gallery Updated Successfully!!!');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->partner_gallery_model->loadDefaultValues();
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'safari_operator_model' => $safari_operator_model,
        ]);
    }

    public function actionMoveToDraft($id)
    {
        $safari_operator_model = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator_model->id, 'edit_status' => 2, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $partner_gallery_model->edit_status = 1;

        if ($partner_gallery_model->save(false)) {
            return $this->redirect(['index']);
        }
    }



    public function actionSetSequence($partner_gallery_id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->partner_gallery_id = $partner_gallery_model->id;
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $dataProvider->pagination = false;

        return $this->render('set_sequence', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdateSequence()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ids = Yii::$app->request->post('ids');
        if (!is_array($ids)) {
            throw new BadRequestHttpException('Invalid data format.');
        }
        $count = 1;
        foreach ($ids as $id) {
            PartnerGalleryImage::updateAll(
                ['sequence' => $count],
                ['id' => $id]
            );
            $count++;
        }

        Yii::$app->session->setFlash('success', 'Image order updated successfully.');

        return ['status' => 'success'];
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

    public function actionUpdateThumbnail($partner_gallery_id, $id)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'safari_operator_id' => $safari_operator->id, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();

        if (!$partner_gallery_model) {
            return Yii::$app->api->sendResponse(['status' => 0], ['message' => "Gallery Not Found!!!"]);
        }

        $update_model = PartnerGalleryImage::updateAll(['set_as_thumbnail' => 0], ['partner_gallery_id' => $partner_gallery_id]);

        $model = PartnerGalleryImage::find()->where(['id' => $id, 'partner_gallery_id' => $partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->set_as_thumbnail = 1;
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Updated successfully.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionSwitch($id)
    {
        $model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGalleryImage::STATUS_ACTIVE, PartnerGalleryImage::STATUS_SUSPEND]])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $model->partner_gallery_id])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        if ($model->status == PartnerGalleryImage::STATUS_ACTIVE) {
            $model->status = PartnerGalleryImage::STATUS_SUSPEND;
            $model->save(false);
            $partner_gallery_model->gallery_images_count = $partner_gallery_model->gallery_count;
            $partner_gallery_model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Successfully Inactive !!!');
        } else {
            $model->status = PartnerGalleryImage::STATUS_ACTIVE;
            $model->save(false);
            $partner_gallery_model->gallery_images_count = $partner_gallery_model->gallery_count;
            $partner_gallery_model->save(false);
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

        return $this->renderAjax('update_gallery', [
            'model' => $model,
        ]);
    }

    public function actionGalleryDelete($id)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator->id, 'listing_status' => [PartnerGallery::STATUS_CREATE, PartnerGallery::STATUS_ACTIVE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        if ($partner_gallery_model->listing_status == 10) {
            $partner_gallery_model->edit_status = 0;
            $partner_gallery_model->listing_status = PartnerGallery::STATUS_DELETE;
            $partner_gallery_version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partner_gallery_model->id, 'listing_status' => 1])->limit(1)->one();
            if ($partner_gallery_version) {
                $partner_gallery_version->status = -1;
                $partner_gallery_version->save(false);
            }
        } else {
            $partner_gallery_model->edit_status = 0;
        }

        if ($partner_gallery_model->save(false)) {

            $gallery_images = PartnerGalleryImage::find()->where(['partner_gallery_id' => $partner_gallery_model->id])->all();
            if ($gallery_images) {
                foreach ($gallery_images as $image) {
                    $image->status = 0;
                    $image->save(false);
                }
            }

            if (!empty($partner_gallery_model->live_images)) {
                $gallery = json_decode($partner_gallery_model->live_images, true);
                if (is_array($gallery) && isset($gallery['images']) && is_array($gallery['images'])) {
                    foreach ($gallery['images'] as $img) {
                        $partner_gallery_image = PartnerGalleryImage::find()->where(['id' => $img['id']])->limit(1)->one();

                        if ($partner_gallery_image) {
                            $path = parse_url($img['gallery_image_path'], PHP_URL_PATH);
                            $relativePath = ltrim($path, '/');
                            $filename = basename(parse_url($img['gallery_image_path'], PHP_URL_PATH));

                            $partner_gallery_image->status = 1;
                            $partner_gallery_image->title = $img['title'];
                            $partner_gallery_image->filepath = $relativePath;
                            $partner_gallery_image->caption = $img['caption'];
                            $partner_gallery_image->sequence = $img['sequence'];
                            $partner_gallery_image->set_as_thumbnail = $img['set_as_thumbnail'];
                            $partner_gallery_image->save(false);
                        }
                    }
                }
            }

            \Yii::$app->session->setFlash('error', 'Gallery Deleted Successfully!!!');
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionApprovedView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        return $this->render('approved_view', [
            'partner_gallery_model' => $partner_gallery_model,
        ]);
    }


    public function actionGalleryPermanentDelete($id)
    {
        $safari_operator = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator->id])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('error', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $partner_gallery_model->status = PartnerGallery::STATUS_DELETE;
        if ($partner_gallery_model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Gallery Deleted Successfully!!!');
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
