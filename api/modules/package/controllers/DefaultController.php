<?php

namespace api\modules\package\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\package\Package;
use api\models\package\PackageSearch;
use frontend\models\PackageCommentForm;
use frontend\models\PackageReplyForm;
use yii\filters\AccessControl;

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
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $searchModel->custom_sort_by = 5;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Packages");
    }


    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        $searchModel = new PackageSearch();
        $searchModel->id = $package->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }

   

    public function actionComment($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }
        $model = new PackageCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($package)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }

        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Shared Safari Not Found!!!"]);
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($package)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }


        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    // public function actionFlag($slug, $park_id, $share_safari_comment_id)
    // {
    //     $share_safari = ShareSafari::find()->where(['slug' => $slug])->one();
    //     if (!$share_safari) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Share Safari Not found!"]);
    //     }

    //     $comments = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->limit(1)->one();

    //     $model = new ShareSafariCommentReportForm();
    //     $model->share_safari_id = $share_safari->id;
    //     $model->park_id = $park_id;
    //     $model->share_safari_comment_id = $share_safari_comment_id;

    //     $model->attributes = $this->request;
    //     if ($model->validate()) {
    //         $model->initializeForm();
    //         if ($model->flag_model->save(false)) {
    //             $comments->flaged = 1;
    //             $comments->save(false);
    //             /*Send Email*/
    //             $to_mail = Yii::$app->params['adminEmail'];
    //             $subject = 'Flag Raised | Shared Safari : ' . substr($share_safari->share_safari_title, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
    //             $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
    //             $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset(Yii::$app->user->identity) ? Yii::$app->user->identity->name : ''];
    //             $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //             if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
    //                 GeneralModel::sendmailfromlog($maillog_data['log_id']);
    //             }

    //             return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reported successfully!"]);
    //         }
    //     }
    // }
}
