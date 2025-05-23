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

 
    public function actionPackageFeedRemoval()
    {
        $package_model = Package::find()->where(['owned_by_id' => 23])->all();
        foreach($package_model as $package)
        {
            $package->status = 0;
            $package->save(false);
            $feed_model = Feeds::find()->where(['collection'=>2,'collection_id'=>$package->id])->limit(1)->one();
            if($feed_model)
            {
                $feed_model->status = 0;
                $feed_model->save(false);
            }
        }
        echo "Done";
    }
}
