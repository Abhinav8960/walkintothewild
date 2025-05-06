<?php

namespace console\controllers;

use common\models\feeds\Feeds;
use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use yii\console\Controller;



/**
 * FeedDateTimeController
 */
class FeedDateTimeController extends Controller
{
    public function actionShareSafari()
    {
        $feed_model = Feeds::find()->where(['collection' => 1])->all();
        foreach ($feed_model as $feed) {
            $share_safari_model = ShareSafari::find()->where(['id' => $feed->collection_id])->limit(1)->one();
            if ($share_safari_model) {
                if ($share_safari_model->start_date != null) {
                    $feed->date_time = date('Y-m-d H:i:s', strtotime($share_safari_model->start_date));
                    $feed->save(false);
                }
            }
        }

        echo "Successfully start date save!!!";
    }

    public function actionPackage()
    {
        $feed_model = Feeds::find()->where(['collection' => 2])->all();
        foreach ($feed_model as $feed) {
            $package_model = Package::find()->where(['id' => $feed->collection_id])->limit(1)->one();
            if ($package_model) {
                if ($package_model->start_date != null) {
                    $feed->date_time = date('Y-m-d H:i:s', strtotime($package_model->start_date));
                    $feed->save(false);
                }
            }
        }

        echo "Successfully start date save!!!";
    }

    public function actionDisable()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $feedModels = Feeds::find()
            ->where(['collection' => 1])
            ->andWhere(['<=', 'date_time', $currentDateTime])
            ->all();

        foreach ($feedModels as $feed) {
            $feed->status = 0;
            $feed->save(false);
        }

        echo "Successfully updated feeds based on start date!";
    }
}
