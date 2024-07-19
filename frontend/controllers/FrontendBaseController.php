<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use common\models\RenderedContent;
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
