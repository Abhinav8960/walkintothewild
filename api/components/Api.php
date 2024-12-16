<?php

namespace api\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

use common\models\AccessTokens;
use common\models\UserSession;

/**
 * Class for common API functions
 */
class Api extends Component
{


    public function sendResponse($data = false, $additional_info = false, $code = 200)
    {


        $this->setHeader($code);

        $response = [];
        // $response['status'] = true;

        if (is_array($data)) {
            // $response['data'] = $data;
            $response = $data;
            if ($additional_info) {
                $response = array_merge($response, $additional_info);
            }
        } else {
            $response = $data;
        }


        // $response = Json::encode($response, JSON_PRETTY_PRINT);


        if (isset($_GET['callback'])) {
            /* this is required for angularjs1.0 client factory API calls to work */
            $response = $_GET['callback'] . "(" . $response . ")";

            return $response;
        } else {
            return $response;
        }
    }


    public function sendFailedResponse($errors = [], $additional_info = NULL, $error_code = 400)
    {
        $this->setHeader($error_code);
        $msg = [];
        // $response = array('status' => false, 'error_code' => $error_code, 'errors' => $errors);
        $response = ['errors' => $errors];
        if (!empty($additional_info)) {
            $msg['message'] = $additional_info;
            $response = array_merge($response, $msg);
        }
        // return $response = json_encode($response);
        return $response;


        exit;
    }

    public function sendFailedStringResponse($errors = [], $error_code = 400)
    {
        $this->setHeader($error_code);
        // $response = array('status' => false, 'error_code' => $error_code, 'errors' => $errors);
        // $response = ['errors' => $errors];
        $response['message'] = implode(', ', $errors);
        // if (!empty($additional_info)) {
        //     $response = array_merge($response, $msg);
        // }
        // return $response = json_encode($response);
        return $response;


        exit;
    }



    public function sendSuccessResponse($data = false, $additional_info = false)
    {

        $this->setHeader(200);

        $response = [];
        $response['status'] = true;

        if (is_array($data))
            // $response['data'] = $data;
            $response = $data;


        if ($additional_info) {
            $response = array_merge($response, $additional_info);
        }

        // $response = Json::encode($response, JSON_PRETTY_PRINT);


        if (isset($_GET['callback'])) {
            /* this is required for angularjs1.0 client factory API calls to work */
            $response = $_GET['callback'] . "(" . $response . ")";

            return $response;
        } else {
            return $response;
        }

        exit;
    }

    protected function setHeader($status)
    {

        $text = $this->_getStatusCodeMessage($status);

        Yii::$app->response->setStatusCode($status, $text);

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $text;
        $content_type = "application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Travel Creators <https://stagingv2-manage.travelcreators.com/>");
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    }

    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function createAuthorizationCode($user_id)
    {

        $code = md5(uniqid()) . '_' . $user_id . '_' . time();



        return ($code);
    }

    public function createAccesstoken($user, $params = NULL)
    {



        $model = new UserSession();
        $toekn = hash('SHA512', $user->id . '-' . $user->auth_key . '-' . time());
        $model->token =  $toekn;


        $model->id                          = $toekn;
        $model->user_id                     = $user->id;
        $model->ip_address                  = \Yii::$app->request->getUserIP();
        $model->user_platform               = isset($params->platform) ? $params->platform : NULL;
        $model->firebase_token              = isset($params->firebase_token) ? $params->firebase_token : NULL;
        // $model->platform_version    = isset($params->platform_version) ? $params->platform_version : NULL;
        $model->user_browser                = isset($params->browser) ? $params->browser : NULL;
        // $model->browser_version     = isset($params->browser_version) ? $params->browser : NULL;
        $model->user_device                 = isset($params->device) ? $params->device : NULL;
        $model->app_name                    = Yii::$app->params['app_name'];
        $model->created_at                  =  date('Y-m-d H:i:s');
        // $model->updated_at = date('Y-m-d H:i:s');

        $model->save(false);

        return ($model);
    }

    public function refreshAccesstoken($token)
    {
        $access_token = UserSession::findOne(['token' => $token]);
        if ($access_token) {

            $access_token->delete();
            $new_access_token = $this->createAccesstoken($access_token->user);
            return ($new_access_token);
        } else {
            return  Yii::$app->api->sendFailedStringResponse(["Invalid Access token"]);
        }
    }
}
