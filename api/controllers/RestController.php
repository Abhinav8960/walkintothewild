<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use common\models\UserSession;
use api\models\User;

class RestController extends Controller
{

    public $request;
    public $queryRequest;
    public $query_params;

    public $enableCsrfValidation = false;

    public $headers;


    public $userinfo;
    public $userinfoId;

    public $pageSize = 10;



    const WEB_API_KEY = "web_qwertyuiop";
    const APP_API_KEY = "app_asdfghjkl";


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => SELF::allowedDomains(),
                // 'Access-Control-Allow-Origin' => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => []
            ]

        ];
        return $behaviors;
    }

    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            'http://localhost:3000',
            'http://localhost:8081',
            'https://spider.triline.in',
        ];
    }

    public function init()
    {
        \Yii::$app->user->enableSession = false;
        Yii::setAlias('@api/controllers/Serializer', '@yii/rest/Serializer');
        // $this->request = json_decode(file_get_contents('php://input'), true);
        $this->request = $_REQUEST;
        $this->queryRequest = Yii::$app->getRequest()->queryParams;
        $this->headers = Yii::$app->getRequest()->getHeaders();

        $this->query_params = $_REQUEST;
        unset($this->query_params['q']);
        unset($this->query_params['r']);
        // $this->storeRequest();
        // $this->isAuthorizeRequest();
        if ($this->request && !is_array($this->request)) {
            Yii::$app->api->sendFailedStringResponse(['Invalid Json']);
        }
        $this->getUser();
        if (isset($this->queryRequest['pageSize'])) {

            if ($this->queryRequest['pageSize'] < 10) {
                $this->pageSize = 10;
            } elseif ($this->queryRequest['pageSize'] > 30) {
                $this->pageSize = 30;
            } else {
                $this->pageSize = $this->queryRequest['pageSize'];
            }
        }
    }



    public function getUser()
    {

        $headers = Yii::$app->getRequest()->getHeaders();
        $this->userinfo =  NULL;

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

        if (!empty($accessToken)) {

            $access_token = UserSession::findOne(['token' => $accessToken]);

            if ($access_token) {
                // if ($access_token->expires_at < time()) {
                //     Yii::$app->api->sendFailedResponse([], 'Access token expired');
                // };

                $this->userinfo = User::findOne(['id' => $access_token->user_id]);
                $this->userinfoId = $this->userinfo->id;
            }
        }
    }


    protected function dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1)
    {
        $data = [];
        $searchModel->load(\Yii::$app->request->queryParams);
        $searchModel->setAttributes(\Yii::$app->request->queryParams);
        if (!empty($additionalSearchQueryParams)) {
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, implode(",", $additionalSearchQueryParams));
        } else {
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        }

        if ($paginationNeededAsPerQuery == 1) {
            if (isset($this->query_params['pagination']) && $this->query_params['pagination'] == 0) {
                $dataProvider->pagination = false;
            }
        }
        // print_r($dataProvider->pagination);

        // die();
        if ($dataProvider->pagination && $singleRecord == false) {

            $dataProvider->pagination->pageSize = $this->pageSize;
            $dataProvider->pagination->validatePage = false;

            $data[$rootIndexName]['summary']['total'] = $dataProvider->getTotalCount();
            $data[$rootIndexName]['summary']['page'] = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
            $data[$rootIndexName]['summary']['pageSize'] = $dataProvider->pagination->pageSize;
            $data[$rootIndexName]['summary']['total_page'] = ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        return $this->reponseSender($data, $rootIndexName, $dataProvider, $singleRecord);
    }

    protected function dataProviderSenderWithoutPagination($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = false)
    {
        $searchModel->load(\Yii::$app->request->queryParams);
        $searchModel->setAttributes(\Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->reponseSender($data = [], $rootIndexName, $dataProvider, $singleRecord);
    }

    private function reponseSender($data = [], $rootIndexName, $dataProvider, $singleRecord = false)
    {
        $data[$rootIndexName]['summary']['query_params'] = $this->query_params;

        // $data[$rootIndexName]['values'] = $dataProvider->join(['clients', 'projectphase'])->getModels();
        $data[$rootIndexName]['data'] = $this->serializeData($dataProvider->getModels());
        if ($singleRecord == true) {
            $data[$rootIndexName]['data'] = $this->serializeData($dataProvider->query->one());
        }
        return Yii::$app->api->sendResponse($data);
    }

    protected function dataSender($array = [], $rootIndexName, $additional_message = [])
    {
        $data[$rootIndexName]['summary']['query_params'] = $this->query_params;
        $data[$rootIndexName]['data'] = $array;


        return Yii::$app->api->sendResponse($data, $additional_message);
    }
}
