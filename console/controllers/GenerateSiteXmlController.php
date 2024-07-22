<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

use common\models\trierror\FrontendRequestLog;
use common\models\trierror\FrontendRequestLogSearch;
use common\models\cms\article\Article;
use common\models\cms\article\MasterArticleTopic;
use common\models\cms\article\MasterArticleTag;
use common\models\park\Park;
use common\models\operator\SafariOperator;
use common\models\trierror\SitePages;
use common\models\cms\article\ArticleAuthor;
use common\models\sharesafari\ShareSafari;
use yii\helpers\Url;

/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class GenerateSiteXmlController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all FrontendRequestLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //get article site pages
        $this->get_article_site_pages();
        $this->get_article_category_site_pages();
        $this->get_article_tags_site_pages();
        $this->get_park_site_pages();
        $this->get_safari_operator_pages();
        $this->get_shared_safari_site_pages();
    }

    protected function get_safari_operator_pages(){
        $base_url = 'http://walkintothewild_frontend/';
        
        $safari_operators = SafariOperator::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'safari_operator', 'status' => true]);
        if(count($safari_operators) > 0){
            $insert_safari_operator_site_pages = [];
            foreach($safari_operators as $operator){
                $insert_safari_operator_site_pages[] = [
                    'content_id' => $operator['id'],
                    'content_type' => 'safari_operator',
                    'slug' => $operator['slug'],
                    'url' => $base_url.'operator/'.$operator['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $operator['updated_at']),
                    'counter' => $operator['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_safari_operator_site_pages)->execute();
        }
    }

    protected function get_park_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';

        $parks = Park::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'parks', 'status' => true]);
        if(count($parks) > 0){
            $insert_parks_site_pages = [];
            foreach($parks as $park){
                $insert_parks_site_pages[] = [
                    'content_id' => $park['id'],
                    'content_type' => 'parks',
                    'slug' => $park['slug'],
                    'url' => $base_url.'park/'.$park['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $park['updated_at']),
                    'counter' => $park['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_parks_site_pages)->execute();
        }
    }

    protected function get_article_tags_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';
        
        //fetch article xml pages from article category
        $article_tags = MasterArticleTag::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article_tag', 'status' => true]);
        if(count($article_tags) > 0){
            $insert_article_tag_site_pages = [];
            foreach($article_tags as $tag){
                $insert_article_tag_site_pages[] = [
                    'content_id' => $tag['id'],
                    'content_type' => 'article_tag',
                    'slug' => $tag['slug'],
                    'url' => $base_url.'article/tag/'.$tag['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $tag['updated_at']),
                    'counter' => $tag['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_tag_site_pages)->execute();
        }
    }

    protected function get_article_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';

        $articles = Article::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article', 'status' => true]);
        if(count($articles) > 0){
            $insert_article_site_pages = [];
            foreach($articles as $article){
                $insert_article_site_pages[] = [
                    'content_id' => $article['id'],
                    'content_type' => 'article',
                    'slug' => $article['slug'],
                    'url' => $base_url.'article/'.$article['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $article['updated_at']),
                    'counter' => $article['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();
        }
    }

    protected function get_article_category_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';
        
        $articles_category = MasterArticleTopic::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article_category', 'status' => true]);
        if(count($articles_category) > 0){
            $insert_article_category_site_pages = [];
            foreach($articles_category as $category){
                $insert_article_category_site_pages[] = [
                    'content_id' => $category['id'],
                    'content_type' => 'article_category',
                    'slug' => $category['slug'],
                    'url' => $base_url.'article/topic/'.$category['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $category['updated_at']),
                    'counter' => $category['total_view'],
                ];
            }   

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_category_site_pages)->execute();
        }        
    }

    protected function get_shared_safari_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';

        $shared_safari = ShareSafari::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'shared_safari', 'status' => true]);
        if(count($shared_safari) > 0){
            $insert_article_site_pages = [];
            foreach($shared_safari as $safari){
                $insert_article_site_pages[] = [
                    'content_id' => $safari['id'],
                    'content_type' => 'shared_safari',
                    'slug' => $safari['slug'],
                    'url' => $base_url.'sharedsafari/'.$safari['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $safari['updated_at']),
                    'counter' => $safari['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();
        }
    }

    protected function get_author_site_pages(){
        $base_url = 'http://walkintothewild_frontend/';

        $authors = ArticleAuthor::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'authors', 'status' => true]);
        if(count($authors) > 0){
            $insert_article_site_pages = [];
            foreach($authors as $author){
                $insert_article_site_pages[] = [
                    'content_id' => $author['id'],
                    'content_type' => 'authors',
                    'slug' => $author['slug'],
                    'url' => $base_url.'article/author/'.$author['slug'],
                    'last_update_at' => date('Y-m-d H:i:s', $author['updated_at']),
                    'counter' => $author['total_view'],
                ];
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();
        }
    }
}