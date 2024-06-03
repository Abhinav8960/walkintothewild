<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'version')->textInput(['maxlength' => true, 'placeholder' => 'Enter Version']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'commit_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter Commit Number']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'date')->input('date') ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'migration')->textarea() ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
    </div>
    <?php if ($model->phase_model->id) { ?>
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