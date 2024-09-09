<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $categories array */
/* @var $categoryPages array */
/* @var $otracker string */

$this->title = 'Pages List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Here is the complete pages list for our website:</p>


    <ul>
        <?php foreach ($pages as $page): ?>
            <li>
                <a href="/<?= Html::encode($page['url']) ?>"><?= Html::encode($page['title']) ?></a>
                <p><?= Html::encode($page['description']) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- Pagination controls -->
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]) ?>
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
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 5% !important;
        margin-bottom: 5% !important;
    }

    h1 {
        border-bottom: 2px solid #09422D;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    h2 {
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-bottom: 15px;
        color: #09422D;
    }

    .category-card {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .category-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #333;
    }

    .page-list {
        list-style-type: none;
        padding-left: 0;
    }

    .page-list-item {
        margin-bottom: 8px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    a {
        text-decoration: none;
        color: #09422D;
    }

    a:hover {
        text-decoration: underline !important;
    }

    .breadcrumb {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 4px;
    }
</style>