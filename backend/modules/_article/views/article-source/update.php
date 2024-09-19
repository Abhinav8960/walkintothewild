<?php

use yii\helpers\Html;



$this->title = 'Article Source';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Article', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/article/article-source'];
$this->params['breadcrumbs'][] = "Update";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>