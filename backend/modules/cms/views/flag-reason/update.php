<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\cms\flagreason\FlagReason $model */

$this->title = 'Reason';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/cms/flag-reason'];
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