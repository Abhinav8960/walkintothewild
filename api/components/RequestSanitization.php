<?php

namespace api\components;

use common\models\AccessTokens;
use Yii;

class RequestSanitization extends \yii\base\Component
{

    public $tokenParam = 'access-token';

    public $user;

    public function init()
    {
        \Yii::$app->params['active_user_id']  = NULL;


        $excludedArrayForAuthentication = [
            'social-login',
            'reset-social-login',
            'can-social-login',
            'otp-verification-social-login',
            'verify-social-login',
            'master-meta-info',
            'master',
            'meta',
            'file',
            'cms',
            'park',
            'filter-parklist',
            // 'posts',
            'plan',

        ];

        $request_array = explode('/', Yii::$app->request->getPathInfo());
        $headers = Yii::$app->getRequest()->getHeaders();

        $intersect_array_for_authentication =  array_intersect($excludedArrayForAuthentication, $request_array);

        if (empty($intersect_array_for_authentication) && \Yii::$app->request->isPost) {

            $accessToken = NULL;
            $authorizationHeader = $headers->get('Authorization');

            if (!empty($authorizationHeader) && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                $accessToken = $matches[1];
            } 
            // else {
            //     return \Yii::$app->api->sendFailedStringResponse(['Authorization Bearer token not found'], 401);
            // }
            if (isset($_GET['access_token'])) {
                $accessToken = $_GET['access_token'];
            } elseif (isset($_GET['access-token'])) {
                $accessToken = $_GET['access-token'];
            } elseif (!empty($headers->get('x-access-token'))) {
                $accessToken = $headers->get('x-access-token');
            } else {
                $accessToken = $headers->get('x-access_token');
            }

            if (!empty($accessToken)) {

                $this->user =  \common\models\User::findIdentityByAccessToken($accessToken);
                if ($this->user == false) {
                    return \Yii::$app->api->sendFailedStringResponse(['Token is invalid or expired'], 401);
                }
                \Yii::$app->params['active_user_id'] = $this->user->id;
            } else {
                return \Yii::$app->api->sendFailedStringResponse(['Token not found'], 401);
            }

            if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
                Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
                Yii::$app->end();
            }
        }





        parent::init();
    }
}
