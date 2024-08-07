<?php

namespace frontend\components;

use common\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use common\models\PreAuth;
use frontend\models\AuthTemp;

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
            }
            // else{

            //     \Yii::$app->getSession()->setFlash('error', [
            //         Yii::t('app', 'You are not regitered with us', [
            //             'client' => $this->client->getTitle(),
            //         ]),
            //     ]);

            //     return Yii::$app->response->redirect(['/site/login'],403);

            // } 
            else { // signup
                if ($email !== null && User::find()->where(['username' => $email])->orWhere(['email' => $email])->exists()) {
                    $user_found = User::find()->where(['username' => $email])->orWhere(['email' => $email])->one();
                    // Yii::$app->getSession()->setFlash('error', [
                    //     Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    // ]);
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
                    // Yii::$app->session->setFlash('error', 'You are not registered with us');
                    // return Yii::$app->getResponse()->redirect(['site/login']);
                    //  Yii::$app->getSession()->setFlash('error', [
                    //     Yii::t('login', "{client} not registered with us", ['client' => $this->client->getTitle()]),
                    // ]);


                    // start comment by sonu shokeen 
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
                    //$user->generatePasswordResetToken();

                    // end comment by sonu shokeen

                    /*
                    $attributes = $this->client->getUserAttributes();
                    $picture = $attributes['picture'];

                    $temp_key = Yii::$app->security->generateRandomString(20);
                    $temp_auth = new AuthTemp();
                    $temp_auth->rand_key = $temp_key;
                    $temp_auth->name = $nickname;
                    $temp_auth->username = $email;
                    $temp_auth->gmail = $nickname;
                    $temp_auth->email = $email;
                    $temp_auth->source = $this->client->getId();
                    $temp_auth->source_id = (string)$id;
                    $temp_auth->avatar = $picture;
                    $temp_auth->redirect_to = $this->redirect_url;
                    $temp_auth->save(false);

                    return Yii::$app->response->redirect(['/site/signinagree/' . $temp_key,]);
                    exit();
                    */
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
        $this->updateUserInfo($user);
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }
}
