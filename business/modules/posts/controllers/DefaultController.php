<?php

namespace business\modules\posts\controllers;

use common\models\postscomment\UserPostComment;
use common\models\UserPosts;
use common\models\UserPostSearch;
use frontend\models\profile\UserPostImageForm;
use frontend\models\profile\UserPostsImageForm;
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
                'only' => ['index', 'view', 'quotation', 'quotation-validate'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'quotation', 'quotation-validate'],
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
        $searchModel = new UserPostSearch();
        $searchModel->status = UserPosts::STATUS_ACTIVE;
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new UserPostImageForm();
        $safari_operator = $this->module->operatormodel();
        $model->safari_operator_id = $safari_operator->id;
        $model->status = UserPosts::STATUS_ACTIVE;
        $model->user_id = \Yii::$app->user->identity->id;
        $model->version = 1;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_image_model->save()) {
                        $model->uploadFile();
                        if ($model->file) {
                            list($width, $height) = getimagesize($model->file->tempName);
                            $model->user_image_model->height = $height;
                            $model->user_image_model->width = $width;
                            $model->user_image_model->size = $model->file->size;
                        }
                        if ($model->user_image_model->save()) {
                            $model->user_image_model->savehistory();
                            $message = Yii::$app->messageCache->getMessage('common.successfully', ['{var}'=>'Post added']);
                            \Yii::$app->session->setFlash('success', $message);
                            return $this->redirect(['index']);
                        }
                    }
                }
            }
        } else {
            $model->user_image_model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $formModel = $this->findPostId($id);
        $model = new UserPostImageForm($formModel);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_image_model->save()) {
                        $model->uploadFile();
                        if ($model->file) {
                            list($width, $height) = getimagesize($model->file->tempName);
                            $model->user_image_model->height = $height;
                            $model->user_image_model->width = $width;
                            $model->user_image_model->size = $model->file->size;
                        }
                        if ($model->user_image_model->save()) {
                            $model->user_image_model->savehistory();
                            $message = Yii::$app->messageCache->getMessage('common.successfully', ['{var}' => 'Post edited']);
                            \Yii::$app->session->setFlash('success', $message);
                            return $this->redirect(['index']);
                        }
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function findPostId($id)
    {
        if (($model = UserPosts::findOne(['id' => $id, 'status' => [UserPosts::STATUS_ACTIVE, UserPosts::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->messageCache->getMessage('common.not_found', ['{var}' => 'Post']);
            \Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $userpost,
        ]);
    }
    public function actionDelete($id)
    {
        $model = $this->findPostId($id);
        $model->status = UserPosts::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageCache->getMessage('common.deleted', ['{var}' => 'Post']);
        Yii::$app->session->setFlash('success', $message);
        return $this->redirect(['index']);
    }

    public function actionCommentListing($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id])->limit(1)->one();
        if (!$userpost) {
            $message = Yii::$app->messageCache->getMessage('common.not_found', ['{var}' => 'Post']);
            \Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(['index']);
        }

        $query = UserPostComment::find()->where(['user_posts_id' => $userpost->id, 'status' => 1])->andWhere(['parent_id' => null]);

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
        $query = UserPostComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

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
        $model = UserPosts::findOne(['id' => $id]);
        if ($model && $model->safari_operator_id == $operator->id) {
            return true;
        }
        return false;
    }
}
