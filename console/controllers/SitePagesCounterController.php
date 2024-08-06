<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\trierror\SitePages;
use common\models\GeneralModel;


/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class SitePagesCounterController extends Controller
{
  public function actionIndex()
  {
    $start = microtime(true);

    $records = SitePages::find()->where(['status' => true])->all();
    if (count($records) > 0) {
      //start page counter
    }

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }
}
