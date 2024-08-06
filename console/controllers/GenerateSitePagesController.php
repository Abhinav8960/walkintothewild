<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
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
use common\models\trierror\SiteRobots;
use common\models\package\Package;
use common\models\master\animal\MasterRareAnimal;
use common\models\GeneralModel;
use common\models\master\animal\MasterAnimal;


class GenerateSitePagesController extends Controller
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
    $start = microtime(true);

    $group_pages = [];

    $group_pages[] = [
      'table' => 'master_article_tag',
      'url' => 'article/tag/_slug',
      'url_type' => 'Primary',
      'category' => 'Article',
      'sub_category' => 'Tag'
    ];

    $group_pages[] = [
      'table' => 'article',
      'url' => 'article/_slug',
      'url_type' => 'Primary',
      'category' => 'Article', //ask
      'sub_category' => 'Article'
    ];

    $group_pages[] = [
      'table' => 'master_article_topic',
      'url' => 'article/topic/_slug',
      'url_type' => 'Primary',
      'category' => 'Article', //ask
      'sub_category' => 'Topic'
    ];

    $group_pages[] = [
      'table' => 'article_author',
      'url' => 'article/author/_slug',
      'url_type' => 'Primary',
      'category' => 'Article', //ask
      'sub_category' => 'Author'
    ];


    $group_pages[] = [
      'table' => 'safari_park',
      'url' => 'park/_slug',
      'url_type' => 'Primary',
      'category' => 'Park', //ask
      'sub_category' => 'Park'
    ];

    $group_pages[] = [
      'table' => 'safari_operator',
      'url' => 'operator/_slug',
      'url_type' => 'Primary',
      'category' => 'Operator', //ask
      'sub_category' => 'Operator'
    ];

    $group_pages[] = [
      'table' => 'share_safari',
      'url' => 'sharedsafari/_slug',
      'url_type' => 'Primary',
      'category' => 'Safari', //ask
      'sub_category' => 'Shared Safari'
    ];

    $group_pages[] = [
      'table' => 'package',
      'url' => 'package/_slug',
      'url_type' => 'Primary',
      'category' => 'Package', //ask
      'sub_category' => 'Package'
    ];

    $group_pages[] = [
      'table' => 'master_rare_animal',
      'url' => 'animal/_slug',
      'url_type' => 'Primary',
      'category' => 'Animal', //ask
      'sub_category' => 'Rare'
    ];

    $group_pages[] = [
      'table' => 'master_animal',
      'url' => 'animal/_slug',
      'url_type' => 'Primary',
      'category' => 'Animal', //ask
      'sub_category' => 'Usual'
    ];

    foreach ($group_pages as $grp) {
      $this->update_site_pages($grp);
    }

    $this->get_monthly_package_site_pages();
    $this->get_monthly_shared_safari_site_pages();
    //$this->get_animal_search_site_pages();
    $this->get_operator_tabs_site_pages();
    $this->get_static_pages('static pages');

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  protected function update_site_pages($data)
  {
    $records = [];
    if ($data['table'] == 'master_article_tag') {
      $records = MasterArticleTag::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'safari_operator') {
      $records = SafariOperator::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'safari_park') {
      $records = SafariPark::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'article') {
      $records = Article::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'master_article_topic') {
      $records = MasterArticleTopic::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'share_safari') {
      $records = ShareSafari::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'article_author') {
      $records = ArticleAuthor::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'package') {
      $records = Package::find()->select(['id', 'package_slug as slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'master_rare_animal') {
      $records = MasterRareAnimal::find()->select(['id', 'slug as slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    } else if ($data['table'] == 'master_animal') {
      $records = MasterAnimal::find()->select(['id', 'slug as slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    }

    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        if ($row['status']) {
          //update existing record
          $url = str_replace("_slug", $row['slug'], $data['url']);
          $method = $get_parameter = $post_parameter = '';

          $s_request = FrontendRequestLog::find()->where(['request_url' => $url])->orderBy('id DESC')->asArray()->one();
          if ($s_request) {
            $method = $s_request['request_type'];
            $get_parameter = $s_request['request_parameter'];
            $post_parameter = $s_request['request_data'];
          }

          $model = SitePages::find()->where(['content_id' => $row['id']])->andWhere(['content_table' => $data['table']])->one();
          if ($model) {
            $model->method = $method;
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
            $model->status = 1;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => $row['id'],
              'content_table' => $data['table'],
              'url' => $url,
              'url_type' => $data['url_type'],
              'method' => $method,
              'slug' => $row['slug'],
              'category' => $data['category'],
              'sub_category' => $data['sub_category'],
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
              'counter' => 0,
              'status' => 1,
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_id' => $row['id'], 'content_table' => $data['table']]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'method', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_monthly_package_site_pages()
  {
    $is_exist = SitePages::find()->where(['category' => 'Package'])->andWhere(['sub_category' => 'Monthly'])->one();
    if ($is_exist) {
      //already exist, do nothing
    } else {
      $available_months = GeneralModel::monthoption();
      if (count($available_months) > 0) {
        $insert_package_site_pages = [];
        foreach ($available_months as $ind => $month) {
          $url = "package/month/" . strtolower($month);
          $insert_package_site_pages[] = [
            'content_id' => $ind,
            'content_table' => '',
            'slug' => strtolower($month),
            'url' => $url,
            'url_type' => 'Secondary',
            'method' => 'Get',
            'category' => 'Package',
            'sub_category' => 'Monthly',
            'get_parameter'  => "{'slug':'" . strtolower($month) . "'}",
            'post_parameter'  => "[]",
            'last_update_at' => date('Y-m-d H:i:s'),
            'counter' => 0,
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
          ];
        }

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'method', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
      }
    }
  }

  protected function get_monthly_shared_safari_site_pages()
  {
    $is_exist = SitePages::find()->where(['category' => 'Shared Safari'])->andWhere(['sub_category' => 'Monthly'])->one();
    if ($is_exist) {
      //already exist, do nothing
    } else {
      $available_months = GeneralModel::monthoption();
      if (count($available_months) > 0) {
        $insert_package_site_pages = [];
        foreach ($available_months as $ind => $month) {
          $url = "sharedsafari/month/" . strtolower($month);
          $insert_package_site_pages[] = [
            'content_id' => $ind,
            'content_table' => '',
            'slug' => strtolower($month),
            'url' => $url,
            'url_type' => 'Secondary',
            'method' => 'Get',
            'category' => 'Shared Safari',
            'sub_category' => 'Monthly',
            'get_parameter'  => "{'slug':'" . strtolower($month) . "'}",
            'post_parameter'  => "[]",
            'last_update_at' => date('Y-m-d H:i:s'),
            'counter' => 0,
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
          ];
        }

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'method', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
      }
    }
  }

  protected function get_animal_search_site_pages()
  {
    $is_exist = SitePages::find()->where(['category' => 'Animal'])->andWhere(['sub_category' => 'Usual'])->one();
    if ($is_exist) {
      //already exist, do nothing
    } else {
      $animals = MasterAnimal::find()->select(['id', 'slug', 'name', 'updated_at'])->where(['status' => true])->asArray()->all();
      if (count($animals) > 0) {
        $insert_package_site_pages = [];
        foreach ($animals as $ind => $month) {
          $url = "animal/" . $month['slug'];
          $insert_package_site_pages[] = [
            'content_id' => $month['id'],
            'content_table' => '',
            'slug' => $month['slug'],
            'url' => $url,
            'url_type' => 'Secondary',
            'method' => 'Get',
            'category' => 'Animal',
            'sub_category' => 'Usual',
            'get_parameter'  => "{'slug':'" . $month['slug'] . "'}",
            'post_parameter'  => "[]",
            'last_update_at' => date('Y-m-d H:i:s'),
            'counter' => 0,
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
          ];
        }

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'method', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
      }
    }
  }

  protected function get_operator_tabs_site_pages()
  {
    $records = SafariOperator::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    $tab_urls = ['memberview' => '#memberview', 'package' => '/package#memberview', 'park' => '/park#memberview', 'reviewlist' => '/reviewlist#memberview', 'article' => '/article#memberview', 'contact' => '/contact#memberview'];
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        foreach ($tab_urls as $ind => $tab) {
          if ($row['status']) {
            //update existing record
            $data_url = "operator/_slug" . $tab;
            $url = str_replace("_slug", $row['slug'], $data_url);
            $method = $get_parameter = $post_parameter = '';

            $s_request = FrontendRequestLog::find()->where(['request_url' => $url])->orderBy('id DESC')->asArray()->one();
            if ($s_request) {
              $method = $s_request['request_type'];
              $get_parameter = $s_request['request_parameter'];
              $post_parameter = $s_request['request_data'];
            }

            $model = SitePages::find()->where(['content_table' => 'safari_operator'])->andWhere(['url' => $url])->one();
            if ($model) {
              $model->method = $method;
              $model->get_parameter  = $get_parameter;
              $model->post_parameter  = $post_parameter;
              $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
              $model->status = 1;
              $model->save(false);
            } else {
              //insert new record
              $temp_insert_data[] = [
                'content_id' => 0,
                'content_table' => 'safari_operator',
                'url' => $url,
                'url_type' => 'Primary',
                'method' => $method,
                'slug' => $row['slug'],
                'category' => 'Operator',
                'sub_category' => $ind,
                'get_parameter' => $get_parameter,
                'post_parameter' => $post_parameter,
                'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
                'counter' => 0,
                'status' => 1,
              ];
            }
          } else {
            $data_url = "operator/_slug" . $tab;
            $url = str_replace("_slug", $row['slug'], $data_url);

            //mark as disabled
            SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_table' => 'safari_operator', 'url' => $url]);
          }
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'method', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_static_pages()
  {
    $pages = [
      'safaritour-registration',
      'birdingtour-registration',
      'termsandcondition',
      'operator',
      'plan-safari',
      'contact',
      'article',
      'parklist',
      'shared-safari',
      'safari-packages',
      'parklist',
      'sharedsafari',
      '/',
      'account',
    ];

    foreach ($pages as $page) {
      $url = $page;

      $method = $get_parameter = $post_parameter = '';
      $s_request = FrontendRequestLog::find()->where(['request_url' => $url])->orderBy('id DESC')->asArray()->one();
      if ($s_request) {
        $method = $s_request['request_type'];
        $get_parameter = $s_request['request_parameter'];
        $post_parameter = $s_request['request_data'];
      }

      $model = SitePages::find()->where(['content_table' => 'content_management'])->andWhere(['url' => $url])->one();
      if ($model) {
        $model->method = $method;
        $model->get_parameter  = $get_parameter;
        $model->post_parameter  = $post_parameter;
        $model->last_update_at = date('Y-m-d H:i:s');
        $model->status = 1;
        $model->save(false);
      } else {
        //insert new record
        $model = new SitePages();
        $model->content_id = 0;
        $model->content_table = 'content_management';
        $model->url = $url;
        $model->url_type = 'Primary';
        $model->method = $method;
        $model->category = 'CMS';
        $model->sub_category = 'Pages';
        $model->get_parameter  = $get_parameter;
        $model->post_parameter  = $post_parameter;
        $model->last_update_at = date('Y-m-d H:i:s');
        $model->counter = 0;
        $model->status = 1;
        $model->save(false);
      }
    }
  }
}
