<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\Auth;
use common\models\User;
use yii\web\Controller;
use common\models\MailLog;
use common\models\UserFollow;
use common\models\UserSearch;
use common\models\UserUpdateForm;
use common\models\UserRegistrationForm;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->status = User::STATUS_ACTIVE;
        // $searchModel->is_mobile_no_verified = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }


    /**
     * Create a New User
     */
    public function actionCreate()
    {

        if (Yii::$app->user->identity && !(Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin)) {
            throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Adminstrator can view this page.');
        }
        $model = new UserRegistrationForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save()) {
                        $user = $model->user_model;

                        $to_mail = $user->email;
                        $subject = 'User Regitration';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_USER_REGISTERATION;
                        $req = ['username' => $user->name, 'is_email_sending' => true];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                        \Yii::$app->session->setFlash('success', 'User Registration Successfully Completed');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update User
     */
    public function actionUpdate($user_id)
    {
        if (Yii::$app->user->identity && Yii::$app->user->identity->is_adminstrator != 1) {
            throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Adminstrator can view this page.');
        }
        $user = $this->findModel($user_id);
        $model = new UserUpdateForm($user);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    Yii::$app->session->setFlash('success', 'User has been successfully Updated');
                    return $this->redirect(['/user']);
                }
            }
        } else {
            $model->user_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Block/Unblock a User
     *
     * @param [type] $id
     * @param string $back
     * @return void
     */
    public function actionBlock($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('error', 'You can not block your own account');
        } else {
            $user = $this->findModel($id);
            if ($user->getIsBlocked()) {
                $user->unblock();
                \Yii::$app->getSession()->setFlash('success', 'User has been unblocked');
            } else {
                $user->block();
                \Yii::$app->getSession()->setFlash('success', 'User has been blocked');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $user->username = $user->username . rand();
        $user->email = $user->email . rand();
        $user->google_source_id = 0;
        $user->status = User::STATUS_DELETED;
        if ($user->save()) {
            $isexist = Auth::find()->where(['user_id' => $id])->one();
            if (!empty($isexist)) {
                $isexist->delete();
            }
        }

        \Yii::$app->getSession()->setFlash('success', 'User has been deleted');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Switch Identity to This User
     *
     * @param [type] $id
     * @return void
     */
    public function actionSwitchidentity($id)
    {
        $user = $this->findModel($id);
        if ((Yii::$app->user->identity && Yii::$app->user->identity->role_id == 10)) {
            Yii::$app->user->switchIdentity($user, 3600);
            return $this->redirect('/');
        }
        throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action.');
    }


    /**
     * View Profile of User
     */
    public function  actionProfile($user_id)
    {
        $user = $this->findModel($user_id);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UserFollow::find()->joinWith('user')->where(['follow_user_id' => $user->id])->andwhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]),
            'pagination' => ['pageSize' => 30]
        ]);

        $following_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UserFollow::find()->joinWith('user')->where(['user_id' => $user->id])->andwhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]),
            'pagination' => ['pageSize' => 30]
        ]);
        return $this->render('profile', [
            'user' => $user,
            'dataProvider' => $dataProvider,
            'following_dataProvider' => $following_dataProvider
        ]);
    }


    /**
     * Find User By Id
     *
     * @param [type] $id
     * @return User
     */
    protected function findModel($id)
    {
        $user = User::find()->where(['id' => $id])->one();

        if ($user === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist');
        }
        return $user;
    }
}
