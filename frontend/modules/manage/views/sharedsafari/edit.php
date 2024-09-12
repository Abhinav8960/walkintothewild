<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'action-form']); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Ignore', '2' => 'Delete'], ['prompt' => 'Select option']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'reason')->textInput() ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12 ">
        <div class="creat-safri d-flex justify-content-end">
            <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <?= Html::submitButton('Save ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>