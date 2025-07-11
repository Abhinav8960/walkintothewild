<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use common\models\partnergallery\PartnerGallery;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package : ' . $package_version_model->package_name;

?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>



<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'itinerary_active' => 'active']) ?>
    <div class="tabs-content-wraps">
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="accordionMianBox">
                <div class="accordionItems">
                    <div class="accordion" id="accordionExample">

                        <?php
                        $no_of_day = $package_version_model->no_of_day;
                        for ($i = 1; $i <= $no_of_day; $i++) { ?>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="heading<?= $i ?>">
                                    <a class="accordion-button day-accordion-link" aria-controls="collapse<?= $i ?>" aria-expanded="<?= ($i == 1) ? 'true' : 'false'; ?>" data-day="<?= $i ?>">Day <?= $i ?></a>
                                </h2>
                                <div aria-labelledby="heading<?= $i ?>" class="collapse <?= ($i == $model->day) ? 'show' : ''; ?>" data-parent="#accordion" id="collapse<?= $i ?>" role="tabpanel">
                                    <div class="accordion-body">
                                        <?php $form = ActiveForm::begin(
                                            [
                                                'id' => 'itinerary-form',
                                                'method' => 'POST',
                                                'fieldConfig' => [
                                                    'template' => '<div class="form-group">{label}{input}{error}</div>',
                                                ],
                                            ]
                                        ); ?>


                                        <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $package_version_model->no_of_day])->label(false) ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form_boxes mb-3">
                                                    <label for="">Day</label>
                                                    <?= $form->field($model, 'day')->textInput([
                                                        'maxlength' => true,
                                                        'value' => $i,
                                                        'placeholder' => 'Enter Day',
                                                        'id' => 'dayitineraryform-day' . $i,
                                                        'readOnly' => true,
                                                        'class' => 'form-control'
                                                    ])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form_boxes mb-3">
                                                    <label for="">Day Title</label>
                                                    <?= $form->field($model, 'day_title')->textInput([
                                                        'maxlength' => true,
                                                        'placeholder' => 'Enter Day Title',
                                                        'id' => 'dayitineraryform-day_title' . $i,
                                                        'class' => 'form-control'

                                                    ])->label(false); ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?php
                                                    if ($model->package_day_model->partner_gallery_id) { ?>
                                                        <div class="row">
                                                            <div class="col-lg-12 ">
                                                                <div class="form_boxes mb-3">
                                                                    <label for="">Gallery
                                                                    </label>
                                                                    <div class="galleryModal d-flex flex-column justify-center align-items-center position-relative" data-url="<?= Url::toRoute(['gallery-popup', 'context' => 'partner_gallery_id_' . $i, 'preview' => 'preview_' . $i]) ?>">

                                                                        <div class="displayImage d-flex flex-column gap-2">
                                                                            <img src="<?= $this->params['baseurl'] ?>/images/Group.png" alt="">
                                                                            <label for="">Attach Gallery</label>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12" style="margin-top:35px;">
                                                                <?php
                                                                $thumbnail_path = PartnerGallery::find()->where(['id' => $model->package_day_model->partner_gallery_id])->limit(1)->one();
                                                                ?>
                                                                <img src="<?= $thumbnail_path->thumbnail ?>" width="200px" height="200px" class="selectImage" id="<?= 'preview_' . $i ?>">
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="row">
                                                            <div class="col-lg-12 ">
                                                                <div class="form_boxes mb-3">
                                                                    <label for="">Gallery
                                                                    </label>
                                                                    <div class="galleryModal d-flex flex-column justify-center align-items-center position-relative" data-url="<?= Url::toRoute(['gallery-popup', 'context' => 'partner_gallery_id_' . $i, 'preview' => 'preview_' . $i]) ?>" data-assignto="<?= 'partner_gallery_id_' . $i ?>">
                                                                        <div class="w-100 h-100 fadeImage">
                                                                            <img src="" class="selectImage" alt="" id="<?= 'preview_' . $i ?>">
                                                                        </div>
                                                                        <div class="displayImage d-flex flex-column gap-2">
                                                                            <img src="<?= $this->params['baseurl'] ?>/images/Group.png" alt="">
                                                                            <label for="">Attach Gallery</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkModal">
                                                                <div class="col-lg-12 fadeImage" style="margin-top:35px;">
                                                                    <img src="" class="selectImage" alt="" id="<?= 'preview_' . $i ?>" style=" width: 100%; height: 100%; object-fit: contain;" ;>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php  } ?>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form_boxes mb-3">
                                                        <label for="">Details <span>*</span></label>
                                                        <?= $form->field($model, 'day_description')->textarea([
                                                            'rows' => '2',
                                                            'placeholder' => 'Description Detail',
                                                            'id' => 'dayitineraryform-day_description' . $i,
                                                            'class' => 'form-control'
                                                        ])->label(false) ?>
                                                    </div>
                                                </div>

                                            </div>




                                            <?php if (false) { ?>
                                                <!-- <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="row">
                                                        <?php if ($model->package_day_model->day_image) { ?>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form_boxes mb-3">
                                                                        <label for="">Package Image (JPEG / JPG
                                                                            / PNG / 250kb)
                                                                            <span>*</span></label>
                                                                        <div class="form-group mt-2">
                                                                            <label for="fileField<?= $i ?>"
                                                                                class="attachment">
                                                                                <div class="row btn-file">
                                                                                    <div
                                                                                        class="btn-file__preview">
                                                                                    </div>
                                                                                    <div
                                                                                        class="btn-file__actions">
                                                                                        <div
                                                                                            class="btn-file__actions__item col-xs-12 text-center rounded-0">
                                                                                            <div
                                                                                                class="btn-file__actions__item--shadow">
                                                                                                <i class="fa fa-plus fa-lg fa-fw"
                                                                                                    aria-hidden="true"></i>
                                                                                                <div
                                                                                                    class="visible-xs-block">
                                                                                                </div>
                                                                                                Select file
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?= $form->field($model, 'day_image')->fileInput(['id' => 'fileField' . $i])->label(false) ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <?= Html::img($model->package_day_model->imagepath, ['width' => '75', 'height' => '75']) ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form_boxes mb-3">
                                                                        <label for="">Package Image (JPEG / JPG
                                                                            / PNG / 250kb)
                                                                            <span>*</span></label>
                                                                        <div class="form-group mt-2">
                                                                            <label for="fileField<?= $i ?>"
                                                                                class="attachment">
                                                                                <div class="row btn-file">
                                                                                    <div
                                                                                        class="btn-file__preview">
                                                                                    </div>
                                                                                    <div
                                                                                        class="btn-file__actions">
                                                                                        <div
                                                                                            class="btn-file__actions__item col-xs-12 text-center rounded-0">
                                                                                            <div
                                                                                                class="btn-file__actions__item--shadow">
                                                                                                <i class="fa fa-plus fa-lg fa-fw"
                                                                                                    aria-hidden="true"></i>
                                                                                                <div
                                                                                                    class="visible-xs-block">
                                                                                                </div>
                                                                                                Select file
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?= $form->field($model, 'day_image')->fileInput(['id' => 'fileField' . $i])->label(false) ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form_boxes mb-3">
                                                                <label for="">Start Location</label>
                                                                <?= $form->field($model, 'start_location')->textInput([
                                                                    'maxlength' => true,
                                                                    'placeholder' => 'Enter',
                                                                    'id' => 'dayitineraryform-start_location' . $i,
                                                                    'class' => 'form-control'
                                                                ])->label(false); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form_boxes mb-3">
                                                                <label for="">End Location</label>
                                                                <?= $form->field($model, 'end_location')->textInput([
                                                                    'maxlength' => true,
                                                                    'placeholder' => 'Enter',
                                                                    'id' => 'dayitineraryform-end_location' . $i,
                                                                    'class' => 'form-control'
                                                                ])->label(false); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form_boxes mb-3">
                                                                <label for="">Accommodation
                                                                    <span>*</span></label>
                                                                <?= $form->field($model, 'hotel_name')->textInput([
                                                                    'maxlength' => true,
                                                                    'placeholder' => 'Enter',
                                                                    'id' => 'dayitineraryform-hotel_name' . $i,
                                                                    'class' => 'form-control'
                                                                ])->label(false) ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form_boxes mb-3">
                                                                <label for="">Accommodation
                                                                    Latitude</label>
                                                                <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'class' => 'form-control'])->label(false) ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form_boxes mb-3">
                                                                <label for="">Accommodation
                                                                    Longitude</label>
                                                                <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'class' => 'form-control'])->label(false) ?>
                                                            </div>
                                                        </div>
                                                        <?php

                                                        $latitude = $model->latitude;
                                                        $longitude = $model->longitude;

                                                        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                                        if (!empty($latitude) && !empty($longitude)) {
                                                        ?>
                                                            <div class="col-md-4">
                                                                <iframe width="200" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                                </iframe>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div> -->
                                            <?php } ?>
                                            <div class="col-lg-12">
                                                <div class="form-group float-end">
                                                    <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?= $form->field($model, 'partner_gallery_id')->hiddenInput(['id' => 'partner_gallery_id_' . $i])->label(false) ?>

                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $script = <<< JS
                            // editor('dayitineraryform-day_description{$i}');
                            JS;
                            $this->registerJs($script);
                            ?>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        var assignment_attr = $(this).attr("data-assignto");
        var partner_gallery_id = $('#'+assignment_attr).val();
        console.log(assignment_attr);
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




<?php
$script = <<< JS
$(document).ready(function() {
    // Handle accordion link clicks
    $('.day-accordion-link').on('click', function(e) {
        e.preventDefault();
        
        var dayNumber = $(this).data('day');
        var accordionId = 'collapse' + dayNumber;
        var url = '/package/default/itinerary?id={$package_version_model->id}&day=' + dayNumber + '#' + accordionId;

        // Update URL
        window.history.pushState({ path: url }, '', url);

        // Collapse all accordions
        $('.accordion-header').attr('aria-expanded', 'false');
        $('.collapse').removeClass('show');

        // Expand the clicked accordion
        $(this).attr('aria-expanded', 'true');
        $('#' + accordionId).addClass('show');

        // Reload the page after URL update
        location.reload();
    });
});
JS;
$this->registerJs($script);
?>


<style>
    .galleryModal h1 {

        color: red;
    }

    .form_boxes .galleryModal {

        /* padding: 35px; */
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