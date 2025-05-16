<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Logo';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'change-logo', 'enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'logo')->fileInput() ?>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Cancel', ['view', 'id' => $safari_operator_logo_model->id], ['class' => 'btn btn-danger text-white']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>


        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>