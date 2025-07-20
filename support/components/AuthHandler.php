<?php

namespace support\components;

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
        $source_id = ArrayHelper::getValue($attributes, 'id'); // Use source_id for login
        $nickname = ArrayHelper::getValue($attributes, 'name');

        if (Yii::$app->user->isGuest) {
            $user = User::find()->where([
                'email' => $email,
                'google_source_id' => $source_id, // Match source_id
                'status' => User::STATUS_ACTIVE
            ])->one();

            if ($user) { // Login existing user
                $this->loginUser($user);
                return Yii::$app->response->redirect($this->redirect_url != '' ? $this->redirect_url : '/');
            } else { // Do not create a new user
                Yii::$app->session->setFlash('error', 'You are not registered with us.');
                return Yii::$app->getResponse()->redirect(['site/login']);
            }
        } else { // User already logged in
            Yii::$app->session->setFlash('info', 'You are already logged in.');
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
        if (!$session->get('user_session_id')) {
            $session->set('user_session_id', session_create_id('user-session'));
        }

        $this->updateUserInfo($user);
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }
}