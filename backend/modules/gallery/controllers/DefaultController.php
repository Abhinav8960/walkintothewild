<?php

namespace backend\modules\gallery\controllers;

use common\models\partnergallery\form\PartnerGalleryDeletionForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\models\partnergalleryimage\PartnerGalleryImageSearch;
use Yii;
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
        $searchModel->listing_status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            'partner_gallery_model' => $partner_gallery_model,
        ]);
    }


    public function actionDelete($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        $model = new PartnerGalleryDeletionForm($partner_gallery_model);
        $model->listing_status  = PartnerGallery::STATUS_DELETE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->deletion_model->save()) {
                        \Yii::$app->session->setFlash('danger', 'Gallery Deleted SuccessFully!!!');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->renderAjax('_delete_reason_form', ['model' => $model]);
    }
}
