<?php

namespace backend\modules\park\controllers;

use common\interfaces\StatusInterface;
use common\models\park\form\ParkGalleryForm;
use common\models\park\ParkGallery;
use common\models\park\ParkGallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * GalleryController.
 */
class ParkGalleryController extends Controller
{

    /**
     * Renders the index view for the module    
     * @return string
     */
    public function actionIndex($park_id)
    {
        $searchModel = new ParkGallerySearch();
        $searchModel->park_id = $park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        // $model = new ParkGalleryForm();
        // $model->status = StatusInterface::STATUS_ACTIVE;
        // $model->park_id = $park_id;

        return $this->render('index', [
            'park_id' => $park_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($park_id)
    {
        $model = new ParkGalleryForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->park_id = $park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->icon = UploadedFile::getInstance($model, 'icon');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->park_gallery_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index', 'park_id' => $park_id]);
                    }
                }
            }
        } else {
            $model->park_gallery_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'park_id' => $park_id,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = ParkGallery::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
