<?php

namespace api\modules\account\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\account\form\SafaritourRegistrationForm;
use api\models\operator\SafariOperator;
use api\models\operator\SafariOperatorRequestActivities;
use api\models\operator\SafariOperatorRequestPark;
use api\models\package\Package;
use api\models\package\PackageVersionSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use api\models\User;
use api\models\UserWishlist;
use common\models\GeneralModel;
use common\models\MailLog;
use frontend\models\profile\PrivacyForm;
use frontend\models\profile\UserForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Default controller for the `account` module
 */
class DefaultController extends RestController
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'profile-photo', 'cover-photo', 'privacy', 'dropdownoptions', 'wishlist-package', 'wishlist-shared-safari','profile-delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'profile-photo', 'cover-photo', 'privacy', 'dropdownoptions', 'wishlist-package', 'wishlist-shared-safari','profile-delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [

                    'index' => ['POST'],
                    'profile-photo' => ['POST'],
                    'cover-photo' => ['POST'],
                    'privacy' => ['POST'],
                    'dropdownoptions' => ['GET'],
                    'wishlist-package' => ['GET'],
                    'wishlist-shared-safari' => ['GET'],
                    'profile-delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
        }
        $model = new UserForm($user_model);

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Information Updated Successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Information not Updated Successfully"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionProfilePhoto()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
        }

        $model = new UserForm($user_model);
        $model->attributes = $this->request;
        $model->profile_image = UploadedFile::getInstanceByName('profile_image');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Profile Photo Update Successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Profile Photo not Update Successfully"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionCoverPhoto()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
        }
        $model = new UserForm($user_model);
        $model->attributes = $this->request;
        $model->cover_image = UploadedFile::getInstanceByName('cover_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Cover Photo Update Successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Cover Photo not Update Successfully"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionRegistrationOperator()
    {
        if ($this->userinfo) {
            $registration_model = SafariOperator::findOne(['user_id' => $this->userinfoId]);
            if ($registration_model) {
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
            }
        }

        $registration_model = new SafaritourRegistrationForm();
        $registration_model->status = SafariOperator::STATUS_ACTIVE;
        $registration_model->user_id = $this->userinfoId;

        // $registration_model->action_url = Url::toRoute(['/account/default/registration-operator']);
        // $registration_model->action_validate_url = Url::toRoute(['/account/default/validate']);

        $registration_model->referrer_url = \Yii::$app->request->referrer;

        $registration_model->attributes = $this->request;
        $registration_model->logo = UploadedFile::getInstanceByName('logo');

        if ($registration_model->budget_segment) {
            $registration_model->budget_segment = explode(',', $registration_model->budget_segment);
        }
        if ($registration_model->offers_other_wildlifeactivities) {
            $registration_model->offers_other_wildlifeactivities = explode(',', $registration_model->offers_other_wildlifeactivities);
        }
        if ($registration_model->park_id) {
            $registration_model->park_id = explode(',', $registration_model->park_id);
        }

        if ($registration_model->validate()) {
            $registration_model->initializeForm();
            if ($registration_model->safarioperator_request_model->save(false)) {
                $registration_model->uploadFile();
                $parks = $registration_model->park_id;

                if ($parks) {
                    foreach ($parks as $park) {
                        $safarioperatorrequestpark = new SafariOperatorRequestPark();
                        $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
                        $safarioperatorrequestpark->park_id = $park;
                        $safarioperatorrequestpark->save(false);
                    }
                }


                $activities = $registration_model->offers_other_wildlifeactivities;
                if ($activities) {
                    foreach ($activities as $activity) {
                        $safarioperatorrequestpark = new SafariOperatorRequestActivities();
                        $safarioperatorrequestpark->safari_operator_request_id = $registration_model->safarioperator_request_model->id;
                        $safarioperatorrequestpark->wildlife_activity_id = $activity;
                        $safarioperatorrequestpark->save(false);
                    }
                }

                $registration_model->safarioperator_request_model->is_approved = 1;
                if ($registration_model->safarioperator_request_model->save(false)) {
                    $safari_operator = $registration_model->safarioperator_request_model->safariapproved($registration_model->safarioperator_request_model);
                    if ($safari_operator) {
                        $user = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
                        $user->account_type = $registration_model->account_type;
                        $user->save(false);

                        /*Operator Register comment due to url*/
                        // $to_mail = Yii::$app->params['adminEmail'];
                        // $subject = 'New Operator Register | ' . substr($safari_operator->business_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_OPERATOR_CREATED;
                        // $operator_url = Yii::$app->urlManager->createAbsoluteUrl(['/operator/default/sharedsafari', 'slug' => $safari_operator->slug]);
                        // $req = ['safari_operator' => $safari_operator->attributes, 'operator_url' => $operator_url];
                        // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                        //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        // }
                        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Bussiness Registered Successfully"]);
                    }
                }
            }
        }
    }


    public function actionPrivacy()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
        }
        $model = new PrivacyForm($user_model);

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Privacy Updated Successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Privacy not Updated Successfully"]);
        }
        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionDropdownoptions()
    {
        $return = [
            '1' => 'Public',
            '2' => 'Only me',
            '3' => 'My Follower',
        ];
        return $return;
    }


    // public function actionBlockedMember()
    // {
    //     return $this->render('index', [
    //         'model' => BlockedModel::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : NULL, 'status' => 1])->all(),
    //     ]);
    // }


    public function actionWishlistPackage()
    {

        $wishlist_items = UserWishlist::find()->select('item_id')->where(['item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1, 'user_id' => $this->userinfo ? $this->userinfoId : null])->all();
        $packageIds =  array_column($wishlist_items, 'item_id');

        $dataProvider = new ActiveDataProvider([
            'query' => Package::find()->where(['uuid' => $packageIds, 'status'=> Package::APPROVED_AND_LIVE_STATUS]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "packages");
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionWishlistSharedSafari()
    {

        $wishlist_items = UserWishlist::find()->where(['item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1, 'user_id' => $this->userinfo ? $this->userinfoId : null])->all();

        $saafariIds =  array_column($wishlist_items, 'item_id');

        $dataProvider = new ActiveDataProvider([
            'query' => ShareSafari::find()->where(['id' => $saafariIds]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "shared_safari");
    }

    public function actionProfileDelete()
    {
        $user_model = $this->userinfo;
        if ($user_model && $user_model->partner) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Sent to operator Manage"]);
        }
        $model = User::find()->where(['id' => $user_model->id])->limit(1)->one();
        $model->status = User::STATUS_DELETED;

        if ($model->save(false)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Profile Deleted Successfully!!!"]);
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Profile Not Deleted!!!"]);
    }
}
