<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Auth;
use common\models\User;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\models\PreAuth;
use frontend\models\AuthTemp;

/**
 * DefaultController.
 */
class TermsandconditionController extends FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render(
            'index'
        );
    }

    public function actionConfirmation($key)
    {
        $model = AuthTemp::find()->where(['rand_key' => $key])->one();
        if (empty($model)) {
            return Yii::$app->response->redirect('/');
        }

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AuthTemp');

            if ($data['status']) {
                $password = Yii::$app->security->generateRandomString(6);
                $user = new User([
                    'name' => $model->name,
                    'username' => $model->username,
                    'gmail' => $model->gmail,
                    'email' => $model->email,
                    'google_source_id' => $model->source_id,
                    'avatar' => $model->avatar,
                    'password' => $password,
                    'status' => User::STATUS_ACTIVE // make sure you set status properly
                ]);
                $user->generateAuthKey();
                //$user->generatePasswordResetToken();

                $transaction = User::getDb()->beginTransaction();

                if ($user->save()) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $model->source,
                        'source_id' => $model->source_id,
                    ]);
                    if ($auth->save()) {
                        $transaction->commit();
                        $this->loginUser($user);
                        return Yii::$app->response->redirect('/');
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save {client} account: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($auth->getErrors()),
                            ]),
                        ]);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to save user: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($user->getErrors()),
                        ]),
                    ]);
                }
            } else {
                return Yii::$app->response->redirect('/');
            }
        }

        return $this->render(
            'index',
            [
                'model' => $model,
                'key' => $key
            ]
        );
    }

    private function loginUser($user)
    {
        //$this->updateUserInfo($user);
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }
}
