<?php

namespace frontend\controllers;

use common\models\trierror\SitePages;
use PDO;
use Yii;
use yii\web\Response;

/**
 * DefaultController.
 */
class SitemapController extends FrontendBaseController
{
  /**
   * Renders the index view for the module
   * @return string
   */
  // public function actionIndex()
  // {
  //   $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "sitemap_index.xml";
  //   \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
  //   \Yii::$app->response->headers->add('Content-Type', 'text/xml');
  //   return file_get_contents($filepath);
  // }

  public function actionArticle()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "article.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionArticle_category()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "article_category.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionAuthors()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "authors.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionPark()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "park.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionSafari_operator()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "safari_operator.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionShared_safari()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "shared_safari.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionWalkintothewild_pages()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "walkintothewild_pages.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

  public function actionArticle_tag()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "article_tag.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }




  /**
   * Renders the HTML sitemap.
   */
  public function actionList()
  {
    // Fetch pages from the database
    $pages = $this->getPages();

    // Organize data into categories and sub-categories
    $sitemapData = $this->organizePages($pages);

    // Render the HTML and return it
    return $this->render('list', [
      'sitemapData' => $sitemapData,
    ]);
  }
  /**
   * Fetches pages from the database.
   *
   * @return array
   */
  private function getPages()
  {
    // Create a command instance
    $command = Yii::$app->db->createCommand('
    SELECT * 
    FROM site_pages 
    WHERE status = :status 
    AND category != "Action"
    ORDER BY category, sub_category, title
');
    // Bind parameters
    $command->bindValue(':status', 1);

    // Execute the command and fetch results
    $pages = $command->queryAll();

    return $pages;
  }

  /**
   * Organizes pages into a hierarchical structure.
   *
   * @param array $pages
   * @return array
   */
  private function organizePages($pages)
  {
    $sitemapData = [];

    foreach ($pages as $page) {
      $category = $page['category'];
      $subCategory = $page['sub_category'];
      $title = $page['title'];
      $url = $page['url'];

      // Create categories if they don't exist
      if (!isset($sitemapData[$category])) {
        $sitemapData[$category] = [];
      }

      // Create sub-categories if they don't exist
      if (!isset($sitemapData[$category][$subCategory])) {
        // Create a URL for the sub-category page
        $subCategoryUrl = '/sub-category/' . urlencode($category) . '/' . urlencode($subCategory);
        $sitemapData[$category][$subCategory] = [
          'url' => $subCategoryUrl,
          'pages' => []
        ];
      }

      // Add the page to the appropriate sub-category
      $sitemapData[$category][$subCategory]['pages'][] = ['title' => $title, 'url' => $url];
    }

    return $sitemapData;
  }


  /**
   * Renders the sitemap as HTML.
   *
   * @param array $sitemapData
   * @return string
   */
  private function renderSitemap($sitemapData)
  {
    $html = '<ul>';

    foreach ($sitemapData as $category => $subCategories) {
      $html .= '<li><strong>' . htmlspecialchars($category) . '</strong><ul>';

      foreach ($subCategories as $subCategory => $data) {
        $html .= '<li><a href="' . htmlspecialchars($data['url']) . '"><strong>' . htmlspecialchars($subCategory) . '</strong></a><ul>';


        $html .= '</ul></li>';
      }

      $html .= '</ul></li>';
    }

    $html .= '</ul>';

    return $html;
  }
}
