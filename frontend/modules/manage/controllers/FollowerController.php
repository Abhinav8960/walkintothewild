<?php

namespace frontend\modules\manage\controllers;

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
        $follow_query = UserFollow::find()->where([
            'follow_user_id' => $safari_operator->user_id,
            'status' => 1
        ]);
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
