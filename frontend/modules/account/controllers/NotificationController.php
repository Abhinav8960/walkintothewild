<?php

namespace frontend\modules\account\controllers;

use Yii;
use common\models\notification\FrontendNotification;
use common\models\notification\FrontendNotificationSearch;

/**
 * Notification controller for the `account` module
 */
class NotificationController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FrontendNotificationSearch();
        $searchModel->status = 1;
        $searchModel->user_id = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        FrontendNotification::updateAll(['is_seen' => 1, 'seen_datetime' => date('Y-m-d H:i:s')], [
            'user_id' => Yii::$app->user->identity->id,
            'status' => 1,
            'is_seen' => 0
        ]);


        return $this->render(
            'index',
            [
                'notifications' => $dataProvider->models,
                'dataProvider' => $dataProvider
            ]
        );
    }


    /**
     * View and Redirect to actual path
     *
     * @param [type] $id
     * @return void
     */
    public function actionView($id)
    {
        $notice  = FrontendNotification::find()->where(['id' => $id])->one();

        if ($notice) {
            if (!$notice->is_seen) {
                $notice->is_seen = 1;
                $notice->seen_datetime = date('Y-m-d H:i:s');
            }

            if (!$notice->is_read) {
                $notice->is_read = 1;
                $notice->read_datetime = date('Y-m-d H:i:s');
            }
            $notice->save(false);

            if ($notice->notification_url != '') {
                return $this->redirect($notice->notification_url);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}
