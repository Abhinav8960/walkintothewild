<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */

$this->title = 'Url Shortner';
$this->params['breadcrumbs_home_url'] = '/';
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