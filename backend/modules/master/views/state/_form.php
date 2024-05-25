<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\state\MasterState $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'country_id')->dropDownList(GeneralModel::countryoption(), ['prompt' => 'Select Country'])->label('Country') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'location_id')->dropDownList(GeneralModel::getAllLocation(), ['prompt' => 'Select Location'])->label('Location') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'state_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter State Name']) ?>
    </div>


    <?php if ($model->state_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>

    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>