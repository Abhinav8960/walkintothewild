<?php

namespace frontend\components;

use common\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    public $redirect_url;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client, $redirect_url = '')
    {
        $this->client = $client;
        $this->redirect_url = $redirect_url;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();

        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'name');


        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login

                /* @var User $user */
                $this->loginUser($auth->user);
                return Yii::$app->response->redirect($this->redirect_url != '' ? $this->redirect_url : '/park');
            } else { // signup
                if ($email !== null && User::find()->where(['username' => $email])->orWhere(['email' => $email])->exists()) {
                    $user_found = User::find()->where(['username' => $email])->orWhere(['email' => $email])->one();

                    $auth = new Auth([
                        'user_id' => $user_found->id,
                        'source' => $this->client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    $auth->save();
                    $this->updateUserInfo($auth->user);
                    $this->loginUser($auth->user);
                    return Yii::$app->response->redirect($this->redirect_url != '' ? $this->redirect_url : '/park');
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'name' => $nickname,
                        'username' => $email,
                        'gmail' => $nickname,
                        'email' => $email,
                        'password' => $password,
                        'status' => User::STATUS_ACTIVE // make sure you set status properly
                    ]);
                    $user->generateAuthKey();
                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            $this->loginUser($user);
                            return Yii::$app->response->redirect($this->redirect_url != '' ? $this->redirect_url : '/park');
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
                }
            }
        } else { // user already logged in

            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t(
                        'app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]
                    ),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $picture = $attributes['picture'];
        $google_source_id = $attributes['id'];
        if (!isset($user->name)) {
            $name = $attributes['name'];
            $user->name = $name;
        }
        $user->google_source_id = $google_source_id;
        $gmail = true;
        if ($user->avatar != $picture) {
            $user->avatar = $picture;
        }
        if ($user->gmail == false && $gmail) {
            $user->gmail = $gmail;
        }
        $user->save();
    }

    private function loginUser($user)
    {
        $session = Yii::$app->session;
        if ($session->get('user_session_id')) {
            $session_id =  $session->get('user_session_id');
        } else {
            $session_id = $session->set('user_session_id', session_create_id('user-session'));
        }

        $this->updateUserInfo($user);
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
        $session->set('user_session_id', $session_id);

        $googleToken = Yii::$app->session->get('yii\\authclient\\clients\\Google_google_token');
        if ($googleToken instanceof \yii\authclient\OAuthToken) {
            $googleToken->setParam('expires_in', Yii::$app->params['user.rememberMeDuration']);
            $client = Yii::$app->authClientCollection->getClient('google');
            Yii::$app->session->set('yii\\authclient\\clients\\Google_google_token', $client);
        }
    }
}
