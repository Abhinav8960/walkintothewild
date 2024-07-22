<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use common\models\RenderedContent;
use common\models\trierror\FrontendRequestLog;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * FrontendBaseController
 */
class FrontendBaseController extends Controller
{

    /**
     * Actions ids for Save Page Views
     */
    public $action_ids = ['index'];

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        parent::afterAction($action, $result);

        //start code to each request trace by sonu shokeen
        $request = Yii::$app->request;
        $user = Yii::$app->user;
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $response = Yii::$app->response;

        $route = "";
        $route_map = $request->resolve();
        if(isset($route_map[0])){
            $route = $route_map[0];
        }
         
        $system_type = '';
        if ($agent->isMobile()) {
            $system_type = 'Mobile';
        } else if ($agent->isTablet()) {
            $system_type = 'Tablet';
        } else if ($agent->isDesktop()) {
            $system_type = 'Desktop';
        }

        $isAjax = 0;
        if($request->isAjax){
            $isAjax = 1;
        }

        $userid = 0;
        if(isset($user->id) && !empty($user->id)){
            $userid = $user->id;
        }

        $slug = '';
        if (array_key_exists('slug', $request->queryParams)) {
            $slug = $request->queryParams['slug'];
        }

        $request_url = $request->pathInfo;
        if (strpos($request_url, 'storage') === false){
            $model = new FrontendRequestLog();
            $model->user_id = $userid;
            $model->slug = $slug;
            $model->route = $route;
            $model->request_url = $request->pathInfo;
            $model->request_full_url = $request->absoluteUrl;
            $model->request_type = $request->method;
            $model->request_parameter = json_encode($request->queryParams);
            $model->user_ip = $request->getRemoteIP();
            $model->request_data = json_encode($request->post());
            $model->request_code = $response->statusCode;
            $model->is_server_error = $response->isServerError;
            $model->is_client_error = $response->isClientError;
            $model->response_error = $response->statusText;
            $model->isAjax = $isAjax;
            $model->device = $agent->device();
            $model->system = $system_type;
            $model->platform = $agent->platform();
            $model->browser = $agent->browser();
            $model->browser_version = $agent->version($agent->browser());
            $model->save(false);
        }
        //start code to each request trace by sonu shokeen

        if (in_array($action->id, $this->action_ids)) {
            $this->savePageViews();
        }

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

    /**
     * Find User by Handle
     */
    public function findUserbyHandle($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->limit(1)->one()) {
            return $user;
        }

        throw new ForbiddenHttpException('User Not Found');
    }
}
