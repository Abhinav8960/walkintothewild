<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimal $model */

$this->title = 'Animal';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/master/animal'];
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