<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\trierror\FrontendRequestLog;
use common\models\trierror\FrontendRequestLogSearch;
use common\models\cms\article\Article;
use common\models\cms\article\MasterArticleTopic;
use common\models\cms\article\MasterArticleTag;
//use common\models\park\Park;
use common\models\park\SafariPark;
use common\models\operator\SafariOperator;
use common\models\trierror\SitePages;
use common\models\cms\article\ArticleAuthor;
use common\models\sharesafari\ShareSafari;
use common\models\trierror\SiteUntracedRequest;
use common\models\package\Package;
use common\models\master\animal\MasterRareAnimal;
use Exception;

/**
 * Main Controller for YII Console
 */
class ContentCounterController extends Controller
{
  public function actionIndex()
  {
    $start = microtime(true);

    //make request log grouping
    $this->make_request_grouping();

    //move untraced request
    //$this->dump_untraced_request();

    //article counter
    $article_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($article_slugs)) {
      $non_count_slug = [];
      foreach ($article_slugs as $article) {
        $atricle_model = Article::find()->where(['slug' => $article['slug']])->one();
        if (!empty($atricle_model)) {
          $atricle_model->total_view += $article['pending_view'];
          if ($atricle_model->save()) {
            $non_count_slug[] = $article['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //topic counter
    $topic_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/topic'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($topic_slugs)) {
      $non_count_slug = [];
      foreach ($topic_slugs as $topic) {
        $topic_model = MasterArticleTopic::find()->where(['slug' => $topic['slug']])->one();
        if (!empty($topic_model)) {
          $topic_model->total_view += $topic['pending_view'];
          if ($topic_model->save()) {
            $non_count_slug[] = $topic['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //tag counter
    $tag_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/tag'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($tag_slugs)) {
      foreach ($tag_slugs as $tag) {
        $tag_model = MasterArticleTag::find()->where(['slug' => $tag['slug']])->one();
        if (!empty($tag_model)) {
          $tag_model->total_view += $tag['pending_view'];
          if ($tag_model->save()) {
            FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $tag['slug']]);
          }
        }
      }
    }

    //Park counter
    $park_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'park/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($park_slugs)) {
      $non_count_slug = [];
      foreach ($park_slugs as $park) {
        $park_model = SafariPark::find()->where(['slug' => $park['slug']])->one();
        if (!empty($park_model)) {
          $park_model->total_view += $park['pending_view'];
          if ($park_model->save()) {
            $non_count_slug[] = $park['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //safari operator counter
    $safari_operator_slug = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'operator/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($safari_operator_slug)) {
      $non_count_slug = [];
      foreach ($safari_operator_slug as $operator) {
        $operator_model = SafariOperator::find()->where(['slug' => $operator['slug']])->one();
        if (!empty($operator_model)) {
          $operator_model->total_view += $operator['pending_view'];
          if ($operator_model->save(false)) {
            $non_count_slug[] = $operator['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //author counter
    $author_slug = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/author'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($author_slug)) {
      $non_count_slug = [];
      foreach ($author_slug as $author) {
        $author_model = ArticleAuthor::find()->where(['slug' => $author['slug']])->one();
        if (!empty($author_model)) {
          $author_model->total_view += $author['pending_view'];
          if ($author_model->save()) {
            $non_count_slug[] = $author['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //shared safari counter
    $shared_safari = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'sharedsafari/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($shared_safari)) {
      $non_count_slug = [];
      foreach ($shared_safari as $safari) {
        $shared_safari_model = ShareSafari::find()->where(['slug' => $safari['slug']])->one();
        if (!empty($shared_safari_model)) {
          $shared_safari_model->total_view += $safari['pending_view'];
          if ($shared_safari_model->save()) {
            $non_count_slug[] = $safari['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //rared animal counter
    $rared_animals = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'park/default/rareanimal'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($rared_animals)) {
      $non_count_slug = [];
      foreach ($rared_animals as $animal) {
        $rared_animals_model = MasterRareAnimal::find()->where(['slug' => $animal['slug']])->one();
        if (!empty($rared_animals_model)) {
          $rared_animals_model->total_view += $animal['pending_view'];
          if ($rared_animals_model->save()) {
            $non_count_slug[] = $animal['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    //package counter
    $packages = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'package/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if (count($packages)) {
      $non_count_slug = [];
      foreach ($packages as $pckg) {
        $packages_model = Package::find()->where(['package_slug' => $pckg['slug']])->one();
        if (!empty($packages_model)) {
          $packages_model->total_view += $pckg['pending_view'];
          if ($packages_model->save()) {
            $non_count_slug[] = $pckg['slug'];
          }
        }
      }
      FrontendRequestLog::updateAll(['is_count' => true], ['in', 'slug', $non_count_slug]);
    }

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  //  protected function ActiondumpUntracedRequest()
  protected function dump_untraced_request()
  {
    $connection = \Yii::$app->getDb();
    $command = $connection->createCommand("SELECT DISTINCT(request_full_url) FROM site_frontend_request WHERE request_full_url NOT IN (SELECT DISTINCT(url) AS url FROM site_pages where status = 1) AND request_full_url NOT IN (SELECT DISTINCT(url) AS url FROM site_untraced_request)");
    $un_traced_record = $command->queryAll();
    if (count($un_traced_record) > 0) {
      $temp_array = [];
      foreach ($un_traced_record as $record) {
        $temp_array[] = [
          'url' => $record['request_full_url']
        ];
      }

      \Yii::$app->db->createCommand()->batchInsert('site_untraced_request', ['url'], $temp_array)->execute();
    }
  }

  //protected function ActionMakeRequestGrouping()
  protected function make_request_grouping()
  {
    $affectedRows = \Yii::$app->db->createCommand("UPDATE site_frontend_request SET request_group = SUBSTRING_INDEX(route, '/', 1) WHERE is_count = :val1")->bindValue(':val1', 0)->execute();

    //make auth enty
    $affectedRows = \Yii::$app->db->createCommand("UPDATE site_frontend_request SET request_group = 'login' WHERE is_count = :val1 AND route = :val2")->bindValue(':val1', 0)->bindValue(':val2', 'site/auth')->execute();

    //make auth enty
    $affectedRows = \Yii::$app->db->createCommand("UPDATE site_frontend_request SET request_group = 'other' WHERE is_count = :val1 AND route = :val2")->bindValue(':val1', 0)->bindValue(':val2', '')->execute();
  }
}
