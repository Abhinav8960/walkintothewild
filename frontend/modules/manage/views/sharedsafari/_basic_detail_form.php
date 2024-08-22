<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-departure-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]); ?>

<div class="row">
    <div class="col-12 mb-2">
        <label for="" class="Modal_label">Title</label>
        <?= $form->field($model, 'share_safari_title')->textInput(['placeholder' => 'Enter Title'])->label(false) ?>
    </div>
    <div class="col-md-6 mb-1">
        <label for="" class="Modal_label">Select Park</label>
        <?= $form->field($model, 'park_list')->widget(Select2::class, [
            'data' => GeneralModel::safariparklist(),
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false) ?>
    </div>
    <div class="col-md-6 mb-1">
        <label for="" class="Modal_label">Number of Safaris</label>
        <?= $form->field($model, 'no_of_safari')->textInput(['type' => 'number', 'min' => 0, 'placeholder' => 'Enter Number of safari'])->label(false) ?>
    </div>

    <div class="col-md-6 mb-1">
        <label for="" class="Modal_label">Theme</label>
        <?= $form->field($model, 'share_safari_agenda_id')->dropDownList(['1' => 'Photography', '3' => 'Safari Experience'], ['prompt' => 'Select Agenda', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
    </div>

    <div class="col-md-12">
        <div class="d-flex  gap-sm-3 align-items-center flex-sm-nowrap flex-wrap  w-100 mb-1">
            <div class="start w-100">
                <label for="" class="Modal_label">Start Date</label>
                <?= $form->field($model, 'start_date')->textInput(['type' => 'date'])->label(false) ?>
            </div>
            <span class="pt-sm-4 text-center">-</span>
            <div class="start w-100">
                <label for="" class="Modal_label">End Date</label>
                <?= $form->field($model, 'end_date')->textInput(['type' => 'date'])->label(false) ?>
            </div>
            <div class="start w-100">
                <label for="" class="Modal_label">Cut off Date <span class="necessary">*</span></label>
                <?= $form->field($model, 'cut_off_date')->textInput(['type' => 'date'])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="" class="Modal_label">Stay Category</label>
        <?= $form->field($model, 'stay_category_id')->dropDownList(['1' => ' Budget', '2' => 'Economical', '3' => 'Premium'], ['class' => 'form-select form-select-lg mb-3'])->label(false) ?>
    </div>



    <div class="col-lg-6 mb-2">
        <label for="" class="Modal_label">Cost Per Person (INR)</label>
        <div class="d-flex gap-3 align-items-center">
            <?= $form->field($model, 'cost_per_person')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 1000])->label(false) ?>
        </div>

    </div>
    <div class="col-lg-12 ">
        <div class="textarea">
            <?= $form->field($model, 'safari_plan')->textarea(['row' => 4, 'placeholder' => 'Write about your plan'])->label(false) ?>
        </div>

    </div>

</div>
<div class="row mt-2 pe-0">


    <div class="col-lg-6">
        <div class="selects w-100">
            <label for="" class="Modal_label">Total Seat</label>
            <?= $form->field($model, 'total_seat')->textInput()->label(false) ?>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="selects w-100">
            <label for="" class="Modal_label">Status <span class="necessary">*</span></label>
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::sharesafarioptions(), ['prompt' => 'Status', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
    </div>



    <?= $form->field($model, 'host_type')->hiddenInput()->label(false); ?>
    <div class="col-lg-12 ">
        <div class="creat-safri d-flex justify-content-end">
            <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('createdepartureform-safari_plan');
JS;
$this->registerJs($script);
?>


<?php

$script = <<< JS


          $("#createdepartureform-start_date").on("change", function(){
          $("#createdepartureform-end_date").attr("min", $(this).val());
          $("#createdepartureform-cut_off_date").attr("max", $(this).val());
          });   

          $("#createdepartureform-cut_off_date").on("change", function(){
          $("#createdepartureform-start_date").attr("min", $(this).val());
          });   

          $("#createdepartureform-tour_duration").on("input",function()
          {
            var selectedValue = $(this).val();
            $("#tour").html(selectedValue);
          });

          $("#createdepartureform-no_of_safari").on("input",function()
          {
            var selectedValue = $(this).val();
            $("#safariseat").html(selectedValue);
          }); 
JS;
$this->registerJs($script);
?>