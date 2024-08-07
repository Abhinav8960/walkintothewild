<?php

namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
use common\models\GeneralModel;
use common\models\package\Package;
use common\models\park\SafariPark;
use yii\web\NotFoundHttpException;
use common\models\trierror\SitePages;
use common\models\cms\article\Article;
//use common\models\park\Park;
use common\models\trierror\SiteRobots;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\cms\article\ArticleAuthor;
use common\models\master\animal\MasterAnimal;
use common\models\trierror\FrontendRequestLog;
use common\models\cms\article\MasterArticleTag;
use common\models\cms\article\MasterArticleTopic;
use common\models\master\animal\MasterRareAnimal;
use common\models\trierror\FrontendRequestLogSearch;


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

  public function actionSitePages1()
  {
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
      'category' => 'Article',
      'sub_category' => 'Article'
    ];

    $group_pages[] = [
      'table' => 'master_article_topic',
      'url' => 'article/topic/_slug',
      'url_type' => 'Primary',
      'category' => 'Article',
      'sub_category' => 'Topic'
    ];

    $group_pages[] = [
      'table' => 'article_author',
      'url' => 'article/author/_slug',
      'url_type' => 'Primary',
      'category' => 'Article',
      'sub_category' => 'Author'
    ];

    $this->process($group_pages);
  }

  public function actionSitePages2()
  {
    $group_pages = [];

    $group_pages[] = [
      'table' => 'share_safari',
      'url' => 'sharedsafari/_slug',
      'url_type' => 'Primary',
      'category' => 'Shared Safari',
      'sub_category' => 'Shared Safari'
    ];

    $group_pages[] = [
      'table' => 'package',
      'url' => 'package/_slug',
      'url_type' => 'Primary',
      'category' => 'Package',
      'sub_category' => 'Package'
    ];

    $group_pages[] = [
      'table' => 'master_rare_animal',
      'url' => 'animal/_slug',
      'url_type' => 'Primary',
      'category' => 'Animal',
      'sub_category' => 'Rare'
    ];

    $group_pages[] = [
      'table' => 'master_animal',
      'url' => 'animal/_slug',
      'url_type' => 'Primary',
      'category' => 'Animal',
      'sub_category' => 'Usual'
    ];

    $this->process($group_pages);
  }

  public function actionSitePages3()
  {
    $group_pages = [];

    $group_pages[] = [
      'table' => 'safari_operator',
      'url' => 'operator/_slug',
      'url_type' => 'Primary',
      'category' => 'Operator',
      'sub_category' => 'Operator'
    ];
    $this->process($group_pages);
  }

  public function actionSitePages4()
  {
    $start = microtime(true);

    // $this->get_monthly_package_site_pages();
    // $this->get_monthly_shared_safari_site_pages();
    //$this->get_operator_tabs_site_pages();
    $this->get_static_pages('static pages');

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function process($group_pages)
  {
    $start = microtime(true);

    foreach ($group_pages as $grp) {
      $this->update_site_pages($grp);
    }

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

          /*
          $s_request = FrontendRequestLog::find()->where(['request_url' => $url])->orderBy('id DESC')->asArray()->one();
          if ($s_request) {
            $method = $s_request['request_type'];
            $get_parameter = $s_request['request_parameter'];
            $post_parameter = $s_request['request_data'];
          }
          */

          //
          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];
          $model = SitePages::find()->where(['content_id' => $row['id']])->andWhere(['content_table' => $data['table']])->one();
          if ($model) {
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
              'slug' => $row['slug'],
              'category' => $data['category'],
              'sub_category' => $data['sub_category'],
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
              'counter' => 0,
              'is_get' => $is_get,
              'is_post' => $is_post,
              'is_ajax' => $is_ajax,
              'status' => 1
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_id' => $row['id'], 'content_table' => $data['table']]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
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
            //'method' => 'Get',
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

          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $insert_package_site_pages[] = [
            'content_id' => $ind,
            'content_table' => '',
            'slug' => strtolower($month),
            'url' => $url,
            'url_type' => 'Secondary',
            'is_get' => $is_get,
            'is_post' => $is_post,
            'is_ajax' => $is_ajax,
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

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'is_get', 'is_post', 'is_ajax', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
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

          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $insert_package_site_pages[] = [
            'content_id' => $month['id'],
            'content_table' => '',
            'slug' => $month['slug'],
            'url' => $url,
            'url_type' => 'Secondary',
            'category' => 'Animal',
            'sub_category' => 'Usual',
            'get_parameter'  => "{'slug':'" . $month['slug'] . "'}",
            'post_parameter'  => "[]",
            'is_get' => $is_get,
            'is_post' => $is_post,
            'is_ajax' => $is_ajax,
            'last_update_at' => date('Y-m-d H:i:s'),
            'counter' => 0,
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
          ];
        }

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'is_get', 'is_post', 'is_ajax', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
      }
    }
  }

  protected function get_operator_tabs_site_pages()
  {
    $records = SafariOperator::find()->select(['id', 'slug', 'updated_at', 'total_view', 'status'])->asArray()->all();
    $tab_urls = ['package' => '/package', 'park' => '/park', 'review' => '/reviewlist', 'article' => '/article', 'contact' => '/contact'];
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        foreach ($tab_urls as $ind => $tab) {
          if ($row['status'] && !empty($row['slug'])) {
            //update existing record
            $data_url = "operator/_slug";
            $url = str_replace("_slug", $row['slug'], $data_url);
            $url = $url . $tab;

            $s_request = $this->getrequestinfo($url);
            $get_parameter = $s_request['get_parameter'];
            $post_parameter = $s_request['post_parameter'];
            $is_get = $s_request['is_get'];
            $is_post = $s_request['is_post'];
            $is_ajax = $s_request['is_ajax'];

            $model = SitePages::find()->where(['content_table' => 'safari_operator'])->andWhere(['url' => $url])->one();
            if ($model) {
              //$model->method = $method;
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
                'is_get' => $is_get,
                'is_post' => $is_post,
                'is_ajax' => $is_ajax,
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
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'is_get', 'is_post', 'is_ajax', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_static_pages()
  {
    $pages = [
      'article',
      'park',
      'shared-safari',
      'safari-packages',
      'sharedsafari',
      'operator',
      'plan-safari',
      'safaritour-registration',
      'birdingtour-registration',
      'termsandcondition',
      'contact',
      '/',
      'account',
    ];

    foreach ($pages as $page) {
      $url = $page;

      $s_request = $this->getrequestinfo($url);
      $get_parameter = $s_request['get_parameter'];
      $post_parameter = $s_request['post_parameter'];
      $is_get = $s_request['is_get'];
      $is_post = $s_request['is_post'];
      $is_ajax = $s_request['is_ajax'];

      $model = SitePages::find()->where(['content_table' => 'cms'])->andWhere(['url' => $url])->one();

      if ($model) {
        $model->get_parameter  = $s_request['get_parameter'];
        $model->post_parameter  = $post_parameter;
        $model->last_update_at = date('Y-m-d H:i:s');
        $model->status = 1;
        $model->save(false);
      } else {
        $category = 'CMS';
        $sub_category = 'Pages';
        if ($page == 'operator') {
          $category = 'Operator';
          $sub_category = 'Operator';
        } else if ($page == 'article') {
          $category = 'Article';
          $sub_category = 'Article';
        } else if ($page == 'park') {
          $category = 'Park';
          $sub_category = 'Park';
        } else if ($page == 'shared-safari') {
          $category = 'Shared Safari';
          $sub_category = 'Shared Safari';
        } else if ($page == 'safari-packages') {
          $category = 'Package';
          $sub_category = 'Package';
        } else if ($page == 'sharedsafari') {
          $category = 'Shared Safari';
          $sub_category = 'Shared Safari';
        }

        //insert new record
        $model = new SitePages();
        $model->content_id = 0;
        $model->content_table = 'content_management';
        $model->url = $url;
        $model->url_type = 'Primary';
        $model->category = $category;
        $model->sub_category = $sub_category;
        $model->get_parameter  = $s_request['get_parameter'];
        $model->post_parameter  = $s_request['post_parameter'];
        $model->is_get = $is_get;
        $model->is_post = $is_post;
        $model->is_ajax = $is_ajax;
        $model->last_update_at = date('Y-m-d H:i:s');
        $model->counter = 0;
        $model->status = 1;
        $model->save(false);
      }
    }
  }

  protected function getrequestinfo($url)
  {
    $return = [
      'is_get' => 1,
      'get_parameter' => '[]',
      'post_parameter' => '[]',
      'is_ajax' => 0,
      'is_get' => 0,
      'is_post' => 0
    ];

    $full = Yii::$app->params['frontend_url'] . $url;
    $s_request = FrontendRequestLog::find()->where(['request_full_url' => $full])->andWhere(['request_code' => 200])->orderBy('id DESC')->asArray()->one();
    if (!empty($s_request)) {
      $return['get_parameter'] = $s_request['request_parameter'];
      $return['post_parameter'] = $s_request['request_data'];
      if ($s_request['request_type'] == 'GET') {
        $return['is_get'] = 1;
      }

      if ($s_request['request_type'] == 'POST') {
        $return['is_post'] = 1;
      }
      $return['is_ajax'] = $s_request['isAjax'];
    }

    return $return;
  }
}
