<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Create Gallery';
?>


<?php $form = ActiveForm::begin(['options' => ['id' => 'create-gallery']]); ?>


<div class="row">
    <div class="col-12 mb-4">
        <div class="form_boxes mb-3">
            <label for="">Gallery Title <span>*</span></label>
            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Enter Gallery Title'])->label(false) ?>
        </div>
    </div>
    <div class="col-12 mb-4">
        <div class="form_boxes mb-3">
            <label for="">Park<span>*</span></label>
            <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($safari_operator_model->id), ['prompt' => 'Select', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
    </div>
    <div class="col-12">
        <div class="modalCrateButton">
            <?= Html::submitButton('Save', ['class' => 'btn w-100']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>