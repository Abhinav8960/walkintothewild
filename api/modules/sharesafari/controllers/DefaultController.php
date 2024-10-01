<?php

namespace api\modules\sharesafari\controllers;

use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\sharesafari\ShareSafariSearch;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafariParklist;
use frontend\models\form\CreateDepartureForm;
use frontend\models\form\SharedSafariForm;

/**
 * Site controller
 */
class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'organize-safari' => ['POST'],

                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $searchModel->status =  ShareSafariSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Share Safari");
    }

    public function actionOrganizeSafari()
    {
        $model = new SharedSafariForm();
        $model->host_user_id = $this->userinfoId;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->type = ShareSafari::TYPE_SAFARI;
        $model->host_type = 1;

        $login_user = $this->userinfo;
        if ($login_user = $this->userinfo) {
            if ($login_user->x_url <> '') {
                $model->website_url = $login_user->x_url;
            }
            if ($login_user->insta_url <> '') {
                $model->website_url = $login_user->insta_url;
            }
            if ($login_user->facebook_url <> '') {
                $model->website_url = $login_user->facebook_url;
            }
        }

        $model->attributes = $this->request;
        $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_model->save()) {
                $model->UploadFiles($model->shared_safari_model->id);
                if ($model->shared_safari_model->user) {
                    $user = $model->shared_safari_model->user;
                    $username = $user->name;
                    $to_mail = Yii::$app->params['adminEmail'];
                    $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_CREATEDBY_USER;
                    $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ?: '']);

                    $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                    $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                    if (!empty($maillog_data['log_id'])) {
                        GeneralModel::sendmailfromlog($maillog_data['log_id']);
                    }
                }
                Yii::$app->api->sendResponse($data = [$model->shared_safari_model->attributes], ['message' => "Shared safari created successfully"]);
            }
        }

        Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionJoin($id)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if ($share_safari) {
            if ($this->userinfo) {
                if ($this->userinfo->operator) {
                    return Yii::$app->api->sendResponse($data = [], ['message' => "Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris."]);
                }
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => $this->userinfoId, 'share_safari_id' => $share_safari->id])->one();
                if (!$share_safari_intrested) {
                    $share_safari_intrested = new ShareSafariIntrested();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                $share_safari_intrested->user_device  = $agent->device();
                $share_safari_intrested->user_platform = $agent->platform();
                $share_safari_intrested->user_browser = $agent->browser();
                $share_safari_intrested->park_id = $share_safari->park_id;
                $share_safari_intrested->share_safari_id = $share_safari->id;
                $share_safari_intrested->user_id = $this->userinfoId;
                $share_safari_intrested->status = 1;
                $share_safari_intrested->intrested_at = time();
                if ($share_safari_intrested->save(false)) {
                    FrontendNotificationHelper::sharedSafariJoin($share_safari, $this->userinfo);
                    Yii::$app->api->sendResponse($data = [], ['message' => "You joined this shared safari!"]);
                }
            }
        }
        Yii::$app->api->sendFailedStringResponse($share_safari->firstErrors, 400);
    }


    // public function actionCreateFixedDeparture()
    // {
    //     $safari_operator = SafariOperator::find()->where(['user_id' => $this->userinfoId])->limit(1)->one();
    //     if(!$safari_operator)
    //     {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "You are not operator."]);
    //     }
    //     $model = new CreateDepartureForm();
    //     $model->host_user_id =  $safari_operator->id;
    //     $model->type = 2;

    //     if ($safari_operator->category_id == 1) {
    //         $model->host_type = 3;
    //     } elseif ($safari_operator->category_id == 2) {
    //         $model->host_type = 2;
    //     } else {
    //         $model->host_type = $this->userinfo->account_type;
    //     }

    //     $model->status = ShareSafari::STATUS_SUSPEND;
    //     $model->rand_text = substr(sha1(mt_rand()), 17, 6) . '-' . $model->host_user_id . time();
    //     $model->attributes = $this->request;
    //     if ($model->validate()) {
    //         $model->initializeForm();
    //         if ($model->shared_safari_departure_model->save()) {
    //             $parks = $model->park_list;
    //             if ($parks) {
    //                 foreach ($parks as $park) {
    //                     $park_model = new ShareSafariParklist();
    //                     $park_model->share_safari_id = $model->shared_safari_departure_model->id;
    //                     $park_model->park_id = $park;
    //                     $park_model->save(false);
    //                 }
    //             }

    //             $to_mail = Yii::$app->params['adminEmail'];
    //             $subject = 'New Fixed Departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
    //             $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_FIXEDDEPARTURE;
    //             $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
    //             $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'operator_name' => $safari_operator->business_name, 'shared_safari_url' => $shared_safari_url];
    //             $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //             if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
    //                 GeneralModel::sendmailfromlog($maillog_data['log_id']);
    //             }

    //             return Yii::$app->api->sendResponse($data = [$model->shared_safari_model->attributes], ['message' => "Shared safari created successfully"]);
    //         }
    //     }
    //     return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    // }
}
