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
use common\Helper\FrontendNotificationHelper;
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

        $user_experiences = UserExperience::find()->where(['user_id' => $user->id, 'status' => UserExperience::STATUS_ACTIVE])->orderby(['id' => SORT_DESC])->all();
        return $this->render(
            'index',
            [
                'user' => $user,
                'user_experiences' => $user_experiences
            ]
        );
    }

    public function actionFollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if (Yii::$app->user->identity) {
            if (Yii::$app->user->identity->id == $user->id) {
                Yii::$app->session->setFlash('success', "You can't follow yourself!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $user->id])->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->user_id = Yii::$app->user->identity->id;
            $follower->follow_user_id = $user->id;
            $follower->status = 1;
            $follower->save(false);

            FrontendNotificationHelper::userNewFollower($user, Yii::$app->user->identity);

            Yii::$app->session->setFlash('success', "Follow Successfully!!");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUnfollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if (Yii::$app->user->identity) {
            $my_follower = UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $user->id])->one();
            $my_follower->user_id = Yii::$app->user->identity->id;
            $my_follower->follow_user_id = $user->id;
            $my_follower->status = 0;
            $my_follower->save(false);
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
        // $model->user_id = $user->id;
        // $model->status = UserExperience::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                foreach ($model->parks as $park) {
                    $model_user_experience =  UserExperience::find()->where(['user_id' => $user->id, 'park_id' => $park])->limit(1)->one();
                    if (!$model_user_experience) {
                        $model_user_experience = new UserExperience();
                    }
                    $model_user_experience->park_id = $park;
                    $model_user_experience->user_id = $user->id;
                    $model_user_experience->status = UserExperience::STATUS_ACTIVE;
                    $model_user_experience->save(false);
                }
                \Yii::$app->session->setFlash('success', 'Experience Add Successfully');
                return $this->redirect(['/profile/default/index', 'user_handle' => $user->user_handle]);
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
