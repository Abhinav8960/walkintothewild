<?php

namespace frontend\controllers;

use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\data\Pagination;
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
    $category = trim($category);
    $subCategory = trim($subCategory);

    if (empty($category) || empty($subCategory)) {
      throw new NotFoundHttpException('Invalid category or sub-category.');
    }

    // Fetch pages for the given category and sub-category
    $query = $this->getPagesBySubCategoryQuery($category, $subCategory);

    // Check if the query returned any results
    if (!$query) {
      throw new NotFoundHttpException('The requested sub-category does not exist.');
    }

    // Set up pagination
    // $count = $query->count();
    // $pagination = new Pagination([
    //   'defaultPageSize' => 10,
    //   'totalCount' => $count,
    // ]);

    // Get the pages for the current page
    $pages = $query->all();


    return $this->render('view', [
      'category' => $category,
      'subCategory' => $subCategory,
      'pages' => $pages,
      // 'pagination' => $pagination,
    ]);
  }

  /**
   * Fetches a query for pages for a specific sub-category from the database.
   *
   * @param string $category
   * @param string $subCategory
   * @return yii\db\Query
   */
  private function getPagesBySubCategoryQuery($category, $subCategory)
  {
    // Create a new Query instance
    return (new Query())
      ->select('*')
      ->from('site_pages')
      ->where([
        'category' => $category,
        'sub_category' => $subCategory,
        'status' => 1
      ])
      ->orderBy(['title' => SORT_ASC]);
  }
}
