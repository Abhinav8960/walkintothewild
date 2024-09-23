<?php

namespace frontend\modules\profile\controllers;

use common\models\cms\blog\Article;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use common\models\UserPosts;
use frontend\controllers\FrontendBaseController;
use yii\web\UploadedFile;
use frontend\models\profile\UserPostsForm;
use Yii;

/**
 * PhotoController.
 */
class PhotoController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        // $userposts = UserPosts::find()->where(['user_id' => $user->id, 'status' => UserPosts::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        $shared_safari = ShareSafari::find()->where(['host_user_id' => $user->id])->all();
        if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
            $blogs = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id])->orderby(['id' => SORT_DESC])->all();
        } else {
            $blogs = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id, 'status' => Article::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        }

        return $this->render(
            'index',
            [
                'user' => $user,
                'blogs' => $blogs,
                'shared_safari' => $shared_safari,

            ]
        );
    }


    // public function actionCreate()
    // {
    //     $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
    //     $model = new UserPostsForm();
    //     $model->action_url = '/profile/photo/create';
    //     $model->action_validate_url = '/profile/photo/validate';
    //     $model->user_id = $user->id;
    //     $model->type_of_post = 1;   // 1 stands for post type photo
    //     $model->status = UserPosts::STATUS_ACTIVE;

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->file = UploadedFile::getInstance($model, 'file');
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->user_photo_model->save(false)) {
    //                     $model->uploadFile();
    //                     \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
    //                     return $this->redirect(['/profile/photo/index', 'user_handle' => $user->user_handle]);
    //                 }
    //             } else {
    //                 print_r($model->errors);
    //                 die();
    //             }
    //         }
    //     } else {
    //         $model->user_photo_model->loadDefaultValues();
    //     }

    //     return $this->renderAjax('_form', [
    //         'model' => $model,
    //         'user' => $user,
    //     ]);
    // }

    // public function actionValidate($slug = null)
    // {
    //     $model = new UserPostsForm();
    //     if ($slug != null) {
    //         $formmodel = $this->findModel($slug);
    //         $model = new UserPostsForm($formmodel);
    //     }

    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    // public function actionDelete($id)
    // {
    //     $model = UserPosts::find()->where(['id' => $id])->one();
    //     $model->status = -1;
    //     $model->save(false);
    //     \Yii::$app->session->setFlash('success', 'Deleted Successfully');
    //     return $this->redirect(\Yii::$app->request->referrer);
    // }

    // public function actionPhotoseeall($user_handle)
    // {
    //     $user = $this->findUserbyHandle($user_handle);
    //     $shared_safari = ShareSafari::find()->where(['host_user_id' => $user->id])->all();
    //     if (Yii::$app->user->identity->id == $user->id) {
    //         $blogs = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id])->orderby(['id' => SORT_DESC])->all();
    //     } else {
    //         $blogs = Article::find()->where(['user_type' => Article::USER_TYPE_INDIVIDUAL, 'user_id' => $user->id, 'status' => Article::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
    //     }
    //     return $this->render(
    //         'photoseeall',
    //         [
    //             'user' => $user,
    //             'blogs' => $blogs,
    //             'shared_safari' => $shared_safari,

    //         ]
    //     );
    // }
}
