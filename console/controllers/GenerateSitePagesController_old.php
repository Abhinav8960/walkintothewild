<?php

namespace console\controllers;

use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\filters\VerbFilter;
use common\models\GeneralModel;
use common\models\package\PackageVersion;
use common\models\park\SafariPark;
use yii\web\NotFoundHttpException;
use common\models\trierror\SitePages;
use common\models\cms\article\Article;
//use common\models\park\Park;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\cms\article\ArticleAuthor;
use common\models\master\animal\MasterAnimal;
use common\models\cms\article\MasterArticleTag;
use common\models\cms\article\MasterArticleTopic;
use common\models\User;

class GenerateSitePagesController_old extends Controller
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
      'url' => 'operator/_slug/sharedsafari',
      'url_type' => 'Primary',
      'category' => 'Operator',
      'sub_category' => 'Operator'
    ];

    $this->get_join_safari_site_pages();
    $this->get_unjoin_safari_site_pages();

    $this->process($group_pages);
  }

  public function actionSitePages4()
  {
    $start = microtime(true);

    $this->get_static_pages();

    $this->get_monthly_package_site_pages();
    $this->get_monthly_shared_safari_site_pages();
    $this->get_operator_tabs_site_pages();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionSitePages5()
  {
    $start = microtime(true);

    $group_pages = [];
    $group_pages[] = [
      'table' => 'safari_park',
      'url' => 'park/_slug',
      'url_type' => 'Primary',
      'category' => 'Park',
      'sub_category' => 'Park'
    ];

    $this->process($group_pages);
    $this->get_park_tabs_site_pages();
    $this->get_shar_safari_site_pages();
    $this->get_package_site_pages();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionSitePages6()
  {
    $start = microtime(true);

    $this->get_user_follow();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionSitePage7()
  {
    $start = microtime(true);

    $this->get_operator_follow();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionSitePage8()
  {
    $start = microtime(true);
    $this->get_wishlist();

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
      $records = MasterArticleTag::find()->all();
    } else if ($data['table'] == 'safari_operator') {
      $records = SafariOperator::find()->all();
    } else if ($data['table'] == 'safari_park') {
      $records = SafariPark::find()->all();
    } else if ($data['table'] == 'article') {
      $records = Article::find()->all();
    } else if ($data['table'] == 'master_article_topic') {
      $records = MasterArticleTopic::find()->all();
    } else if ($data['table'] == 'article_author') {
      $records = ArticleAuthor::find()->all();
    } else if ($data['table'] == 'master_animal') {
      $records = MasterAnimal::find()->all();
    }

    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        if ($row['status'] == 1) {
          //update existing record
          $url = str_replace("_slug", $row->slug, $data['url']);

          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $title = $description = $keywords = $image = '';
          if ($data['table'] == 'master_article_tag') {
            $title = "Article Tag:" . $row->title;
          } else if ($data['table'] == 'article') {
            $title = "Article: " . $row->title;
            $description = strip_tags($row->description);
            if (!empty($row['meta_description'])) {
              $description = strip_tags($row->meta_description);
            }
            $keywords = $row->meta_keywords;
            if (!empty($row->banner_image)) {
              $image = $row->bannerimagepath;
            }
          } else if ($data['table'] == 'master_article_topic') {
            $title = "Article Topic:" . $row->title;
          } else if ($data['table'] == 'article_author') {
            $title = "Article Author:" . $row->author_name;
          } else if ($data['table'] == 'master_animal') {
            $title = "Animal:" . $row->name;
            $description = strip_tags($row->short_description);
            if (!empty($row->feature_image)) {
              $image = $row->imagepath;
            }
          } else if ($data['table'] == 'safari_operator') {
            $title = "Operator:" . $row->businessname;
            $description = strip_tags($row->about_business);
            if (!empty($row->logo)) {
              $image = $row->imagepath;
            }
          } else if ($data['table'] == 'safari_park') {
            $title = "Park:" . $row->title;
            $description = strip_tags($row->long_description);
            if (!empty($row->short_description)) {
              $description = strip_tags($row->short_description);
            }
            if (!empty($row->logo)) {
              $image = $row->logoimagepath;
            }
          }

          $model = SitePages::find()->where(['url' => $url])->one();
          if ($model) {
            $model->title = $title;
            $model->description = $description;
            $model->keywords = $keywords;
            $model->image = $image;
            $model->category = $data['category'];
            $model->sub_category = $data['sub_category'];
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row->updated_at);
            $model->status = 1;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => $row->id,
              'content_table' => $data['table'],
              'url' => $url,
              'url_type' => $data['url_type'],
              'slug' => $row->slug,
              'category' => $data['category'],
              'sub_category' => $data['sub_category'],
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row->updated_at),
              'title' => $title,
              'description' => $description,
              'keywords' => $keywords,
              'image' => $image,
              'counter' => 0,
              'is_get' => $is_get,
              'is_post' => $is_post,
              'is_ajax' => $is_ajax,
              'status' => 1
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_id' => $row->id, 'content_table' => $data['table']]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'title', 'description', 'keywords', 'image', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
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

        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'slug', 'url', 'url_type', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status', 'updated_at'], $insert_package_site_pages)->execute();
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
    $records = SafariOperator::find()->all();
    $tab_urls = ['package' => '/package', 'park' => '/park', 'review' => '/reviewlist', 'article' => '/article', 'contact' => '/contact'];
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $title = $description = $image = '';
        $description = strip_tags($row->about_business);
        if (!empty($row->logo)) {
          $image = $row->imagepath;
        }

        foreach ($tab_urls as $ind => $tab) {
          $title = "Operator " . ucwords($ind) . ":" . $row->businessname;

          if (!empty($row->slug) && $row->status == 1) {
            //update existing record
            $data_url = "operator/_slug";
            $url = str_replace("_slug", $row->slug, $data_url);
            $url = $url . $tab;

            $s_request = $this->getrequestinfo($url);
            $get_parameter = $s_request['get_parameter'];
            $post_parameter = $s_request['post_parameter'];
            $is_get = $s_request['is_get'];
            $is_post = $s_request['is_post'];
            $is_ajax = $s_request['is_ajax'];

            $model = SitePages::find()->where(['content_table' => 'safari_operator'])->andWhere(['url' => $url])->one();
            if ($model) {
              $model->title = $title;
              $model->description = $description;
              $model->image = $image;
              $model->get_parameter  = $get_parameter;
              $model->post_parameter  = $post_parameter;
              $model->last_update_at = date('Y-m-d H:i:s', $row->updated_at);
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
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'get_parameter' => $get_parameter,
                'post_parameter' => $post_parameter,
                'last_update_at' => date('Y-m-d H:i:s', $row->updated_at),
                'counter' => 0,
                'status' => 1,
              ];
            }
          } else {
            $data_url = "operator/_slug" . $tab;
            $url = str_replace("_slug", $row->slug, $data_url);

            //mark as disabled
            SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_table' => 'safari_operator', 'url' => $url]);
          }
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'is_get', 'is_post', 'is_ajax', 'slug', 'category', 'sub_category', 'title', 'description', 'image', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_park_tabs_site_pages()
  {
    $records = SafariPark::find()->all();
    $tab_urls = ['package' => '/package', 'share safari' => '/sharedsafari', 'review' => '/reviewlist'];
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $title = $description = $image = '';
        $description = strip_tags($row->long_description);
        if (!empty($row->short_description)) {
          $description = strip_tags($row->short_description);
        }
        if (!empty($row->logo)) {
          $image = $row->logoimagepath;
        }
        foreach ($tab_urls as $ind => $tab) {
          $title = "Park " . ucwords($ind) . ":" . $row->title;
          if (!empty($row->slug) && $row->status == 1) {
            //update existing record
            $data_url = "park/_slug";
            $url = str_replace("_slug", $row->slug, $data_url);
            $url = $url . $tab;

            $s_request = $this->getrequestinfo($url);
            $get_parameter = $s_request['get_parameter'];
            $post_parameter = $s_request['post_parameter'];
            $is_get = $s_request['is_get'];
            $is_post = $s_request['is_post'];
            $is_ajax = $s_request['is_ajax'];

            $model = SitePages::find()->where(['content_table' => 'park'])->andWhere(['url' => $url])->one();
            if ($model) {
              $model->title = $title;
              $model->description = $description;
              $model->image = $image;
              $model->get_parameter  = $get_parameter;
              $model->post_parameter  = $post_parameter;
              $model->last_update_at = date('Y-m-d H:i:s', $row->updated_at);
              $model->status = 1;
              $model->save(false);
            } else {
              //insert new record
              $temp_insert_data[] = [
                'content_id' => 0,
                'content_table' => 'park',
                'url' => $url,
                'url_type' => 'Primary',
                'is_get' => $is_get,
                'is_post' => $is_post,
                'is_ajax' => $is_ajax,
                'slug' => $row->slug,
                'category' => 'Park',
                'sub_category' => $ind,
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'get_parameter' => $get_parameter,
                'post_parameter' => $post_parameter,
                'last_update_at' => date('Y-m-d H:i:s', $row->updated_at),
                'counter' => 0,
                'status' => 1,
              ];
            }
          } else {
            $data_url = "park/_slug" . $tab;
            $url = str_replace("_slug", $row->slug, $data_url);

            //mark as disabled
            SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_table' => 'park', 'url' => $url]);
          }
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'is_get', 'is_post', 'is_ajax', 'slug', 'category', 'sub_category', 'title',  'description', 'image', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_join_safari_site_pages()
  {
    $records = ShareSafari::find()->all();
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $url = "sharedsafari/" . $row->organizedslug . "/" . $row->slug . "/join";
        if ($row['status'] == 1) {
          //update existing record
          $title = $description = $keywords = $image = '';

          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $model = SitePages::find()->andWhere(['category' => 'Shared Safari'])->andWhere(['sub_category' => 'Join Safari'])->andWhere(['url' => $url])->one();
          if ($model) {
            $model->url = $url;
            $model->category = 'Action';
            $model->sub_category = 'Shared Safari Join';
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
            $model->status = 0;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => 0,
              'content_table' => '',
              'url' => $url,
              'url_type' => 'Primary',
              'slug' => '',
              'category' => 'Action',
              'sub_category' => 'Shared Safari Join',
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
              'counter' => 0,
              'is_get' => $is_get,
              'is_post' => $is_post,
              'is_ajax' => $is_ajax,
              'status' => 0
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['category' => 'Shared Safari', 'sub_category' => 'Join Safari', 'url' => $url]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_unjoin_safari_site_pages()
  {
    $records = ShareSafari::find()->all();
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $url = "sharedsafari/" . $row->organizedslug . "/" . $row->slug . "/unjoin";
        if ($row['status'] == 1) {
          //update existing record
          $title = $description = $keywords = $image = '';

          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $model = SitePages::find()->andWhere(['category' => 'Shared Safari'])->andWhere(['sub_category' => 'Unjoin Safari'])->andWhere(['url' => $url])->one();
          if ($model) {
            $model->url = $url;
            $model->category = 'Action';
            $model->sub_category = 'Shared Safari Unjoin';
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
            $model->status = 0;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => 0,
              'content_table' => '',
              'url' => $url,
              'url_type' => 'Primary',
              'slug' => '',
              'category' => 'Action',
              'sub_category' => 'Shared Safari Unjoin',
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
              'counter' => 0,
              'is_get' => $is_get,
              'is_post' => $is_post,
              'is_ajax' => $is_ajax,
              'status' => 0
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['category' => 'Shared Safari', 'sub_category' => 'Unjoin Safari', 'url' => $url]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_shar_safari_site_pages()
  {
    $records = ShareSafari::find()->all();
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $url = "sharedsafari/" . $row->organizedslug . "/" . $row->slug;
        if ($row['status'] == 1) {
          $title = $description = $image = '';
          $title = 'Shared Safari';
          $description = strip_tags($row->safari_plan);
          if (isset($row->sharedimagepath)) {
            $image = $row->sharedimagepath;
          }

          //update existing record
          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $model = SitePages::find()->where(['category' => 'Shared Safari'])->andWhere(['sub_category' => 'Safari'])->andWhere(['url' => $url])->one();
          if ($model) {
            $model->title = $title;
            $model->description = $description;
            $model->image = $image;
            $model->url = $url;
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
            $model->status = 1;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => $row->id,
              'content_table' => 'share_safari',
              'url' => $url,
              'url_type' => 'Primary',
              'slug' => '',
              'category' => 'Shared Safari',
              'sub_category' => 'Safari',
              'title' => $title,
              'description' => $description,
              'image' => $image,
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
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['category' => 'Shared Safari', 'sub_category' => 'Safari', 'url' => $url]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'title', 'description', 'image', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_package_site_pages()
  {
    $records = Package::find()->all();
    if (count($records) > 0) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        $url = "package/" . $row->safarioperator->slug . "/" . $row->package_slug;

        $title = $description = $image = '';
        $title = "Package:" . $row->package_name;
        $description = strip_tags($row->package_description);
        if (isset($row->imagebannerpath)) {
          $image = $row->imagebannerpath;
        }

        if ($row['status'] == 1) {
          //update existing record
          $s_request = $this->getrequestinfo($url);
          $get_parameter = $s_request['get_parameter'];
          $post_parameter = $s_request['post_parameter'];
          $is_get = $s_request['is_get'];
          $is_post = $s_request['is_post'];
          $is_ajax = $s_request['is_ajax'];

          $model = SitePages::find()->where(['category' => 'Package'])->andWhere(['sub_category' => 'Package'])->andWhere(['url' => $url])->one();
          if ($model) {
            $model->title = $title;
            $model->image = $image;
            $model->description = $description;
            $model->url = $url;
            $model->get_parameter  = $get_parameter;
            $model->post_parameter  = $post_parameter;
            $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
            $model->status = 1;
            $model->save(false);
          } else {
            //insert new record
            $temp_insert_data[] = [
              'content_id' => $row->id,
              'content_table' => 'package',
              'url' => $url,
              'url_type' => 'Primary',
              'slug' => '',
              'category' => 'Package',
              'sub_category' => 'Package',
              'title' => $title,
              'description' => $description,
              'image' => $image,
              'get_parameter' => $get_parameter,
              'post_parameter' => $post_parameter,
              'last_update_at' => date('Y-m-d H:i:s', $row->updated_at),
              'counter' => 0,
              'is_get' => $is_get,
              'is_post' => $is_post,
              'is_ajax' => $is_ajax,
              'status' => 1
            ];
          }
        } else {
          //mark as disabled
          SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['category' => 'Package', 'sub_category' => 'Package', 'url' => $url]);
        }
      }

      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'title', 'description', 'image', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_static_pages()
  {
    $pages = [
      'article',
      'park',
      'package',
      'sharedsafari',
      'operator',
      'plan-safari',
      //'safaritour-registration',
      //'birdingtour-registration',
      //'termsandcondition',
      'terms-of-use',
      'privacy-policy',
      'about-us',
      'contact-us',
      'faq',
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
      } else if ($page == 'sharedsafari') {
        $category = 'Shared Safari';
        $sub_category = 'Shared Safari';
      } else if ($page == 'package') {
        $category = 'Package';
        $sub_category = 'Package';
      } else if ($page == 'sharedsafari') {
        $category = 'Shared Safari';
        $sub_category = 'Shared Safari';
      }

      $model = SitePages::find()->where(['category' => $category])->andWhere(['url' => $url])->one();

      if ($model) {
        $model->get_parameter  = $s_request['get_parameter'];
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

  protected function get_user_follow()
  {
    $records = User::find()->asArray()->all();
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        if (!empty($row['user_handle'])) {
          $temp_data = [
            'user_follow' => 'profile/follow/' . $row['user_handle'],
            'user_unfollow' => 'profile/unfollow/' . $row['user_handle']
          ];

          foreach ($temp_data as $key => $user_url) {
            //check record is exist or not
            $model = SitePages::find()->where(['url' => $user_url])->andWhere(['content_table' => 'user'])->one();

            $s_request = $this->getrequestinfo($user_url);
            $get_parameter = $s_request['get_parameter'];
            $post_parameter = $s_request['post_parameter'];
            $is_get = $s_request['is_get'];
            $is_post = $s_request['is_post'];
            $is_ajax = $s_request['is_ajax'];

            $title = $description = $keywords = $image = '';

            if ($model) {
              $model->get_parameter  = $get_parameter;
              $model->post_parameter  = $post_parameter;
              $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
              $model->status = 0;
              $model->save(false);
            } else {
              //insert new record
              $temp_insert_data[] = [
                'content_id' => $row['id'],
                'content_table' => 'user',
                'url' => $user_url,
                'url_type' => 'Secondory',
                'slug' => null,
                'category' => 'Action',
                'sub_category' => ucwords(str_replace("_", " ", $key)),
                'get_parameter' => $get_parameter,
                'post_parameter' => $post_parameter,
                'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
                'counter' => 0,
                'is_get' => $is_get,
                'is_post' => $is_post,
                'is_ajax' => $is_ajax,
                'status' => 0
              ];
            }
          }
        }
      }

      //insert records
      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }

  protected function get_operator_follow()
  {
    $records = SafariOperator::find()->asArray()->all();
    if (count($records)) {
      $temp_insert_data = [];
      foreach ($records as $row) {
        if (!empty($row['slug'])) {
          $temp_data = [
            'operator_follow' => 'operator/' . $row['slug'] . '/follow',
            'operator_unfollow' => 'operator/' . $row['slug'] . '/unfollow',
          ];

          foreach ($temp_data as $key => $user_url) {
            //check record is exist or not
            $model = SitePages::find()->where(['url' => $user_url])->one();

            $s_request = $this->getrequestinfo($user_url);
            $get_parameter = $s_request['get_parameter'];
            $post_parameter = $s_request['post_parameter'];
            $is_get = $s_request['is_get'];
            $is_post = $s_request['is_post'];
            $is_ajax = $s_request['is_ajax'];

            $title = $description = $keywords = $image = '';

            if ($model) {
              $model->get_parameter  = $get_parameter;
              $model->post_parameter  = $post_parameter;
              $model->last_update_at = date('Y-m-d H:i:s', $row['updated_at']);
              $model->status = 0;
              $model->save(false);
            } else {
              //insert new record
              $temp_insert_data[] = [
                'content_id' => $row['id'],
                'content_table' => 'user',
                'url' => $user_url,
                'url_type' => 'Secondory',
                'slug' => null,
                'category' => 'Action',
                'sub_category' => ucwords(str_replace("_", " ", $key)),
                'get_parameter' => $get_parameter,
                'post_parameter' => $post_parameter,
                'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
                'counter' => 0,
                'is_get' => $is_get,
                'is_post' => $is_post,
                'is_ajax' => $is_ajax,
                'status' => 0
              ];
            }
          }
        }
      }

      //insert records
      if (count($temp_insert_data)) {
      }
      Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_table', 'url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
    }
  }

  protected function get_wishlist()
  {
    $tables = ['ShareSafari', 'Package'];
    foreach ($tables as $table) {
      $records = [];

      if ($table == 'Package') {
        $records = Package::find()->all();
      }

      if ($table == 'ShareSafari') {
        $records = ShareSafari::find()->all();
      }

      $temp_insert_data = [];
      if (count($records)) {
        foreach ($records as $row) {
          $slug = $temp_slug = '';
          if (isset($row->slug)) {
            $slug = $row->slug;
            if (isset($row->safarioperator->slug)) {
              $temp_slug = $row->safarioperator->slug;
            }
          }

          if (isset($row->package_slug)) {
            $slug = $row->package_slug;
            if (isset($row->safarioperator->slug)) {
              $temp_slug = $row->safarioperator->slug;
            }
          }

          $temp_data = [
            'Package Wishlist Add' => 'package/' . $temp_slug . '/' . $slug . '/wishlist',
            'Package Wishlist Remove' => 'package/' . $temp_slug . '/' . $slug . '/unwishlist'
          ];

          if ($table == 'ShareSafari') {
            $temp_data = [
              'Shared Safari Wishlist Add' => 'sharedsafari/' . $temp_slug . '/' . $slug . '/wishlist',
              'Shared Safari Wishlist Remove' => 'sharedsafari/' . $temp_slug . '/' . $slug . '/unwishlist'
            ];
          }

          foreach ($temp_data as $key => $user_url) {
            if (!empty($temp_slug) && !empty($slug)) {
              //check record is exist or not
              $model = SitePages::find()->where(['url' => $user_url])->one();

              $s_request = $this->getrequestinfo($user_url);
              $get_parameter = $s_request['get_parameter'];
              $post_parameter = $s_request['post_parameter'];
              $is_get = $s_request['is_get'];
              $is_post = $s_request['is_post'];
              $is_ajax = $s_request['is_ajax'];

              $title = $description = $keywords = $image = '';

              if ($model) {
                $model->get_parameter  = $get_parameter;
                $model->post_parameter  = $post_parameter;
                $model->last_update_at = date('Y-m-d H:i:s', $row->updated_at);
                $model->status = 0;
                $model->save(false);
              } else {
                //insert new record
                $temp_insert_data[] = [
                  'url' => $user_url,
                  'url_type' => 'Secondory',
                  'slug' => $slug,
                  'category' => 'Action',
                  'sub_category' => ucwords(str_replace("_", " ", $key)),
                  'get_parameter' => $get_parameter,
                  'post_parameter' => $post_parameter,
                  'last_update_at' => date('Y-m-d H:i:s', $row['updated_at']),
                  'counter' => 0,
                  'is_get' => $is_get,
                  'is_post' => $is_post,
                  'is_ajax' => $is_ajax,
                  'status' => 0
                ];
              }
            }
          }
        }
      }

      //insert records
      if (count($temp_insert_data)) {
        Yii::$app->db->createCommand()->batchInsert('site_pages', ['url', 'url_type', 'slug', 'category', 'sub_category', 'get_parameter', 'post_parameter', 'last_update_at', 'counter', 'is_get', 'is_post', 'is_ajax', 'status'], $temp_insert_data)->execute();
      }
    }
  }
}
