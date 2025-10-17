<?php

namespace api\modules\profile\controllers;

use Yii;
use api\behaviours\Verbcheck;
use yii\filters\AccessControl;
use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\feeds\Feeds;
use api\models\feeds\FeedsSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariIntrested;
use api\models\User;
use api\models\UserFollow;
use common\Helper\FirebaseNotificationHelper;
use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Default controller
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
                'exclude' => ['index', 'organizedby', 'joinedby', 'useractivity', 'followers-list', 'followings-list'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['follow', 'unfollow'],
                'rules' => [
                    [
                        'actions' => ['follow', 'unfollow'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'follow' => ['POST'],
                    'unfollow' => ['POST'],
                    'organizedby' => ['GET'],
                    'useractivity' => ['GET'],
                    'followers-list' => ['GET'],
                    'followings-list' => ['GET'],
                ],
            ],
        ];
    }


    // public function actionIndex($user_handle)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
    //     $user = $this->findUser($user_handle);
    //     if ($user->partner) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
    //     }

    //     return Yii::$app->api->sendResponse($data = $user);
    // }

    public function actionIndex($user_handle)
    {
        $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        return Yii::$app->api->sendResponse($data =  $user->toArray());
    }

    public function actionOrganizedby($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($user->id == $this->userinfoId) {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT, ShareSafari::STATUS_SUSPEND]])->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($organized_by)]);
        } else {
            $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'share_safari.start_date', date("Y-m-d")])->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($organized_by)]);
        }
    }

    public function actionJoinedby($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($user->id == $this->userinfoId) {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id, 'status' => ShareSafariIntrested::STATUS_ACTIVE])->all();
            $safariIds = array_map(function ($item) {
                return $item->share_safari_id;
            }, $joined_by);
            $shared_safari = ShareSafari::find()
                ->where(['id' => $safariIds])
                ->andWhere(['>=', 'start_date', date("Y-m-d")])
                ->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($shared_safari)]);
        } else {
            $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id, 'status' => ShareSafariIntrested::STATUS_ACTIVE])->all();
            $safariIds = array_map(function ($item) {
                return $item->share_safari_id;
            }, $joined_by);
            $shared_safari = ShareSafari::find()
                ->where(['id' => $safariIds])
                ->andWhere(['>=', 'start_date', date("Y-m-d")])
                ->all();
            return Yii::$app->api->sendResponse($data = ['share_safari' => ArrayHelper::toArray($shared_safari)]);
        }
    }

    public function actionFollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId == $user->id) {
                $message = Yii::$app->api->messageManager->getMessage('common.follow_restricted', ['{var}' => 'yourself']);
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
            $follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $user->id])->limit(1)->one();
            if (!$follower) {
                $follower = new UserFollow();
            }
            $follower->user_id = $this->userinfoId;
            $follower->follow_user_id = $user->id;
            $follower->status = 1;
            $follower->save(false);

            // $to_mail = $user->username;
            // $following_name = $this->userinfo->name;
            // $subject = 'New Follower';
            // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_FOLLOWER_BY_ANY_USER;
            // $follower_url = Yii::$app->urlManager->createAbsoluteUrl(['/profile/default/follower', 'user_handle' => $user->user_handle]);
            // $req = ['following_name' => $following_name, 'follower_url' => $follower_url];
            // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
            //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
            // }
            // FrontendNotificationHelper::userNewFollower($user, $this->userinfo);
            // FirebaseNotificationHelper::profilefollowing($user, $this->userinfo);
            $message = Yii::$app->api->messageManager->getMessage('common.follow_success');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.follow_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function actionUnfollow($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
        if ($this->userinfo) {
            $my_follower = UserFollow::find()->where(['user_id' => $this->userinfoId, 'follow_user_id' => $user->id])->limit(1)->one();
            if ($my_follower) {
                $my_follower->user_id = $this->userinfoId;
                $my_follower->follow_user_id = $user->id;
                $my_follower->status = 0;
                if ($my_follower->save(false)) {
                    $message = Yii::$app->api->messageManager->getMessage('common.unfollow_success');
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.unfollow_failed');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_logged_in');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
    }

    public function findUserbyHandle($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->andWhere(['blocked_at' => null, 'status' => User::STATUS_ACTIVE])->limit(1)->one()) {
            return $user;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.user_not_accessible');
        throw new ForbiddenHttpException($message);
    }

    public function findUser($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->limit(1)->one()) {
            return $user;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        throw new ForbiddenHttpException($message);
    }

    public function actionUseractivity($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        // if ($user->partner) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
        // }
        if ($user) {
            $searchModel = new FeedsSearch();
            $searchModel->created_by = $user->id;
            $searchModel->status = Feeds::STATUS_ACTIVE;
            return $this->dataProviderSender($searchModel, $rootIndexName = "user_activity");
        }
    }


    // public function actionFollowersList($user_handle)
    // {
    //     $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;
    //     $user = $this->findUserbyHandle($user_handle);
    //     if ($user->partner) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
    //     }

    //     $followers_list = UserFollow::find()->where(['follow_user_id' => $user->id])->joinWith('user')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->all();

    //     $ids = array_column($followers_list, 'id');

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => User::find()->where(['id' => $ids]),
    //         // 'pagination' => false,
    //     ]);

    //     return $this->querySender($dataProvider, $rootIndexName = "user_follower_list");
    // }

    public function actionFollowingsList($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        $following_list = UserFollow::find()->where(['user_id' => $user->id])->joinWith('follower')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);

        // $ids = array_column($followers_list, 'follow_user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $following_list,
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "user_follower_list");
    }

    public function actionFollowersList($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->partner) {
            $message = Yii::$app->api->messageManager->getMessage('common.sent_to_operator', ['{var}' => 'profile']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        $followers_list = UserFollow::find()->where(['follow_user_id' => $user->id])->joinWith('user')->andWhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]);

        // $ids = array_column($following_list, 'user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $followers_list,
        ]);

        return $this->querySender($dataProvider, $rootIndexName = "user_following_list");
    }
}
