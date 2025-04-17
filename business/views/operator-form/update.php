<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OperatorForm $model */

$this->title = 'Update User Form: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-form-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
