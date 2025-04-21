<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OperatorRegistrationForm $model */

$this->title = 'Thank You';
$this->params['breadcrumbs'][] = ['label' => 'User Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-view text-center">
    <br>
    <br>


    <h1 style="color: green; font-weight: bold;">Thank You</h1>

    <p style="font-size: 18px; margin-top: 20px;">
        Your form has been successfully submitted.
    </p>

    <p>
        <?= Html::a('Submit Another Form', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update Form', ['update', 'id' => $operator_model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>