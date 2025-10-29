<?php

namespace support\modules\gallery\controllers;

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
        $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->is_approved = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Gallery']);
            \Yii::$app->session->setFlash('danger', $message);
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
}
