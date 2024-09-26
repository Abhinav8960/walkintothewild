<?php

namespace frontend\modules\manage\controllers;

use common\models\User;
use frontend\controllers\FrontendBaseController;
use common\models\UserFollow;

/**
 * Default controller for the `manage` module
 */
class FollowerController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $follow_query = $safari_operator->getFollowerlist()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE]);
        $follow_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $follow_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'follow_dataProvider' => $follow_dataProvider
        ]);
    }
}
