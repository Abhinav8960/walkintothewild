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
        // Handle preflight CORS requests
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST, GET, PUT');
            Yii::$app->end();
        }

        \Yii::$app->params['active_user_id'] = null;

        $excludedRoutes = [
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
            'plan',
            'signup',
            'mail-otp-verification',
            'signup-via-password',
            'mobile-otp-verification',
            'login-via-password',

        ];

        $requestPath = explode('/', Yii::$app->request->getPathInfo());
        $headers = Yii::$app->getRequest()->getHeaders();

        // Skip authentication for excluded routes
        if (!array_intersect($excludedRoutes, $requestPath) && \Yii::$app->request->isPost) {
            $accessToken = $this->getAccessTokenFromRequest($headers);

            if (empty($accessToken)) {
                return \Yii::$app->api->sendFailedStringResponse(['Token not found'], 401);
            }

            $this->user = \common\models\User::findIdentityByAccessToken($accessToken);
            if (!$this->user) {
                return \Yii::$app->api->sendFailedStringResponse(['Token is invalid or expired'], 401);
            }

            \Yii::$app->params['active_user_id'] = $this->user->id;
        }

        parent::init();
    }

    private function getAccessTokenFromRequest($headers)
    {
        $authorizationHeader = $headers->get('Authorization');

        if (!empty($authorizationHeader) && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return $matches[1];
        }

        // Support for token in query params or custom headers
        return $_GET['access_token'] ??
            $_GET['access-token'] ??
            $headers->get('x-access-token') ??
            $headers->get('x-access_token');
    }
}
