<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */

$this->title = 'Category Name';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/cms/faqcategory'];
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