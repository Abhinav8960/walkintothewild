<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Delete';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'delete_reason_id')->dropDownList(GeneralModel::getFlagreasons(), ['prompt' => 'Select Reason'])->label('Reason') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'status')->dropDownList(['-1' => 'Delete'], ['prompt' => 'Select Status Option'])->label('User Status') ?>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Cancel', ['fixed-departure'], ['class' => 'btn btn-danger text-white']) ?>
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