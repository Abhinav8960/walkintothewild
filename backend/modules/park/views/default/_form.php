<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title']) ?>
    </div>

    <?php if ($model->park_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug']) ?>
        </div>
    <?php } ?>

    <div class="col-md-6">
        <?= $form->field($model, 'vehicle_id')->dropDownList(GeneralModel::vehicleoption(), ['prompt' => 'Select Vehicle'])->label('Vehicle') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'avg_safari_price')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'master_animal_id')->dropDownList(GeneralModel::animaloption(), ['prompt' => 'Select Animal'])->label('Animal') ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'sort_description')->textarea() ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
    </div>


    <?php if ($model->park_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'Slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug']) ?>
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