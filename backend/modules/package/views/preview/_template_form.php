<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Template';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'template_code')->dropDownList([1 => '1. Default', 2 => '2. Antara'], ['prompt' => 'Select Template Code']) ?>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Cancel', ['view'], ['class' => 'btn btn-danger text-white']) ?>
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