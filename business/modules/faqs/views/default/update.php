<?php

use yii\helpers\Html;

$this->title = 'FAQ';
$this->params['breadcrumbs_home_url'] = '/';
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