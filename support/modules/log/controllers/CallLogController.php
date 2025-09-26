<?php

namespace support\modules\log\controllers;

use api\models\chat\Chat;
use common\models\CallLogSearch;
use common\models\firebasenotification\FirebaseNotificationLogSearch;
use common\models\leads\Lead;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\User;
use common\models\UserFollow;
use yii\web\Controller;

/**
 * NotificationLogController.
 */
class CallLogController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CallLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function  actionUserProfile($user_id, $chat_id,$partner_id)
    {
        $user = User::find()->where(['id' => $user_id])->one();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UserFollow::find()->joinWith('user')->where(['follow_user_id' => $user->id])->andwhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]),
            'pagination' => ['pageSize' => 30]
        ]);

        $following_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UserFollow::find()->joinWith('user')->where(['user_id' => $user->id])->andwhere(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1]),
            'pagination' => ['pageSize' => 30]
        ]);

        $safari_operator_model = SafariOperator::find()->where(['id' => $partner_id])->limit(1)->one();
        $chat = Chat::find()->where(['id' => $chat_id])->andwhere(['or', ['user_id' => $safari_operator_model->user_id], ['recipient_user_id' => $safari_operator_model->user_id]])->andWhere(['chat_type' => 2])->orderby(['last_message_at' => SORT_DESC])->limit(1)->one();

        return $this->render('_user_profile', [
            'user' => $user,
            'dataProvider' => $dataProvider,
            'following_dataProvider' => $following_dataProvider,
            'chat' => $chat,
            'safari_operator_model' => $safari_operator_model,
        ]);
    }
}
