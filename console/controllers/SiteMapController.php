<?php

namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
use common\models\GeneralModel;

class SiteMapController extends Controller
{
  public function behaviors()
  {
    return array_merge(
      parent::behaviors(),
      [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            'delete' => ['POST'],
          ],
        ],
      ]
    );
  }

  public function actionIndex()
  {
    $script_start1 = microtime(true);
    echo "Script 1 start time: " . $script_start1 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('generate-site-pages/site-pages1'); //run the Action
    $script_end1 = microtime(true);
    $executionTime = $script_end1 - $script_start1;
    echo "Script 1 end time: " . $script_end1 . " seconds";
    echo "<pre>";
    echo "Script 1 execution time: " . $executionTime . " seconds";
    echo "<pre>";




    $script_start2 = microtime(true);
    echo "Script 2 start time: " . $script_start2 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('generate-site-pages/site-pages2'); //run the Action
    $script_end2 = microtime(true);
    $executionTime = $script_end2 - $script_start2;
    echo "Script 2 end time: " . $script_end2 . " seconds";
    echo "<pre>";
    echo "Script 2 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start3 = microtime(true);
    echo "<pre>";
    echo "Script 3 start time: " . $script_start3 . " seconds";
    \Yii::$app->runAction('generate-site-pages/site-pages3'); //run the Action to get join/unjoin
    $script_end3 = microtime(true);
    $executionTime = $script_end3 - $script_start3;
    echo "Script 3 end time: " . $script_end3 . " seconds";
    echo "<pre>";
    echo "Script 3 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start4 = microtime(true);
    echo "<pre>";
    echo "Script 4 start time: " . $script_start4 . " seconds";
    \Yii::$app->runAction('generate-site-pages/site-pages4'); //run the Action to get_monthly_package_site_pages(),get_monthly_shared_safari_site_pages(),get_operator_tabs_site_pages();
    $script_end4 = microtime(true);
    $executionTime = $script_end4 - $script_start4;
    echo "Script 4 end time: " . $script_end4 . " seconds";
    echo "<pre>";
    echo "Script 4 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start5 = microtime(true);
    echo "Script 5 start time: " . $script_start5 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('generate-site-pages/site-pages1'); //run the Action get park,share safari,package
    $script_end5 = microtime(true);
    $executionTime = $script_end5 - $script_start5;
    echo "Script 5 end time: " . $script_end5 . " seconds";
    echo "<pre>";
    echo "Script 5 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start6 = microtime(true);
    echo "<pre>";
    echo "Script 6 start time: " . $script_start6 . " seconds";
    \Yii::$app->runAction('generate-site-pages/site-pages6'); //run the Action User Follow
    $script_end6 = microtime(true);
    $executionTime = $script_end6 - $script_start6;
    echo "Script 6 end time: " . $script_end6 . " seconds";
    echo "<pre>";
    echo "Script 6 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start7 = microtime(true);
    echo "Script 7 start time: " . $script_start7 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('generate-site-pages/site-page7'); //run the Action Operator Follow
    $script_end7 = microtime(true);
    $executionTime = $script_end7 - $script_start7;
    echo "Script 7 end time: " . $script_end7 . " seconds";
    echo "<pre>";
    echo "Script 7 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start8 = microtime(true);
    echo "Script 8 start time: " . $script_start8 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('generate-site-pages/site-page8'); //run the Action Whishlist
    $script_end8 = microtime(true);
    $executionTime = $script_end8 - $script_start8;
    echo "Script 8 end time: " . $script_end8 . " seconds";
    echo "<pre>";
    echo "Script 8 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    // $script_start9 = microtime(true);
    // echo "Script 9 start time: " . $script_start9 . " seconds";
    // \Yii::$app->runAction('generate-site-pages/site-page9'); //run the Action
    // $script_end9 = microtime(true);
    // $executionTime = $script_end9 - $script_start9;
    // echo "Script 9 end time: " . $script_end9 . " seconds";
    // echo "Script 9 execution time: " . $executionTime . " seconds";

    $script_start10 = microtime(true);
    echo "Script 10 start time: " . $script_start10 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('create-site-xml/site-pages-counter'); //run the Action Create true page counter
    $script_end10 = microtime(true);
    $executionTime = $script_end10 - $script_start10;
    echo "Script 10 end time: " . $script_end10 . " seconds";
    echo "<pre>";
    echo "Script 10 execution time: " . $executionTime . " seconds";
    echo "<pre>";



    $script_start11 = microtime(true);
    echo "Script 11 start time: " . $script_start11 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('create-site-xml/non-site-pages-counter'); //run the Action Create false page counter
    $script_end11 = microtime(true);
    $executionTime = $script_end11 - $script_start11;
    echo "Script 11 end time: " . $script_end11 . " seconds";
    echo "<pre>";
    echo "Script 11 execution time: " . $executionTime . " seconds";
    echo "<pre>";




    $script_start12 = microtime(true);
    echo "Script 12 start time: " . $script_start12 . " seconds";
    echo "<pre>";
    \Yii::$app->runAction('create-site-xml/index'); //run the Action Create XML
    $script_end12 = microtime(true);
    $executionTime = $script_end12 - $script_start12;
    echo "Script 12 end time: " . $script_end12 . " seconds";
    echo "<pre>";
    echo "Script 12 execution time: " . $executionTime . " seconds";
    echo "<pre>";
  }
}
