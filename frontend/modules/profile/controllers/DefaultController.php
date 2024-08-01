<?php

namespace frontend\modules\profile\controllers;

use Yii;
use yii\web\Response;
use common\models\User;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use common\models\UserFollow;
use common\models\BlockedModel;
use common\models\UserExperience;
use frontend\models\profile\UserForm;
use common\models\sharesafari\ShareSafari;
use frontend\models\profile\UserExperienceForm;
use frontend\controllers\FrontendBaseController;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'follow' => ['post'],
                    'unfollow' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $model = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();
        $user_experiences = UserExperience::find()->where(['user_id' => $user->id, 'status' => UserExperience::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        return $this->render(
            'index',
            [
                'user' => $user,
                'model' => $model,
                'model_count' => $model_count,
                'user_experiences' => $user_experiences
            ]
        );
    }

    public function actionFollow($id)
    {
        if (Yii::$app->user->identity) {
            if (Yii::$app->user->identity->id == $id) {
                Yii::$app->session->setFlash('error', "You can't follow yourself!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $id])->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->user_id = Yii::$app->user->identity->id;
            $follower->follow_user_id = $id;
            $follower->status = 1;
            $follower->save(false);
            Yii::$app->session->setFlash('success', "Follow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUnfollow($id)
    {
        if (Yii::$app->user->identity) {
            $follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $id])->one();
            $follower->user_id = Yii::$app->user->identity->id;
            $follower->follow_user_id = $id;
            $follower->status = 0;
            $follower->save(false);
            Yii::$app->session->setFlash('success', "Unfollow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * User Follower
     */
    public function actionFollower($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);

        return $this->render('follower', ['user' => $user]);
    }

    /**
     * User Following
     */
    public function actionFollowing($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);

        return $this->render('following', ['user' => $user]);
    }

    public function actionCoverUpload()
    {
        if (Yii::$app->request->isAjax) {
            $user_model = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
            $user = new UserForm($user_model);
            $user->cover_image = UploadedFile::getInstanceByName('file');
            if ($user->validate() &&  $user->uploadFile()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'message' => 'Profile Image uploaded successfully'];
            } else {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'message' => $user->errors];
            }
        }
    }

    public function actionProfileUpload()
    {
        if (Yii::$app->request->isAjax) {
            $user_model = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
            $user = new UserForm($user_model);
            $user->profile_image = UploadedFile::getInstanceByName('file');
            if ($user->validate() &&  $user->uploadFile()) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => true, 'message' => 'Profile Image uploaded successfully'];
            } else {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => false, 'message' => $user->errors];
            }
        }
    }



    public function actionCreate()
    {
        $user = $this->findUserbyHandle(Yii::$app->user->identity->user_handle);
        $model = new UserExperienceForm();
        $model->action_url = '/profile/default/create';
        $model->action_validate_url = '/profile/default/validate';
        $model->user_id = $user->id;
        $model->status = UserExperience::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_experience_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/profile/default/index', 'user_handle' => $user->user_handle]);
                    }
                } else {
                    print_r($model->errors);
                    die();
                }
            }
        } else {
            $model->user_experience_model->loadDefaultValues();
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionValidate($slug = null)
    {
        $model = new UserExperienceForm();
        if ($slug != null) {
            $formmodel = $this->findModel($slug);
            $model = new UserExperienceForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionDelete($id)
    {
        $model = UserExperience::find()->where(['id' => $id])->one();
        $model->status = -1;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Deleted Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }
}
