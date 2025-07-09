<?php


use common\models\GeneralModel;
use Google\Api\ResourceDescriptor\Style;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>

<?php $form = ActiveForm::begin([
    'id' => 'package-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row">

    <div class="col-md-6">
        <div class="form_boxes mb-3">
            <label for="">Package Name<span>*</span></label>
            <?= $form->field($model, 'package_name')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter Package Name',
                'class' => 'form-control'
            ])->label(false) ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form_boxes mb-3">
            <label for="">Safari Park<span>*</span></label>
            <div class="select2-angle-wrapper position-relative">
                <?= $form->field($model, 'package_park')->widget(\kartik\select2\Select2::classname(), [
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

    <div class="row row-cols-md-3 row-cols-lg-5">
        <div class="form_boxes mb-3">
            <label for="">Day / Night <span>*</span></label>
            <?= $form->field($model, 'no_of_day')->dropDownList(GeneralModel::packagedayoption(), ['prompt' => 'Open this select menu', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Safari Type<span>*</span></label>
            <?= $form->field($model, 'safari_type')->dropDownList(['1' => 'Shared Safari', '2' => 'Private Safari'], ['prompt' => 'Open this select menu', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Number of Safaris <span>*</span></label>
            <?= $form->field($model, 'no_of_safari')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter Number of Safaris',
            ])->label(false) ?>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Vehicle <span>*</span></label>
            <?= $form->field($model, 'master_vehicle_id')->dropDownList(GeneralModel::vehicleoption(), ['prompt' => 'Open this select menu', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Theme <span>*</span></label>
            <?= $form->field($model, 'package_agenda_id')->dropDownList(['1' => 'Photography', '3' => 'Safari Experience'], ['prompt' => 'Open this select menu', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
    </div>

    <div class="row row-cols-md-3 row-cols-lg-4">
        <div class="form_boxes mb-3">
            <label for="">Tour Start Place </label>
            <?= $form->field($model, 'start_location')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter Start Location',
                'class' => 'form-control'
            ])->label(false) ?>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Tour End Place</label>
            <?= $form->field($model, 'end_location')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter End Location',
                'class' => 'form-control'
            ])->label(false) ?>
        </div>
        <!-- <div class="form_boxes mb-3">
            <label for="">Start Date <span>*</span></label>
            <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'class' => 'form-control'])->label(false) ?>
        </div> -->
        <!-- <div class="form_boxes mb-3">
            <label for="">End Date <span>*</span></label>
            <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label(false) ?>
        </div> -->

    </div>


    <div class="row row-cols-md-3 row-cols-lg-4">
        <div class="form_boxes mb-3">
            <label for="">Stay Category<span>*</span></label>
            <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packagemetastaycategory(), ['prompt' => 'Open this select menu', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
        <div class="form_boxes mb-3 position-relative">
            <label for="">Package Feature <span>*</span></label>
            <div class="select2-angle-wrapper position-relative">
                <?= $form->field($model, 'package_feature')->widget(\kartik\select2\Select2::classname(), [
                    'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                    'data' => GeneralModel::packagefeatureoption(),
                    'options' => [
                        'multiple' => true,
                        'autocomplete' => 'off',
                        'class' => 'form-select form-select-lg mb-3',
                    ],
                    'pluginOptions' => [
                        'placeholder' => 'Open this select menu',
                    ],
                ])->label(false) ?>
                <i class="fa fa-angle-down select2-angle-icon"></i>
            </div>
        </div>
        <div class="form_boxes mb-3">
            <label for="">Cost Per Person <span>*</span></label>
            <?= $form->field($model, 'cost_per_person')->textInput([
                'maxlength' => true,
                'placeholder' => 'Enter',
                'class' => 'form-control'
            ])->label(false) ?>
        </div>

        <div class="form_boxes mb-3">
            <label for="">Validity Date</label>
            <?= $form->field($model, 'max_booking_date')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'class' => 'form-control'])->label(false) ?>
        </div>

    </div>



    <div class="row">
        <?php
        if ($model->package_version_model->package_image) { ?>
            <div class="col-lg-3 ">
                <div class="form_boxes mb-3">
                    <label for="">Package DP (JPEG / JPG / PNG / 250kb)
                    </label>
                    <div class="form-group mt-2">
                        <label for="fileField" class="attachment">
                            <div class="row btn-file">
                                <div class="btn-file__preview"></div>
                                <div class="btn-file__actions">
                                    <div
                                        class="btn-file__actions__item col-xs-12 text-center" style="height:200px;">
                                        <div class="btn-file__actions__item--shadow" style="margin-top:40px;">
                                            <i class="fa fa-plus fa-lg fa-fw"
                                                aria-hidden="true"></i>
                                            <div class="visible-xs-block"></div>
                                            Select file
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $form->field($model, 'package_image')->fileInput(['id' => "fileField"])->label(false) ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" style="margin-top:35px;">
                <?php echo '<img src="' . $model->package_version_model->imagepath . '" width="200px" height="200px"></img>'; ?>
            </div>
        <?php } else { ?>
            <div class="col-lg-3">
                <div class="form_boxes mb-3">
                    <label for="">Package DP (JPEG / JPG / PNG / 250kb)
                    </label>
                    <div class="form-group mt-2">
                        <label for="fileField1" class="attachment">
                            <div class="row btn-file">
                                <div class="btn-file__preview"></div>
                                <div class="btn-file__actions">
                                    <div
                                        class="btn-file__actions__item col-xs-12 text-center" style="height:200px;">
                                        <div class="btn-file__actions__item--shadow" style="margin-top:40px;">
                                            <i class="fa fa-plus fa-lg fa-fw"
                                                aria-hidden="true"></i>
                                            <div class="visible-xs-block"></div>
                                            Select file
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $form->field($model, 'package_image')->fileInput(['id' => "fileField1"])->label(false) ?>
                        </label>
                    </div>
                </div>
            </div>
        <?php  } ?>

         <div class="col-lg-9">
            <div class="form_boxes mt-2">
                <label for="">Overview</label>
                <?= $form->field($model, 'package_description')->textarea(['rows' => '1', 'placeholder' => 'Overview Detail ', 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>

    </div>




    <!-- <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'type')->dropDownList(['0' => 'Exclusion', '1' => 'Inclusion'], ['prompt' => 'Select']) ?>
    </div> -->


    <!-- <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'gst_percentage')->textInput([
            'placeholder' => 'GST (%)',
        ]) ?>
    </div> -->


    <div class="row">
        <!-- <div class="col-lg-6">
            <div class="form_boxes mb-3">
                <label for="">Overview <span>*</span></label>
                <?= $form->field($model, 'package_itinerary_overview')->textarea(['rows' => '1', 'placeholder' => 'Itinerary Detail', 'class' => 'form-control'])->label(false) ?>

            </div>
        </div> -->
       
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

<?php ActiveForm::end(); ?>


<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('packageversionform-package_description');
editor('packageversionform-package_itinerary_overview');
JS;
$this->registerJs($script);
?>


<?php
$gst_script = <<< JS
    // $(function() {
    //     $('.field-packageversionform-gst_percentage').hide();
    //     var gst_type =$("#packageversionform-type").val();
            
    //     if(gst_type == 1){
    //         $('.field-packageversionform-gst_percentage').show();
    //     }
       
    //     $('#packageversionform-type').on('change', function() {
    //         var selectValue = $(this).val();
    //         if (selectValue == 1) {
    //             $('.field-packageversionform-gst_percentage').show();
    //         } else {
    //             $('.field-packageversionform-gst_percentage').hide();
    //         }
    //     });
    // });
JS;
$this->registerJs($gst_script);
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