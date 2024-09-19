<?php

use yii\helpers\Html;

/** @var yii\web\View $this */


$this->title = 'Tag';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Tag', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/Category'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>