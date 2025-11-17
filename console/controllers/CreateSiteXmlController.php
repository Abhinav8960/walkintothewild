<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\trierror\SitePages;
use common\models\GeneralModel;

class CreateSiteXmlController extends Controller
{
  public function actionIndex()
  {
    $start = microtime(true);

    //update home page url (basically remove double slash at the last of string)
    SitePages::updateAll(['url' => 'https://walkintothewild.in/'], ['url' => 'https://walkintothewild.in//']);

    $additional_sitemap = [];
    $records = SitePages::find()->select('category')->distinct('category')->where(['status' => true])->asArray()->all();
    if (count($records) > 0) {
      foreach ($records as $rec) {
        $all_urls = SitePages::find()->where(['status' => true])->andWhere(['category' => $rec['category']])->asArray()->all();
        if (count($all_urls) > 0) {
          $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
          $xml_content .= "<sitemapindex xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

          foreach ($all_urls as $page) {
            $xml_content .= "<sitemap>";
            $xml_content .= "<loc>" . $base_url = Yii::$app->params['frontend_url'] . $page['url'] . "</loc>";
            $xml_content .= "<lastmod>" . date('Y-m-d', strtotime($page['last_update_at'])) . "</lastmod>";
            $xml_content .= "</sitemap>";
          }
          $xml_content .= "</sitemapindex>";

          $cat_name = strtolower(str_replace(" ", "_", $rec['category']));
          $myFile = Yii::$app->params['datapath'] . "/" . "sitemap/" . $cat_name . ".xml";
          $additional_sitemap[] = Yii::$app->params['frontend_url'] . "storage/sitemap/" . $cat_name . ".xml";
          $fh = fopen($myFile, 'w') or die("can't open file");
          fwrite($fh, $xml_content);
          fclose($fh);
        }
      }
    }

    if (count($additional_sitemap) > 0) {
      $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
      $xml_content .= "<sitemapindex xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
      foreach ($additional_sitemap as $sitemap) {
        if (!empty($sitemap)) {
          $xml_content .= "<sitemap>";
          $xml_content .= "<loc>" . $sitemap . "</loc>";
          $xml_content .= "<lastmod>" . date('Y-m-d') . "</lastmod>";
          $xml_content .= "</sitemap>";
        }
      }
      $xml_content .= "</sitemapindex>";

      $myFile = Yii::$app->params['datapath'] . "/" . "sitemap/" . "sitemap.xml";
      $fh = fopen($myFile, 'w') or die("can't open file");
      fwrite($fh, $xml_content);
      fclose($fh);
      //chmod($fh, 0777);
    }

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionDump_untraced_request()
  {
    $start = microtime(true);

    $connection = \Yii::$app->getDb();
    $command = $connection->createCommand("SELECT DISTINCT(request_full_url) FROM site_frontend_request WHERE is_reqeust_trace = 0 and request_url NOT IN (SELECT DISTINCT(url) AS url FROM site_pages where status = 1) AND request_url NOT IN (SELECT DISTINCT(url) AS url FROM site_untraced_request)");
    $un_traced_record = $command->queryAll();
    if (count($un_traced_record) > 0) {
      $temp_array = [];
      foreach ($un_traced_record as $record) {
        $temp_array[] = [
          'url' => $record['request_full_url']
        ];
      }

      //insert all records at once
      \Yii::$app->db->createCommand()->batchInsert('site_untraced_request', ['url'], $temp_array)->execute();
    }

    $command = \Yii::$app->db->createCommand(
      'UPDATE site_frontend_request SET is_reqeust_trace = 1 WHERE id <> 0'
    );
    $command->execute();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }
}
