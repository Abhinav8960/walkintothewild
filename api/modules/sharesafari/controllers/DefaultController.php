<?php

namespace api\modules\sharesafari\controllers;

use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use common\models\GeneralModel;
use common\models\MailLog;
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
        if ($login_user = Yii::$app->user->identity) {
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
                return Yii::$app->api->sendResponse($data = [$model->shared_safari_model->attributes], ['message' => "Shared safari created successfully"]);
            }
        }

        Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }
}
