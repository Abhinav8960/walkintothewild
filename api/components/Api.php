<?php

namespace api\components;

use api\models\User;
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
        }

        if (Yii::$app->getRequest()->getHeaders()->get('x-encryption') == 1) {

            return $this->encyptResponse($response);
        }

        return $response;
    }


    public function sendFailedResponse($errors = [], $additional_info = null, $error_code = 400)
    {

        $this->setHeader($error_code);
        $msg = [];
        // $response = array('status' => false, 'error_code' => $error_code, 'errors' => $errors);
        $response = ['errors' => $errors];
        if (!empty($additional_info)) {
            $msg['message'] = $additional_info;
            $response = array_merge($response, $msg);
        }
        if (Yii::$app->getRequest()->getHeaders()->get('x-encryption') == 1) {

            return $this->encyptResponse($response);
        }
        if (Yii::$app->getRequest()->getHeaders()->get('x-encryption') == 1) {

            return $this->encyptResponse($response);
        }

        return $response = json_encode($response);
        // return $this->send($response);


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
        if (Yii::$app->getRequest()->getHeaders()->get('x-encryption') == 1) {

            return $this->encyptResponse($response);
        }

        echo json_encode($response);

        exit;
    }

    private function encyptResponse($data)
    {
        $platform = \Yii::$app->request->headers->get('x-platform', 'web');
        $key = \Yii::$app->params['aes_keys'][$platform] ?? \Yii::$app->params['aes_keys']['web'];
        $encrypted = \common\components\AesCrypto::encrypt($data, $key);
        // $decrypted = \common\components\AesCrypto::decrypt($encrypted, $key);
        // return ['encrypted' => $encrypted, 'decrypted'=>$decrypted];
        return ['data' => $encrypted];
    }




    // public function sendSuccessResponse($data = false, $additional_info = false)
    // {

    //     $this->setHeader(200);

    //     $response = [];
    //     $response['status'] = true;

    //     if (is_array($data))
    //         // $response['data'] = $data;
    //         $response = $data;


    //     if ($additional_info) {
    //         $response = array_merge($response, $additional_info);
    //     }

    //     // $response = Json::encode($response, JSON_PRETTY_PRINT);


    //     if (isset($_GET['callback'])) {
    //         /* this is required for angularjs1.0 client factory API calls to work */
    //         $response = $_GET['callback'] . "(" . $response . ")";

    //         return $response;
    //     } else {
    //         return $response;
    //     }

    //     exit;
    // }

    protected function setHeader($status)
    {

        $text = $this->_getStatusCodeMessage($status);

        Yii::$app->response->setStatusCode($status, $text);

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $text;
        $content_type = "application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "WalkIntoTheWild <http://staging-manage.walkintothewild.in/>");
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



    public function createAccesstoken($user, $params = null)
    {

        $headers = Yii::$app->getRequest()->getHeaders();

        $device = strtolower($headers->get('x-device')) ?? null;
        $platform = strtolower($headers->get('x-platform')) ?? null;
        $platform_version = strtolower($headers->get('x-platform-version')) ?? null;
        $application_version = strtolower($headers->get('x-application-version')) ?? null;

        $model = new UserSession();
        $toekn = hash('SHA512', $user->id . '-' . $user->auth_key . '-' . time());
        $model->token =  $toekn;

        $model->id                          = $toekn;
        $model->user_id                     = $user->id;
        $model->ip_address                  = \Yii::$app->request->getUserIP();
        $model->firebase_token              = isset($params->firebase_token) ? $params->firebase_token : null;
        // $model->platform_version    = isset($params->platform_version) ? $params->platform_version : NULL;
        $model->user_browser                = isset($params->browser) ? $params->browser : null;
        // $model->browser_version     = isset($params->browser_version) ? $params->browser : NULL;
        $model->user_device                 = isset($params->device) ? $params->device : $device;
        $model->user_platform               = isset($params->platform) ? $params->platform : $platform;
        $model->user_platform_version       = isset($params->platform_version) ? $params->platform_version : $platform_version;
        $model->application_version         = isset($params->application_version) ? $params->application_version : $application_version;
        $model->app_name                    = Yii::$app->params['app_name'];
        $model->created_at                  =  date('Y-m-d H:i:s');
        // $model->updated_at = date('Y-m-d H:i:s');
        $this->updateAvtar($user, $params);
        $model->save(false);

        return ($model);
    }

    private function updateAvtar($user, $params)
    {
        if (!empty($params->avatar) && $user->avatar != $params->avatar) {
            $u = User::findOne(['id' => $user->id]);
            $u->avatar = $params->avatar;
            // $u->save(false);

            $fileName = $u->id . '_google_avatar' . '.jpg';

            $url = $u->avatar;
            $content = @file_get_contents($url);

            if ($content != false) {
                $tempPath = tempnam(sys_get_temp_dir(), $u->id . '_google_avatar') . '.jpg';
                file_put_contents($tempPath, $content);

                $uploadedFile = new \yii\web\UploadedFile([
                    'name' => $fileName,
                    'tempName' => $tempPath,
                    'type' => 'image/jpg',
                    'size' => filesize($tempPath),
                    'error' => UPLOAD_ERR_OK,
                ]);

                $filePath = 'user/profile/' . $fileName;

                $avatar_image = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);

                $u->google_avatar_image = $fileName;
                @unlink($tempPath);
            }
            $u->save(false);
        }
        return true;
    }
}
