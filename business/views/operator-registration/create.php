<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OperatorForm $model */

$this->title = 'Create User Form';
$this->params['breadcrumbs'][] = ['label' => 'User Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
