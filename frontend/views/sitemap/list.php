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
    <ul>
        <?php foreach ($sitemapData as $category => $subCategories): ?>
            <li>
                <strong><?= Html::encode($category) ?></strong>
                <ul class="styled-list">
                    <?php foreach ($subCategories as $subCategory => $pages): ?>
                        <li>
                            <a href="<?= Html::encode($pages['url']) ?>">

                                <strong><?= Html::encode($subCategory) ?></strong>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
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

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    li {
        margin-bottom: 10px;
    }

    a {
        text-decoration: none;
        color: #09422D;
    }

    a:hover {
        text-decoration: underline;
    }



    /* Reset default margin and padding for ul */
    ul {
        margin: 0;
        padding: 0;
        list-style: none;
        /* Remove default bullet points */
    }

    /* Style for the ul with class 'styled-list' */
    .styled-list {
        background-color: #f8f8f8;
        /* Light background color */
        border: 1px solid #ddd;
        /* Light border */
        border-radius: 5px;
        /* Rounded corners */
        width: 300px;
        /* Set a specific width */
        max-width: 100%;
        /* Responsive width */
        padding: 10px;
        /* Padding inside the list */
    }

    /* Style for each li element */
    .styled-list li {
        padding: 10px;
        /* Padding inside each list item */
        margin-bottom: 5px;
        /* Space between list items */
        background-color: #fff;
        /* White background for items */
        border: 1px solid #ddd;
        /* Border around each item */
        border-radius: 3px;
        /* Slightly rounded corners for items */
        transition: background-color 0.3s, box-shadow 0.3s;
        /* Smooth transitions for hover effects */
    }

    /* Hover effect for list items */
    .styled-list li:hover {
        background-color: #e0e0e0;
        /* Slightly darker background on hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
    }

    /* Optional: Add a focus effect for accessibility */
    .styled-list li:focus {
        outline: 2px solid #007bff;
        /* Blue outline for focused items */
        background-color: #f0f8ff;
        /* Light blue background on focus */
    }
</style>