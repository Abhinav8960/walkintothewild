<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'module')->textInput(['maxlength' => true, 'placeholder' => 'Enter Module']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'page_id')->dropDownList(GeneralModel::pages(), ['prompt' => 'Select Page']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'type_id')->dropDownList(['1' => 'Flash Message', '2' => 'Heading', '3' => 'Text'], ['prompt' => 'Select Message Type']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Enter Code']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'message')->textarea(['maxlength' => true, 'placeholder' => 'Enter Message']) ?>
    </div>

    <?php if ($model->message_model->id) { ?>
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