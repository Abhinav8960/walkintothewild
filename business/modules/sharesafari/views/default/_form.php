<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-departure-version-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],
]); ?>

<div class="row">
    <div class="row">
        <div class="col-md-6">
            <div class="form_boxes mb-3">
                <label for="">Title<span>*</span></label>
                <?= $form->field($model, 'share_safari_title')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Title',
                    'class' => 'form-control'
                ])->label(false) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form_boxes mb-3">
                <label for="">Safari Park<span>*</span></label>
                <div class="select2-angle-wrapper position-relative">
                    <?= $form->field($model, 'park_list')->widget(\kartik\select2\Select2::classname(), [
                        'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                        'data' => GeneralModel::operatorsafariparkoption($safari_operator->id),
                        'options' => [
                            'multiple' => true,
                            'autocomplete' => 'off',
                        ],
                        'pluginOptions' => [
                            'placeholder' => 'Open this select menu',

                        ],
                    ])->label(false) ?>
                    <i class="fa fa-angle-down select2-angle-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Cut off Date<span>*</span></label>
                <?= $form->field($model, 'cut_off_date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Start Date<span>*</span></label>
                <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'max' => date('Y-m-d', strtotime('+1 year')), 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">End Date<span>*</span></label>
                <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'max' => date('Y-m-d', strtotime('+1 year')), 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Number of Safaris<span>*</span></label>
                <?= $form->field($model, 'no_of_safari')->textInput(
                    ['type' => 'number', 'min' => 0, 'placeholder' => 'Enter Number of safari', 'class' => 'form-control']
                )
                    ->label(false) ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form_boxes mb-3">
                        <label for="">Theme<span>*</span></label>
                        <?= $form->field($model, 'share_safari_agenda_id')
                            ->dropDownList(['1' => 'Photography', '3' => 'Safari Experience'], ['prompt' => 'Select Theme', 'class' => 'form-control form-select form-select-lg mb-3'])
                            ->label(false) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_boxes mb-3">
                        <label for="">Accommodation<span>*</span></label>
                        <?= $form->field($model, 'stay_category_id')
                            ->dropDownList(GeneralModel::budgetoption(), ['prompt' => 'Select Theme', 'class' => 'form-control form-select form-select-lg mb-3'])
                            ->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="form_boxes mb-3">
                        <label for="">Cost Per Person (INR)<span>*</span></label>
                        <?= $form->field($model, 'cost_per_person')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 1000])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form_boxes mb-3">
                        <label for="">Total Seat<span>*</span></label>
                        <?= $form->field($model, 'total_seat')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Enter Total Seat',
                            'class' => 'form-control'
                        ])->label(false) ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form_boxes mb-3">
                        <label for="">Seats Used<span>*</span></label>
                        <?= $form->field($model, 'share_seat')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Enter Share Seat',
                            'class' => 'form-control'
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 ">
            <div class="form_boxes mb-3">
                <label for="">Plan<span>*</span></label>
                <?= $form->field($model, 'safari_plan')->textarea(['row' => 4, 'placeholder' => 'Write about your plan', 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
    </div>

</div>



<div class="row pt-2">
    <div class="col-12">
        <div class="d-flex gap-3 justify-content-end">
            <?= Html::a('Cancel', ['index'], ['class' => 'button-created', 'style' => 'color:#464A53; border:1px solid #DDDFE1;']) ?>
            <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
        </div>
    </div>
</div>


<?php ActiveForm::end() ?>

<!-- <style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style> -->
<?php
// $script = <<< JS
// editor('createdepartureform-safari_plan');
// JS;
// $this->registerJs($script);
?>

<?php

$script = <<< JS
    $("#createdepartureversionform-cut_off_date").on("change", function(){
        $("#createdepartureversionform-start_date").attr("min", $(this).val());
    });  

    $("#createdepartureversionform-start_date").on("change", function(){
        $("#createdepartureversionform-end_date").attr("min", $(this).val());
    });  

    $("#createdepartureversionform-start_date").on("change", function(){
        var date = (new Date()).toISOString().split('T')[0];
        $("#createdepartureversionform-cut_off_date").attr("min", date);
        $("#createdepartureversionform-cut_off_date").attr("max", $(this).val());
    }); 

    // $("#createdepartureversionform-tour_duration").on("input",function()
    // {
    //     var selectedValue = $(this).val();
    //     $("#tour").html(selectedValue);
    // });

    $("#createdepartureversionform-no_of_safari").on("input",function()
    {
        var selectedValue = $(this).val();
        $("#safariseat").html(selectedValue);
    }); 

JS;
$this->registerJs($script);
?>

<style>
    .select2-angle-wrapper {
        position: relative;
    }

    .select2-angle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #888;
        font-size: 16px;
    }
</style>