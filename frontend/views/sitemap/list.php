<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $sitemapData array */

$this->title = 'Sitemap';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Here is the complete sitemap for our website:</p>

    <!-- Directly generate the sitemap HTML -->
    <div class="row">
            <?php foreach ($sitemapData as $category => $subCategories): ?>
                <div class="col-md-4 mb-4">
                    <div class="category h-100">
                        <strong><?= Html::encode($category) ?></strong>
                        <div class="subcategories">
                            <?php foreach ($subCategories as $subCategory => $pages): ?>
                                <div class="subcategory-item">
                                    <a href="<?= Html::encode($pages['url']) ?>">
                                        <strong><?= Html::encode($subCategory) ?></strong>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
   
</div>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
    }

    .container {
        width: 80%;
        margin: 5% auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h1 {
        border-bottom: 2px solid #09422D;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

 

    .category {
        flex: 1 1 200px;
        /* Flexible basis and growth */
        min-width: 200px;
        /* Minimum width of each category */
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .subcategories {
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Gap between subcategory items */
    }

    .subcategory-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 10px;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .subcategory-item a {
        text-decoration: none;
        color: #09422D;
    }

    .subcategory-item a:hover {
        text-decoration: underline;
    }

    .subcategory-item:hover {
        background-color: #e0e0e0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .subcategory-item:focus {
        outline: 2px solid #007bff;
        background-color: #f0f8ff;
    }
</style>