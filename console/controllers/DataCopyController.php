<?php

namespace console\controllers;

use common\models\chat\ChatMessage;
use common\models\feeds\Feeds;
use common\models\package\PackageVersion;
use common\models\sharesafari\ShareSafari;
use common\models\UserPosts;
use console\models\operator\SafariOperator;
use console\models\operator\SafariOperatorPark;
use yii\console\Controller;



/**
 * DataCopy controller
 */
class DataCopyController extends Controller
{

    public function actionPackageTableCopy()
    {
        $tables = [
            'package',
            'package_comment',
            'package_comment_report',
            'package_day',
            'package_enquiry',
            'package_faq',
            'package_feature',
            'package_gallery',
            'package_included',
            'package_quote',
            'package_safari_park'
        ];

        $db = \Yii::$app->db;

        foreach ($tables as $table) {
            $newTable = 'pp_' . $table;

            $db->createCommand("DROP TABLE IF EXISTS {$newTable}")->execute();

            $createTableSql = $db->createCommand("SHOW CREATE TABLE {$table}")->queryOne();
            if ($createTableSql && isset($createTableSql['Create Table'])) {
                $createTableStatement = $createTableSql['Create Table'];

                $createTableStatement = str_replace("`{$table}`", "`{$newTable}`", $createTableStatement);

                $db->createCommand($createTableStatement)->execute();

                $db->createCommand("INSERT INTO {$newTable} SELECT * FROM {$table}")->execute();

                echo "Table {$table} copied to {$newTable} with structure and data\n";
            } else {
                echo "Failed to retrieve CREATE TABLE statement for {$table}\n";
            }
        }
    }


    public function actionSafari()
    {
        $dsafaris = ShareSafari::find()->all();
        foreach ($dsafaris as $dsafari) {
            $model = Feeds::find()->where(['collection' => Feeds::MODEL_SHARESFARI, 'collection_id' => $dsafari->id])->one();
            if (empty($model)) {
                $model = new Feeds();
            }
            $model->objective = 'share_safari';
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
        $dpackages = \common\models\package\Package::find()->where(['live_version' => 'v1', 'status' => 1])->all();
        foreach ($dpackages as $dpackage) {
            $model = Feeds::find()->where(['collection' => Feeds::MODEL_PACKAGE, 'collection_id' => $dpackage->id])->one();
            if (empty($model)) {
                $model = new Feeds();
            }
            $model->objective = 'package';
            $model->collection = Feeds::MODEL_PACKAGE;
            $model->collection_id = $dpackage->id;
            $model->created_at = $dpackage->created_at;
            $model->updated_at = $dpackage->updated_at;
            $model->created_by = $dpackage->created_by;
            $model->updated_by = $dpackage->updated_by;
            $model->status = Feeds::STATUS_ACTIVE;

            $model->save(false);
        }
        return true;
    }

    // public function actionPost()
    // {
    //     $dposts = UserPosts::find()->all();
    //     foreach ($dposts as $dpost) {
    //         $model = Feeds::find()->where(['collection' => Feeds::MODEL_POSTS, 'collection_id' => $dpost->id])->one();
    //         if (empty($model)) {
    //             $model = new Feeds();
    //         }
    //         $model->objective = 'user_posts';
    //         $model->collection = Feeds::MODEL_POSTS;
    //         $model->collection_id = $dpost->id;
    //         $model->created_at = $dpost->created_at;
    //         $model->updated_at = $dpost->updated_at;
    //         $model->created_by = $dpost->created_by;
    //         $model->updated_by = $dpost->updated_by;
    //         if ($dpost->status == NULL) {
    //             $model->status = Feeds::STATUS_ACTIVE;
    //         } else {
    //             $model->status = $dpost->status;
    //         }
    //         $model->save(false);
    //     }
    //     return true;
    // }

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

    public function actionCopyOperator()
    {
        $dpackages = SafariOperator::find()->all();
        foreach ($dpackages as $dpackage) {
            $sp = new \common\models\operator\SafariOperator();
            foreach ($dpackage->attributes as $key => $value) {
                $sp->$key = $value;
            }
            $sp->save(false);
        }
        $dpackages = SafariOperatorPark::find()->all();
        foreach ($dpackages as $dpackage) {
            $sp = new \common\models\operator\SafariOperatorPark();
            foreach ($dpackage->attributes as $key => $value) {
                $sp->$key = $value;
            }
            $sp->save(false);
        }
        echo "Data copied successfully";
    }

    public  function actionRemoveHtml()
    {

        $chatmessages = ChatMessage::find()->where(['<', 'id', 2300])->all();

        foreach ($chatmessages as $chatmessage) {
            $chatmessage->message = $this->removeBAndReplaceBr($chatmessage->message);
            $chatmessage->save(false);
        }
    }

    public function removeBAndReplaceBr($text)
    {
        // Remove <b> tags
        $text = preg_replace('/<b>(.*?)<\/b>/', '$1', $text);
        // Replace <br> tags with new lines
        $text = str_replace('<br>', "\n", $text);
        return $text;
    }
}
