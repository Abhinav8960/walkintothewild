<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\models\partnergallery\PartnerGallery;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

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
                <label for="">Park<span>*</span></label>
                <div class="select2-angle-wrapper position-relative">
                    <?= $form->field($model, 'park_list')->widget(\kartik\select2\Select2::classname(), [
                        'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                        'data' => GeneralModel::operatorsafariparkoption($safari_operator->id),
                        'options' => [
                            'multiple' => true,
                            'autocomplete' => 'off',
                        ],
                        'pluginOptions' => [
                            'placeholder' => 'Select',

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
                        <label for="">Shared Seats<span>*</span></label>
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
        <div class="col-md-6">
            <div class="row">
                <?php
                if ($model->shared_safari_departure_version_model->partner_gallery_id) { ?>
                    <div class="col-lg-6 ">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form_boxes mb-3">
                                    <label for="">Gallery</label>
                                    <div class="galleryModal d-flex flex-column justify-center align-items-center position-relative" data-url="<?= Url::toRoute(['gallery-popup', 'context' => 'partner_gallery_id', 'preview' => 'preview']) ?>">

                                        <div class="displayImage d-flex flex-column gap-2">
                                            <img src="<?= $this->params['baseurl'] ?>/images/Group.png" alt="">
                                            <label for="">Attach Gallery</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top:35px;">
                                <?php
                                $thumbnail_path = PartnerGallery::find()->where(['id' => $model->shared_safari_departure_version_model->partner_gallery_id])->limit(1)->one(); ?>
                                <img src="<?= isset($thumbnail_path->thumbnail) ? $thumbnail_path->thumbnail : ''  ?>" width="200px" height="200px" class="selectImage" id="preview">
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-6 ">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form_boxes mb-3">
                                    <label for="">Gallery
                                    </label>
                                    <div class="galleryModal d-flex flex-column justify-center align-items-center position-relative" data-url="<?= Url::toRoute(['gallery-popup', 'context' => 'partner_gallery_id', 'preview' => 'preview']) ?>">

                                        <div class="displayImage d-flex flex-column gap-2">
                                            <img src="<?= $this->params['baseurl'] ?>/images/Group.png" alt="">
                                            <label for="">Attach Gallery</label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="checkModal">
                                <div class="col-lg-12 fadeImage" style="margin-top:35px;">
                                    <img src="" class="selectImage" alt="" id="preview" style=" width: 100%; height: 100%; object-fit: contain;" ;>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php  } ?>
                <?php
                if ($model->shared_safari_departure_version_model->image_filepath) { ?>
                    <div class="col-lg-6 ">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form_boxes mb-3">
                                    <label for="">Image (JPEG / JPG / PNG / 250kb)
                                    </label>
                                    <div class="form-group mt-2">
                                        <label for="fileField" class="attachment">
                                            <div class="row btn-file">
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
                                            <?= $form->field($model, 'image')->fileInput(['id' => "fileField"])->label(false) ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="external-preview mt-2">
                                <?php echo '<img src="' . $model->shared_safari_departure_version_model->sharedimagepath . '" width="200px" height="200px" id="imagePreviewBottom"></img>'; ?>
                                <img id="imagePreviewBottom" src="#" alt="Image Preview" style="display:none; max-height: 200px; border: 1px solid #ccc;" />
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="form_boxes mb-3">
                                    <label for="">Image (JPEG / JPG / PNG / 250kb)</label>
                                    <div class="form-group mt-2">
                                        <label for="fileField1" class="attachment">
                                            <div class="row btn-file">
                                                <div class="btn-file__actions">
                                                    <div class="btn-file__actions__item col-xs-12 text-center" style="height:200px;">
                                                        <div class="btn-file__actions__item--shadow" style="margin-top:40px;">
                                                            <i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>
                                                            <div class="visible-xs-block"></div>
                                                            Select file
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= $form->field($model, 'image')->fileInput(['id' => "fileField1"])->label(false) ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="external-preview mt-2">
                                    <img id="imagePreviewBottom" src="#" alt="Image Preview" style="display:none; max-height: 200px; border: 1px solid #ccc;" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php  } ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form_boxes mt-2">
                <label for="">Plan<span>*</span></label>
                <?= $form->field($model, 'safari_plan')->textarea(['row' => 4, 'placeholder' => 'Write about your plan', 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
    </div>

</div>

<?= $form->field($model, 'partner_gallery_id')->hiddenInput(['id' => 'partner_gallery_id'])->label(false) ?>


<div class="row pt-2">
    <div class="col-12">
        <div class="d-flex gap-3 justify-content-end">
            <?= Html::a('Cancel', ['index'], ['class' => 'button-created', 'style' => 'color:#464A53; border:1px solid #DDDFE1;']) ?>
            <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
        </div>
    </div>
</div>


<?php ActiveForm::end() ?>

<div class="modal fade _standard-text" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header justify-content-space-between">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Gallery</h1>
                <button type="button" class="btn" style="background-color:#152f1b; color:#fff;" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">OK</span>
                </button>

            </div>
            <div class="modal-body px-2 pt-0">
                <div id='gallerymodalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

function galleryfunction() {
	  $('.galleryModal').on('click', function () {
        var url = $(this).data('url');
        var partner_gallery_id = $('#partner_gallery_id').val();
        var queryparams = "";
        if(partner_gallery_id != ''){
        queryparams = "&partner_gallery_id="+partner_gallery_id;
        }
        $('#gallery-modal').modal('show')
            .find('#gallerymodalContent')
            .load(url+''+queryparams);
    });
}
galleryfunction();
JS;
$this->registerJs($script);
?>

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

    .galleryModal h1 {

        color: red;
    }

    .form_boxes .galleryModal {

        padding: 35px;
        font-size: 1.5em;
        color: #d3e0e9;
        cursor: pointer;
        border: 2px dashed #d3e0e9 !important;
        height: 200px;
        border-radius: 15px;
        margin-top: 10px;
    }

    .galleryModal img {

        margin: auto;
        width: 30px;
        object-fit: cover;
    }

    .galleryModal .selectImage {

        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .displayImage {

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .fadeImage {
        display: none;
    }
</style>