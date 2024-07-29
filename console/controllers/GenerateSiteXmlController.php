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
//use common\models\park\Park;
use common\models\park\SafariPark;
use common\models\operator\SafariOperator;
use common\models\trierror\SitePages;
use common\models\cms\article\ArticleAuthor;
use common\models\sharesafari\ShareSafari;
use common\models\trierror\SiteRobots;
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
        $start = microtime(true);

        $backend_actual_url = Yii::$app->params['datapath'] . "/sitemap";
        if (!file_exists($backend_actual_url)) {
            mkdir($backend_actual_url);
            chmod($backend_actual_url, 0777);
        }

        //get article site pages
        $additional_sitemap = [];
        $additional_sitemap[] = $this->static_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_safari_operator_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_park_site_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_article_site_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_article_category_site_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_shared_safari_site_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_author_site_pages($backend_actual_url);
        $additional_sitemap[] = $this->get_article_tags_site_pages($backend_actual_url);

        //create site_index file
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

        $myFile = $backend_actual_url . "/sitemap.xml";
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $xml_content);
        fclose($fh);
        //chmod($fh, 0777);

        //create robots.txt to make entry of sitemap_index.xml
        $content = "Sitemap: " . Yii::$app->params['frontend_url'] . "storage/sitemap/sitemap.xml";
        $all_url = SiteRobots::find()->where(['status' => true])->all();
        if (count($all_url) > 0) {
            $content .= "\nUser-agent: *";
            foreach ($all_url as $row) {
                $content .= "\n" . "Disallow: : " . $row->url;
            }
        }

        $robots_actual_url = \Yii::$app->getBasePath(true);
        $robots_actual_url = str_replace("console", "frontend/web", $robots_actual_url);
        $fp = fopen($robots_actual_url . "/robots.txt", "w");
        fwrite($fp, $content);
        fclose($fp);

        //echo "complete sitemap createion";
        $end = microtime(true);
        $executionTime = $end - $start;
        echo "Script execution time: " . $executionTime . " seconds";
    }

    protected function static_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $manual_pages = SitePages::find()->select(['id', 'url', 'created_at'])->where(['status' => true])->andWhere(['content_type' => 'manual_url'])->asArray()->all();

        if (count($manual_pages) > 0) {
            $insert_safari_operator_site_pages = [];

            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
            foreach ($manual_pages as $manual) {
                $url = $manual['url'];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $manual['url'] . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', strtotime($manual['created_at'])) . "</lastmod>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }
            $xml_content .= "</urlset>";

            $fileName = "walkintothewild_pages.xml";
            $myFile = $backend_actual_url . "/" . $fileName;

            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }

        return '';
    }

    protected function get_safari_operator_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $safari_operators = SafariOperator::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'safari_operator', 'status' => true]);
        if (count($safari_operators) > 0) {
            $insert_safari_operator_site_pages = [];

            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
            foreach ($safari_operators as $operator) {
                $url = $base_url . 'operator/' . $operator['slug'];
                $insert_safari_operator_site_pages[] = [
                    'content_id' => $operator['id'],
                    'content_type' => 'safari_operator',
                    'slug' => $operator['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $operator['updated_at']),
                    'counter' => $operator['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $operator['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }
            $xml_content .= "</urlset>";

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_safari_operator_site_pages)->execute();

            $fileName = "safari_operator.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }

        return '';
    }

    protected function get_park_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $parks = SafariPark::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'parks', 'status' => true]);
        if (count($parks) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_parks_site_pages = [];
            foreach ($parks as $park) {
                $url = $base_url . 'park/' . $park['slug'];

                $insert_parks_site_pages[] = [
                    'content_id' => $park['id'],
                    'content_type' => 'parks',
                    'slug' => $park['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $park['updated_at']),
                    'counter' => $park['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $park['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_parks_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "safari_park.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);
            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }

    protected function get_article_tags_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        //fetch article xml pages from article category
        $article_tags = MasterArticleTag::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article_tag', 'status' => true]);
        if (count($article_tags) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_article_tag_site_pages = [];
            foreach ($article_tags as $tag) {
                $url = $base_url . 'article/tag/' . $tag['slug'];

                $insert_article_tag_site_pages[] = [
                    'content_id' => $tag['id'],
                    'content_type' => 'article_tag',
                    'slug' => $tag['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $tag['updated_at']),
                    'counter' => $tag['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $tag['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_tag_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "article_tag.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }

    protected function get_article_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $articles = Article::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article', 'status' => true]);
        if (count($articles) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_article_site_pages = [];
            foreach ($articles as $article) {
                $url = $base_url . 'article/' . $article['slug'];

                $insert_article_site_pages[] = [
                    'content_id' => $article['id'],
                    'content_type' => 'article',
                    'slug' => $article['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $article['updated_at']),
                    'counter' => $article['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $article['updated_at']) . "</lastmod>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "article.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }

    protected function get_article_category_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $articles_category = MasterArticleTopic::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'article_category', 'status' => true]);
        if (count($articles_category) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_article_category_site_pages = [];
            foreach ($articles_category as $category) {
                $url = $base_url . 'article/topic/' . $category['slug'];

                $insert_article_category_site_pages[] = [
                    'content_id' => $category['id'],
                    'content_type' => 'article_category',
                    'slug' => $category['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $category['updated_at']),
                    'counter' => $category['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $category['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_category_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "article_category.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }

    protected function get_shared_safari_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $shared_safari = ShareSafari::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'shared_safari', 'status' => true]);
        if (count($shared_safari) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_article_site_pages = [];
            foreach ($shared_safari as $safari) {
                $url = $base_url . 'sharedsafari/' . $safari['slug'];
                $insert_article_site_pages[] = [
                    'content_id' => $safari['id'],
                    'content_type' => 'shared_safari',
                    'slug' => $safari['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $safari['updated_at']),
                    'counter' => $safari['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $safari['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "shared_safari.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }

    protected function get_author_site_pages($backend_actual_url)
    {
        $base_url = Yii::$app->params['frontend_url'];

        $authors = ArticleAuthor::find()->select(['id', 'slug', 'updated_at', 'total_view'])->where(['status' => true])->asArray()->all();

        SitePages::updateAll(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')], ['content_type' => 'authors', 'status' => true]);
        if (count($authors) > 0) {
            $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
            $xml_content .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $insert_article_site_pages = [];
            foreach ($authors as $author) {
                $url = $base_url . 'article/author/' . $author['slug'];

                $insert_article_site_pages[] = [
                    'content_id' => $author['id'],
                    'content_type' => 'authors',
                    'slug' => $author['slug'],
                    'url' => $url,
                    'last_update_at' => date('Y-m-d H:i:s', $author['updated_at']),
                    'counter' => $author['total_view'],
                ];

                $xml_content .= "<url>";
                $xml_content .= "<loc>" . $url . "</loc>";
                $xml_content .= "<lastmod>" . date('Y-m-d', $author['updated_at']) . "</lastmod>";
                //$xml_content .= "<changefreq>weekly</changefreq>";
                $xml_content .= "<priority>0.9</priority>";
                $xml_content .= "</url>";
            }

            Yii::$app->db->createCommand()->batchInsert('site_pages', ['content_id', 'content_type', 'slug', 'url', 'last_update_at', 'counter'], $insert_article_site_pages)->execute();

            $xml_content .= "</urlset>";
            $fileName = "article_authors.xml";
            $myFile = $backend_actual_url . "/" . $fileName;
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $xml_content);
            fclose($fh);

            return $base_url . "storage/sitemap/" . $fileName;
        }
        return '';
    }
}
