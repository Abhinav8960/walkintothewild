<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\GeneralModel;

?>

<?php $form = ActiveForm::begin([
    'id' => 'safariform',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]); ?>
<div class="modal-body modal_form">
    <div class="row">
        <div class="col-12">
            <h6 class="text-center"><?= $safari_park->title ?></h6>
        </div>
        <div class="col-12 mb-2">
            <label for="" class="Modal_label">Select Category</label>
            <?= $form->field($model, 'master_suggestion_id')->dropDownList(GeneralModel::suggestioncategory(), ['prompt' => 'Select', 'class' => "form-select form-select-lg ", 'aria-label' => "Large select example"])->label(false) ?>
        </div>

        <div class="col-lg-12 mb-2 mt-2">
            <div class="textarea">
                <?= $form->field($model, 'details')->textarea(['class' => "form-control", 'placeholder' => "Write about your plan"])->label(false) ?>
            </div>
        </div>

    </div>
    <div class="row mt-2 pe-0">
        <div class="col-lg-12">
            <label for="" class="Modal_label">You Are?</label>
            <?= $form->field($model, 'you_are_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Who You Are?', 'class' => "form-select form-select-lg ", 'aria-label' => "Large select example"])->label(false) ?>
        </div>
        <div class="col-6 mt-2">
            <label for="" class="Modal_label">Name</label>
            <?= $form->field($model, 'name')->textinput(['placeholder' => 'Name'])->label(false) ?>
        </div>

        <div class="col-lg-8 mt-2">
            <label for="" class="Modal_label">Phone Number</label>
            <?= $form->field($model, 'phone')->textinput(['placeholder' => 'Phone Number'])->label(false) ?>
        </div>
        <div class="col-6 mt-2">
            <label for="" class="Modal_label">Email</label>
            <?= $form->field($model, 'email')->textinput(['placeholder' => 'Email'])->label(false) ?>
        </div>



        <div class="col-lg-4 mt-2">
            <div class="creat-safri">
                <?= Html::submitButton('Submit', ['class' => 'safari_create font_set']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>