<?php

namespace backend\modules\galleryapproval\controllers;

use common\models\partnergallery\form\PartnerGalleryRejectionForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
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
        $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->can_send_for_approval = PartnerGallery::SEND_FOR_APPROVAL;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'can_send_for_approval' => PartnerGallery::SEND_FOR_APPROVAL, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $searchModel = new PartnerGalleryImageSearch();
        $searchModel->partner_gallery_id = $partner_gallery_model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $partner_gallery_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproved($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'can_send_for_approval' => PartnerGallery::SEND_FOR_APPROVAL, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $partner_gallery_model->live_images = json_encode($partner_gallery_model->PrepareFullResponse());
        if ($partner_gallery_model->save(false)) {
            \Yii::$app->session->setFlash('danger', 'Gallery Approved SuccessFully!!!');
            return $this->redirect(['index']);
        }
    }

    public function actionReject($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'can_send_for_approval' => PartnerGallery::SEND_FOR_APPROVAL, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $model = new PartnerGalleryRejectionForm($partner_gallery_model);
        $model->can_send_for_approval = PartnerGallery::DEFAULT_APPROVAL_STATUS;
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
