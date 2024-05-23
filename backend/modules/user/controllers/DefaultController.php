<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
     
        if (Yii::$app->user->identity && Yii::$app->user->identity->is_adminstrator != 1) {
            throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Adminstrator can view this page.');
        }
        $model = new UserRegistrationForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_model->save()) {
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
