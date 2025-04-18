<?php

use yii\helpers\Html;



$this->title = 'Create Fixed Departure';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Fixed Departure', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/sharesafari'];
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