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
        $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI]);
        $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id])->joinwith(['sharesafari'])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE]);

        if (Yii::$app->user->identity) {
            if ($user->id == Yii::$app->user->identity->id) {
                $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_SUSPEND, ShareSafari::STATUS_FULL_SEAT]]);
                $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE]);
            } else {
                $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'start_date', date("Y-m-d")]);
                $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id])->joinwith(['sharesafari'])->andWhere(['>=', 'start_date', date("Y-m-d")])->andWhere(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE, 'share_safari.status' => ShareSafari::STATUS_ACTIVE]);
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
