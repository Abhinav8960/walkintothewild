<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\compliancedocuments\ComplianceDocuments $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title'])->label('Title <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'policy_for')->dropDownList(['User' => 'User', 'Business' => 'Business'], ['prompt' => 'Select Option', 'id' => 'type-selector'])->label('Policy For <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'effective_from')->textInput(['type' => 'date'])->label('Effective From <span class="necessary">*</span>') ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'description', ['labelOptions' => ['class' => 'Modal_label']])->textarea(['rows' => '6', 'placeholder' => 'Description Detail '])->label('Description <span class="necessary">*</span>') ?>
    </div>

    <?php if ($model->cdocument_model->id) { ?>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoptions(),['prompt' => 'Select Status']) ?>
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
<style>
    .ck-editor__editable {
        min-height: 450px;
    }
</style>
<?php
$script = <<< JS
editor('compliancedocumentsform-description');
JS;
$this->registerJs($script);
?>