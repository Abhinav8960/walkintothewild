<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use common\models\UserSession;
use api\models\User;
use common\models\RenderedContent;
use common\models\trierror\ApiRequestLog;
use common\models\trierror\FrontendRequestLog;

class RestController extends Controller
{

    public $request;
    public $queryRequest;
    public $query_params;

    public $enableCsrfValidation = false;

    public $headers;


    public $userinfo;
    public $userinfoId;
    public $access_token;

    public $pageSize = 2;



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

        // if(count($this->query_params) <= 0 ){
        //     $this->query_params = NULL;
        // }
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
                $this->access_token = $access_token;
                // if ($access_token->expires_at < time()) {
                //     Yii::$app->api->sendFailedResponse([], 'Access token expired');
                // };

                \Yii::$app->params['active_user'] =   $this->userinfo = User::findOne(['id' => $access_token->user_id]);
                \Yii::$app->params['active_user_id'] = $this->userinfoId = $this->userinfo->id;
            }
        }
    }


    protected function dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "search")
    {
        // print_r($additionalSearchQueryParams);
        // die();
        $data = [];
        $searchModel->load(\Yii::$app->request->queryParams);
        $searchModel->setAttributes(\Yii::$app->request->queryParams);
        if (!empty($additionalSearchQueryParams)) {
            $dataProvider = $searchModel->$searchfunction(\Yii::$app->request->queryParams, implode(", ", $additionalSearchQueryParams));
        } else {
            $dataProvider = $searchModel->$searchfunction(\Yii::$app->request->queryParams);
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

           
            $data[$rootIndexName]['summary']['total'] = (int) $dataProvider->getTotalCount();
            $data[$rootIndexName]['summary']['page'] =  \Yii::$app->request->get('page') ? (int) \Yii::$app->request->get('page') : 1;
            $data[$rootIndexName]['summary']['pageSize'] = (int) $dataProvider->pagination->pageSize;
            $data[$rootIndexName]['summary']['total_page'] = (int) ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
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


    protected function querySender($dataProvider, $rootIndexName = 0, $singleRecord = false)
    {
        $data = [];
        if ($dataProvider->pagination && $singleRecord == false) {

            $dataProvider->pagination->pageSize = $this->pageSize;
            $dataProvider->pagination->validatePage = false;

            $data[$rootIndexName]['summary']['total'] = (int) $dataProvider->getTotalCount();
            $data[$rootIndexName]['summary']['page'] = \Yii::$app->request->get('page') ? (int) \Yii::$app->request->get('page') : 1;
            $data[$rootIndexName]['summary']['pageSize'] =  (int) $dataProvider->pagination->pageSize;
            $data[$rootIndexName]['summary']['total_page'] = (int) ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        return $this->reponseSender($data, $rootIndexName, $dataProvider, $singleRecord);
    }

    private function reponseSender($data = [], $rootIndexName, $dataProvider, $singleRecord = false)
    {

        // $data[$rootIndexName]['values'] = $dataProvider->join(['clients', 'projectphase'])->getModels();
        if ($singleRecord == true) {
            $data['summary']['query_params'] = $this->query_params;

            $data['data'] = $this->serializeData($dataProvider->query->one());
        } else {
            $data[$rootIndexName]['summary']['query_params'] = $this->query_params;

            $data[$rootIndexName]['data'] = $this->serializeData($dataProvider->getModels());
        }
        return Yii::$app->api->sendResponse($data);
    }

    protected function dataSender($array = [], $rootIndexName, $additional_message = [])
    {
        $data[$rootIndexName]['summary']['query_params'] = $this->query_params;
        $data[$rootIndexName]['data'] = $array;


        return Yii::$app->api->sendResponse($data, $additional_message);
    }


    protected function dataProviderSenderWithCondition($searchModel, $rootIndexName = 0, $condition = NULL, $defaultsort = NULL,  $singleRecord = false, $paginationNeededAsPerQuery = 1)
    {
        $data = [];
        $searchModel->load(\Yii::$app->request->queryParams);
        $searchModel->setAttributes(\Yii::$app->request->queryParams);

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        if (!empty($condition)) {
            $dataProvider->query->andWhere($condition);
        }

        if (!empty($defaultsort)) {
            $dataProvider->sort->defaultOrder = $defaultsort;
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

            $data[$rootIndexName]['summary']['total'] = (int) $dataProvider->getTotalCount();
            $data[$rootIndexName]['summary']['page'] =  \Yii::$app->request->get('page') ? (int) \Yii::$app->request->get('page') : 1;
            $data[$rootIndexName]['summary']['pageSize'] =  (int) $dataProvider->pagination->pageSize;
            $data[$rootIndexName]['summary']['total_page'] = (int) ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize);
        }

        return $this->reponseSender($data, $rootIndexName, $dataProvider, $singleRecord);
    }



    public function afterAction($action, $result)
    {
        parent::afterAction($action, $result);


        //start code to each request trace by sonu shokeen
        $request = Yii::$app->request;
        $user = $this->userinfo;
        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        // $refer_url = Yii::$app->request->referrer;
        $response = Yii::$app->response;


        // $system_type = '';
        // if ($agent->isMobile()) {
        //     $system_type = 'Mobile';
        // } else if ($agent->isTablet()) {
        //     $system_type = 'Tablet';
        // } else if ($agent->isDesktop()) {
        //     $system_type = 'Desktop';
        // }

        // $route = "";
        // $route_map = $request->resolve();
        // if (isset($route_map[0])) {
        //     $route = $route_map[0];
        // }


        $userid = 0;
        if (isset($user->id) && !empty($user->id)) {
            $userid = $user->id;
        }

        $slug = 'N/A';
        if (array_key_exists('slug', $request->queryParams)) {
            $slug = $request->queryParams['slug'];
        }

        $request_url = $request->pathInfo;
        if (strpos($request_url, 'storage') === false) {
            $model = new ApiRequestLog();
            $model->user_id = $userid;
            $model->slug = $slug;
            $model->route = NULL; //$route;
            $model->request_url = $request->pathInfo;
            $model->request_full_url = $request->absoluteUrl;
            $model->request_type = $request->method;
            $model->request_parameter = json_encode($request->queryParams);
            $model->user_ip = $request->getRemoteIP();
            $model->request_data = json_encode($request->get());
            $model->request_code = $response->statusCode;
            $model->is_server_error = $response->isServerError;
            $model->is_client_error = $response->isClientError;
            $model->response_error = $response->statusText;
            $model->device = NULL; //$agent->device();

            // if(is_array($result)){
            //     $result =  json_encode($result);
            // }
            $model->response =  json_encode($result);

            $model->system = NULL; //$system_type;
            $model->platform = NULL; //$agent->platform();
            $model->browser = NULL; //$agent->browser();
            $model->browser_version = NULL; //$agent->version($agent->browser());
            $model->save(false);
        }
        //end code to each request trace by sonu shokeen

        // if (in_array($action->id, $this->action_ids)) {
        //     $this->savePageViews();
        // }

        $event = new \yii\base\ActionEvent($action);
        $event->result = $result;
        $this->trigger(self::EVENT_AFTER_ACTION, $event);
        return $event->result;
    }

    /**
     * Save Page Views
     */
    public function savePageViews()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $renderedContent = new RenderedContent();
        $renderedContent->url = substr(Yii::$app->request->absoluteUrl, 0, 1024);
        $renderedContent->title = substr(Yii::$app->view->title, 0, 512);
        $renderedContent->action_url = substr(Yii::$app->request->url, 0, 512);
        $queryParams = Yii::$app->request->getQueryParams();
        $renderedContent->query_params = json_encode($queryParams);
        $renderedContent->user_agent = Yii::$app->request->userAgent;
        $renderedContent->ip_address = Yii::$app->request->userIP;
        $renderedContent->user_device  = $agent->device();
        $renderedContent->user_platform = $agent->platform();
        $renderedContent->user_browser = $agent->browser();
        $renderedContent->user_session_id = Yii::$app->session->get('user_session_id');
        if (Yii::$app->user->identity) {
            $renderedContent->user_id = Yii::$app->user->identity->id;
        }
        $renderedContent->created_at = date('Y-m-d H:i:s');
        $renderedContent->save(false);
    }

    /**
     * Get Device Type
     */
    public function device()
    {
        return (\Yii::$app->mobileDetect->isMobile()) ? 'mobile' : 'desktop';
    }
}
