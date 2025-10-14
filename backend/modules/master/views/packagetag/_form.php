<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'tag_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Package Tag Name'])->label('Package Tag Name') ?>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Package Tag Color</label>
        <div class="input-group d-flex align-items-center gap-3">
            <?= $form->field($model, 'tag_color', ['template' => '{input}{error}', 'options' => ['class' => 'mb-0 flex-grow-1'],])
                ->textInput([
                    'id' => 'tag_color_input',
                    'class' => 'form-control',
                    'maxlength' => 7,
                    'placeholder' => '#FFFFFF'
                ]) ?>

            <span class="input-group-text p-0">
                <input type="color" id="tag_color_picker" class="form-control form-control-color border-0" style="width: 3rem; height: 2.4rem;">
            </span>
        </div>
    </div>


    <?php if (isset($model->package_tag_model->id) && $model->package_tag_model->id) : ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php endif; ?>

    <hr>
    <div class="col-md-12 mt-3">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
function syncColorInputs() {
    let color = $('#tag_color_input').val();
    $('#tag_color_picker').val(color);
}

// When user picks a color, update text input
$('#tag_color_picker').on('input', function() {
    $('#tag_color_input').val($(this).val());
});

// When user types a color code, update picker box
$('#tag_color_input').on('input', function() {
    $('#tag_color_picker').val($(this).val());
});

syncColorInputs();
JS;
$this->registerJs($js);
?>