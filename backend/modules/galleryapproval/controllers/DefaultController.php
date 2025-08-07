<?php

namespace backend\modules\galleryapproval\controllers;

use common\models\partnergallery\form\PartnerGalleryRejectionForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use common\models\partnergallery\PartnerGalleryVersion;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\models\partnergalleryimage\PartnerGalleryImageSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PartnerGallerySearch();
        $searchModel->edit_status = 2;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['IN', 'listing_status', [10, 1]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'edit_status' => 2, 'listing_status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_CREATE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->partner_gallery_id = $partner_gallery_model->id;
        $searchModel->status = PartnerGalleryImage::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $partner_gallery_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproved($id)
    {

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'edit_status' => 2, 'listing_status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_CREATE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $partner_gallery_model->live_images = json_encode($partner_gallery_model->PrepareFullResponse());
        $partner_gallery_model->edit_status = 0;
        $partner_gallery_model->remark = NULL;
        $partner_gallery_model->live_gallery_images_count = $partner_gallery_model->gallery_count;
        $partner_gallery_model->listing_status = 1;

        if ($partner_gallery_model->save(false)) {
            if ($partner_gallery_model->listing_status == 10) {
                $version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partner_gallery_model->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                if ($version) {
                    $version->listing_status = 3;
                    $version->live_images = $partner_gallery_model->live_images;
                    $version->send_for_approval_time = $partner_gallery_model->send_for_approval_time;
                    $version->approved_at = date('Y-m-d H:i:s');
                    $version->save(false);
                }
                $partner_gallery_model->version = $version->version;
            } else {
                $new_version = $partner_gallery_model->versionsave();
                if ($new_version) {
                    $approved_version = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $partner_gallery_model->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                    if ($approved_version) {
                        $approved_version->listing_status = 3;
                        $approved_version->live_images = $partner_gallery_model->live_images;
                        $approved_version->send_for_approval_time = $partner_gallery_model->send_for_approval_time;
                        $approved_version->approved_at = date('Y-m-d H:i:s');
                        $approved_version->save(false);
                    }
                    $partner_gallery_model->version = $approved_version->version;
                }
            }
            $partner_gallery_model->save(false);
            \Yii::$app->session->setFlash('success', 'Gallery Approved SuccessFully!!!');
            return $this->redirect(['index']);
        }
    }

    public function actionReject($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'edit_status' => 2,'listing_status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_CREATE]])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $model = new PartnerGalleryRejectionForm($partner_gallery_model);
        $model->edit_status  = 1;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rejection_model->save(false)) {
                        \Yii::$app->session->setFlash('danger', 'Gallery Reject SuccessFully!!!');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->renderAjax('_rejection_form', ['model' => $model]);
    }
}
