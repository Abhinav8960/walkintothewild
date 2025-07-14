<?php

namespace business\modules\gallery\controllers;


use common\models\partnergallery\form\PartnerGalleryForm;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
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
                        'actions' => ['view', 'switch', 'edit-gallery', 'send-for-approval', 'update-thumbnail','update-gallery-image'],
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
        $searchModel->status = PartnerGallery::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $safari_operator_model = $this->module->operatormodel();

        $model = new PartnerGalleryForm();
        $model->safari_operator_id = $safari_operator_model->id;
        $model->status = PartnerGallery::STATUS_ACTIVE;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_gallery_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Gallery added successfully');
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
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
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
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
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

    public function actionSwitch($id)
    {
        $model = PartnerGalleryImage::find()->where(['id' => $id, 'status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]])->limit(1)->one();
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->status == PartnerGallery::STATUS_ACTIVE) {
            $model->status = PartnerGallery::STATUS_SUSPEND;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Successfully Inactive !!!');
        } else {
            $model->status = PartnerGallery::STATUS_ACTIVE;
            $model->save(false);
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

    /**
     * Set Sequence of Privacy Policy
     *
     * @return void
     */
    public function actionSetSequence($partner_gallery_id)
    {
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
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


    public function actionSendForApproval($id)
    {
        $safari_operator = $this->module->operatormodel();
        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator->id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
            return $this->redirect(['index']);
        }

        if ($partner_gallery_model->can_send_for_approval === PartnerGallery::CANNOT_SEND_FOR_APPROVAL) {
            \Yii::$app->session->setFlash('danger', 'This gallery already send for approval!!!');
            return $this->redirect(['index']);
        }

        $partner_gallery_model->can_send_for_approval = PartnerGallery::CANNOT_SEND_FOR_APPROVAL;
        if ($partner_gallery_model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Gallery Send For Approval!!!');
            return $this->redirect(['index']);
        }
    }

    public function actionEditGallery($id)
    {
        $safari_operator_model = $this->module->operatormodel();

        $partner_gallery_model = PartnerGallery::find()->where(['id' => $id, 'safari_operator_id' => $safari_operator_model->id,  'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
        if (!$partner_gallery_model) {
            \Yii::$app->session->setFlash('danger', 'Gallery Not Found!!!');
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
}
