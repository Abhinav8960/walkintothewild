<?php

namespace console\controllers;

use common\models\feeds\Feeds;
use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use common\models\UserPosts;
use yii\console\Controller;



/**
 * DataCopy controller
 */
class DataCopyController extends Controller
{
    public function actionSafari()
    {
        $dsafaris = ShareSafari::find()->all();
        foreach ($dsafaris as $dsafari) {
            $model = Feeds::find()->where(['collection' => Feeds::MODEL_SHARESFARI, 'collection_id' => $dsafari->id])->one();
            if (empty($model)) {
                $model = new Feeds();
            }
            $model->objective = 'ShareSafari';
            $model->collection = Feeds::MODEL_SHARESFARI;
            $model->collection_id = $dsafari->id;
            $model->created_at = $dsafari->created_at;
            $model->updated_at = $dsafari->updated_at;
            $model->created_by = $dsafari->created_by;
            $model->updated_by = $dsafari->updated_by;
            if ($dsafari->status == NULL) {
                $model->status = Feeds::STATUS_ACTIVE;
            } else {
                $model->status = $dsafari->status;
            }
            $model->save(false);
        }
        return true;
    }

    public function actionPackage()
    {
        $dpackages = Package::find()->all();
        foreach ($dpackages as $dpackage) {
            $model = Feeds::find()->where(['collection' => Feeds::MODEL_PACKAGE, 'collection_id' => $dpackage->id])->one();
            if (empty($model)) {
                $model = new Feeds();
            }
            $model->objective = 'Package';
            $model->collection = Feeds::MODEL_PACKAGE;
            $model->collection_id = $dpackage->id;
            $model->created_at = $dpackage->created_at;
            $model->updated_at = $dpackage->updated_at;
            $model->created_by = $dpackage->created_by;
            $model->updated_by = $dpackage->updated_by;
            if ($dpackage->status == NULL) {
                $model->status = Feeds::STATUS_ACTIVE;
            } else {
                $model->status = $dpackage->status;
            }
            $model->save(false);
        }
        return true;
    }

    public function actionPost()
    {
        $dposts = UserPosts::find()->all();
        foreach ($dposts as $dpost) {
            $model = Feeds::find()->where(['collection' => Feeds::MODEL_POSTS, 'collection_id' => $dpost->id])->one();
            if (empty($model)) {
                $model = new Feeds();
            }
            $model->objective = 'Posts';
            $model->collection = Feeds::MODEL_POSTS;
            $model->collection_id = $dpost->id;
            $model->created_at = $dpost->created_at;
            $model->updated_at = $dpost->updated_at;
            $model->created_by = $dpost->created_by;
            $model->updated_by = $dpost->updated_by;
            if ($dpost->status == NULL) {
                $model->status = Feeds::STATUS_ACTIVE;
            } else {
                $model->status = $dpost->status;
            }
            $model->save(false);
        }
        return true;
    }

    public function actionDelete()
    {
        $models = Feeds::find()->where(['collection' => "3"])->all();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    // public function actionRun()
    // { 
    //      for ($i = 0; $i < 10; $i++) {
    //     $command = 'php '. $i . ' > /dev/null 2>&1 & echo $!';
    //     $output = [];
    //     // $pid = getmygid();
    //     exec($command, $output);
    //     echo "Number"." ".$i." "."with PID: " .$output[0]. PHP_EOL; //$output[0] 
    //     sleep(1);
    // }
    //    return "";
    // }
}
