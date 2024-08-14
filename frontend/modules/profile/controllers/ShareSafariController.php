<?php

namespace frontend\modules\profile\controllers;

use Yii;
use common\models\User;
use common\models\sharesafari\ShareSafari;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafariIntrested;


/**
 * ShareSafariController.
 */
class ShareSafariController extends FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id]);
        $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id]);

        if (Yii::$app->user->identity) {
            if ($user->id == Yii::$app->user->identity->id) {
                $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id]);
                $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id]);
            } else {
                $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id])->andWhere(['>=', 'start_date', date("Y-m-d")]);
                $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")]);
            }
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $organized_by,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => ['defaultOrder' => [
                'id' => SORT_DESC
            ]]
        ]);

        $joindedProvider = new \yii\data\ActiveDataProvider([
            'query' => $joined_by,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => ['defaultOrder' => [
                'id' => SORT_DESC
            ]]
        ]);
        return $this->render(
            'index',
            [
                'user' => $user,
                'dataProvider' => $dataProvider,
                'joindedProvider' => $joindedProvider,
            ]
        );
    }
}
