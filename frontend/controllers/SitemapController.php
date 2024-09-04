<?php

namespace frontend\controllers;

use common\models\trierror\SitePages;
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
  public function actionIndex()
  {
    $filepath = \Yii::$app->params['datapath'] . "/" . "sitemap/" . "sitemap_index.xml";
    \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    \Yii::$app->response->headers->add('Content-Type', 'text/xml');
    return file_get_contents($filepath);
  }

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
    // Retrieve query parameters if needed
    $otracker = Yii::$app->request->get('otracker', '');

    // Fetch distinct categories and pages from the database
    $categories = SitePages::find()->select('category')->where(['!=', 'category', 'action'])->distinct()->column();

    $categoryPages = [];
    foreach ($categories as $category) {
      $categoryPages[$category] = SitePages::find()->where(['category' => $category, 'status' => 1])->all();
    }

    return $this->render('list', [
      'categories' => $categories,
      'categoryPages' => $categoryPages,
      'otracker' => $otracker,
    ]);
  }
}
