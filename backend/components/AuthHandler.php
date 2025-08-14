<?php

namespace backend\components;

use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();

        $email = ArrayHelper::getValue($attributes, 'email');
        $source_id = ArrayHelper::getValue($attributes, 'id'); // Get source_id from attributes

        if (Yii::$app->user->isGuest) {
            $user = User::find()->where([
                'email' => $email,
                'google_source_id' => $source_id, // Match source_id
                // 'is_adminstrator' => true,
                'is_admin' => true,
                'status' => User::STATUS_ACTIVE
            ])->one();

            if ($user) { // Login existing user
                $this->loginUser($user);
            } else { // Do not create a new user
                Yii::$app->session->setFlash('error', 'You are not registered with us.');
                return Yii::$app->getResponse()->redirect(['site/login']);
            }
        } else { // User already logged in
            Yii::$app->session->setFlash('info', 'You are already logged in.');
        }
    }

    private function loginUser($user)
    {
        $session = Yii::$app->session;
        if (!$session->get('user_session_id')) {
            $session->set('user_session_id', session_create_id('user-session'));
        }

        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }
}