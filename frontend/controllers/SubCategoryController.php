<?php

namespace frontend\controllers;

use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\db\Query;

/**
 * SubCategoryController.
 */
class SubCategoryController extends FrontendBaseController
{
  /**
   * Renders the sub-category page.
   *
   * @param string $category
   * @param string $subCategory
   */
  public function actionView($category, $subCategory)
  {
    // Validate and sanitize inputs
    $category = Html::encode($category);
    $subCategory = Html::encode($subCategory);

    // Fetch pages for the given category and sub-category
    $pages = $this->getPagesBySubCategory($category, $subCategory);

    // Check if pages were found
    if (empty($pages)) {
      throw new NotFoundHttpException('The requested sub-category does not exist.');
    }

    // Render the view and pass data to it
    return $this->render('view', [
      'category' => $category,
      'subCategory' => $subCategory,
      'pages' => $pages,
    ]);
  }

  /**
   * Fetches pages for a specific sub-category from the database.
   *
   * @param string $category
   * @param string $subCategory
   * @return array
   */
  private function getPagesBySubCategory($category, $subCategory)
  {
    // Create a new Query instance
    $query = new Query();

    // Build the query
    $pages = $query->select('*')
      ->from('site_pages')
      ->where([
        'category' => $category,
        'sub_category' => $subCategory,
        'status' => 1
      ])
      ->orderBy(['title' => SORT_ASC])
      ->all();

    return $pages;
  }
}
