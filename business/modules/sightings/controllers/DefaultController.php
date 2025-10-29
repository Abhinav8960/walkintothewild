<?php

namespace business\modules\sightings\controllers;

use common\models\sighting\form\SightingForm;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingSearch;
use getID3;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                'only' => ['index', 'view', 'comment-listing', 'reply-listing'],
                'rules' => [
                    [
                        'actions' => ['index', 'comment-listing', 'reply-listing'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
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
        $searchModel = new SightingSearch();
        $searchModel->status = Sighting::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new SightingForm();
        $safari_operator = $this->module->operatormodel();
        $model->safari_operator_id = $safari_operator->id;
        $model->status = Sighting::STATUS_ACTIVE;
        $model->user_id = \Yii::$app->user->identity->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->sighting_model->save()) {
                        $model->uploadFile();
                        $model->sighting_model->v_size = $model->file->size;
                        $model->sighting_model->v_duration = $this->getVideoDuration($model->file);
                        if ($model->sighting_model->save()) {
                            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Sighting added']);
                            \Yii::$app->session->setFlash('success', $message);
                            return $this->redirect(['index']);
                        }
                    }
                }
            }
        } else {
            $model->sighting_model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    private function getVideoDuration($tempFile)
    {
        $tempFilePath = $tempFile->tempName;
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($tempFilePath);
        if (isset($fileInfo['playtime_seconds'])) {
            return (int) $fileInfo['playtime_seconds'];
        }
        return 0;
    }


    // public function actionUpdate($id){
    //     $formModel = $this->findSightingId($id);
    //     $model = new SightingForm($formModel);

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->file = \yii\web\UploadedFile::getInstance($model,'file');
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->sighting_model->save()) {
    //                     $model->uploadFile();
    //                     $model->sighting_model->v_size = $model->file->size;
    //                     $model->sighting_model->v_duration = $this->getVideoDuration($model->file);
    //                     if ($model->sighting_model->save()) {
    //                         \Yii::$app->session->setFlash('success', 'Sighting added successfully');
    //                         return $this->redirect(['index']);
    //                     }
    //                 }
    //             }
    //         }
    //     } 
    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function findSightingId($id)
    {
        if (($model = Sighting::findOne(['id' => $id, 'status' => [Sighting::STATUS_ACTIVE, Sighting::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            \Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $sighting,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findSightingId($id);
        $model->status = Sighting::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Sighting']);
        Yii::$app->session->setFlash('success',  $message);
        return $this->redirect(['index']);
    }

    public function actionCommentListing($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Sighting']);
            \Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(['index']);
        }

        $query = SightingComment::find()->where(['sighting_id' => $sighting->id, 'status' => 1])->andWhere(['parent_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_comment_list', ['dataProvider' => $dataProvider]);
    }

    public function actionReplyListing($parent_id)
    {
        $query = SightingComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_reply_list', ['dataProvider' => $dataProvider]);
    }

    private function isOwner()
    {
        $id = Yii::$app->request->get('id');
        $operator = $this->module->operatormodel();
        $model = Sighting::findOne(['id' => $id]);
        if ($model && $model->safari_operator_id == $operator->id) {
            return true;
        }
        return false;
    }
}
