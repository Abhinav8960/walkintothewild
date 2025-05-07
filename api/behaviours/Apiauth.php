<?php

namespace api\behaviours;

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

//namespace yii\filters\auth;
use Yii;
use yii\filters\auth\AuthMethod;
use common\models\HaikuApps;

/**
 * QueryParamAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Apiauth extends AuthMethod
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'access-token';

    public $exclude = [];
    public $callback = [];
    public $apiRequestId;




    public function beforeAction($action)
    {



        if (
            in_array($action->id, $this->exclude) &&
            !isset($_GET['access-token'])
        ) {

            return true;
        }

        //if (!$this->verifyApp())
        //    Yii::$app->api->sendFailedStringResponse('Invalid Request(App not verified)');


        if (
            in_array($action->id, $this->callback) &&
            !isset($_GET['access-token'])
        ) {
            //Yii::$app->api->sendFailedStringResponse("error1");
            // Yii::$app->api->sendSuccessResponse(["nice1"]);
            // exit;
            return true;
        }



        $response = $this->response ?: Yii::$app->getResponse();

        $identity = $this->authenticate(
            $this->user ?: Yii::$app->getUser(),
            $this->request ?: Yii::$app->getRequest(),
            $response
        );

        if ($identity !== null) {
            return true;
        } else {
            $this->challenge($response);
            $this->handleFailure($response);

           return \Yii::$app->api->sendFailedStringResponse(['Invalid Request']);
            //return false;
        }
    }


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $headers = Yii::$app->getRequest()->getHeaders();

        $accessToken = NULL;
        if (isset($_GET['access_token'])) {
            $accessToken = $_GET['access_token'];
        } else {
            $accessToken = $headers->get('x-access_token');
        }

        if (empty($accessToken)) {

            if (isset($_GET['access-token'])) {
                $accessToken = $_GET['access-token'];
            } else {
                $accessToken = $headers->get('x-access-token');
            }
        }

        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            } else {
                return \Yii::$app->api->sendFailedStringResponse(['Access token is not valid'], 419);
            }
        }

        if ($accessToken !== null) {

            return \Yii::$app->api->sendFailedStringResponse(['Access token not found'],400);

            // $this->handleFailure($response);
        }


        return null;
    }

    /**
     * @inheritdoc
     */
    public function handleFailure($response)
    {
        return \Yii::$app->api->sendFailedStringResponse(['Access token not found']);
    }
}
