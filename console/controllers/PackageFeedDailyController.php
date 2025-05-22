<?php

namespace console\controllers;

use common\models\feeds\Feeds;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use Yii;
use yii\console\Controller;



/**
 * PackageFeedDailyController
 */
class PackageFeedDailyController extends Controller
{


    public function actionIndex()
    {
        $feed_models = Feeds::find()->where(['collection' => 2])->all();

        foreach ($feed_models as $feed) {
            $package_model = Package::find()->where(['id' => $feed->collection_id])->limit(1)->one();
            if ($package_model) {
                $safari_operator_model = SafariOperator::find()->where(['id' => $package_model->owned_by_id])->limit(1)->one();
                if ($safari_operator_model->status == 0) {
                    $feed->status = 0;
                    $feed->save(false);
                }
            }
        }

        echo "Package Successfully remove because operator is inactive";
    }
}
