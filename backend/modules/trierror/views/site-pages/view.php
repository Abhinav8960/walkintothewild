<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\state\MasterState $model */

$this->title = 'Site Pages Tags';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/trierror/site-pages'];
$this->params['breadcrumbs'][] = "Update";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('_seoform', [
            'model' => $model,
        ]) ?>
    </div>
</div>