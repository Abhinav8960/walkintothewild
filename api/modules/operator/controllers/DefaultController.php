<?php

namespace api\modules\operator\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorSearch;
use api\models\UserFollow;
use common\Helper\FrontendNotificationHelper;
use common\models\MailLog;
use frontend\models\OperatorQuoteForm;
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
                'only' => ['follow','unfollow'],
                'rules' => [
                    [
                        'actions' => ['follow','unfollow'],
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
                    'follow' => ['POST'],
                    'unfollow' => ['POST'],
                ],
            ],
        ];
    }

    public function actionView($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$operator) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
        }
        $searchModel = new SafariOperatorSearch();
        $searchModel->id = $operator->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
        // return $this->dataSender($operator, $rootIndexName = "Operator");
    }


    // public function actionQuotesrequest($slug)
    // {
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (!$operator) {
    //         return Yii::$app->api->sendResponse($data = [], ['message' => "Operator Not Found!!!"]);
    //     }
    //     $model = new OperatorQuoteForm();
    //     if ($this->userinfo) {
    //         $model->email = $this->userinfo->email;
    //         $model->full_name = $this->userinfo->name;
    //         $model->phone_no = $this->userinfo->mobile_no;
    //     }
    //     $model->attributes = $this->request;
    //     if ($model->validate()) {
    //         if ($operator_quote = $model->request($operator)) {
    //             // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
    //         }
    //         return Yii::$app->api->sendResponse($data = [$model->attributes], ['message' => 'Quote request sent!']);
    //     }
    // }


    public function actionFollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($operator) {
            if ($this->userinfo) {
                if ($this->userinfoId == $operator->user_id) {
                    return Yii::$app->api->sendResponse($data = [], ['message' => "You can't follow yourself!"]);
                }

                $follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $operator->user_id])->one();
                if (!$follower) {
                    $follower = new UserFollow();
                }

                $follower->user_id = $this->userinfoId;
                $follower->follow_user_id = $operator->user_id;
                $follower->status = 1;

                if ($follower->save(false)) {

                    // $to_mail = $operator->email;
                    // $subject = 'Follow Request';
                    // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_FOLLOW_REQUEST;
                    // $req = ['username' => $operator->business_name, 'name' => $this->userinfo->name, 'is_email_sending' => true];

                    // MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                    // FrontendNotificationHelper::operatorNewFollower($operator, $this->userinfo);
                    Yii::$app->session->setFlash('success', 'You are start following ' . $operator->business_name);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'You are start following']);
                } else {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'You can not follow this operator currently!']);
                }
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($operator->firstErrors, 400);
    }

    public function actionUnfollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($operator) {
            if ($this->userinfo) {
                $my_follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $operator->user_id])->one();

                $my_follower->user_id = $this->userinfoId;
                $my_follower->follow_user_id = $operator->user_id;
                $my_follower->status = 0;

                if ($my_follower->save(false)) {

                    $to_mail = $operator->email;
                    $subject = 'UnFollow Request';
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UNFOLLOW_REQUEST;
                    $req = ['username' => $operator->business_name, 'name' => $this->userinfo->name, 'is_email_sending' => true];

                    MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                    Yii::$app->session->setFlash('success', 'You unfollowed ' . $operator->business_name);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'You unfollowed']);
                } else {
                    Yii::$app->session->setFlash('success', 'You can not unfollow this operator currently!');
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'You cannot unfollowed']);
                }
            }
        }
        return  Yii::$app->api->sendFailedStringResponse($operator->firstErrors, 400);
    }
}
