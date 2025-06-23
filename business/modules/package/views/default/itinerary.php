<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package : ' . $package_version_model->package_name;
$this->params['title'] = $this->title;

?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php if (false) { ?>
    <?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>
<?php } ?>


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
                                        <?php $form = ActiveForm::begin(); ?>


                                        <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $package_version_model->no_of_day])->label(false) ?>
                                        <div class="row">
                                            <div class="col-md-6">
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
                                            <div class="col-md-6">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form_boxes mb-3">
                                                    <label for="">Overview <span>*</span></label>
                                                    <?= $form->field($model, 'day_description')->textarea([
                                                        'rows' => '2',
                                                        'placeholder' => 'Description Detail',
                                                        'id' => 'dayitineraryform-day_description' . $i,
                                                        'class' => 'form-control'
                                                    ])->label(false) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
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

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group float-end">
                                                <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
                                            </div>
                                        </div>
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


        <style>
            .ck-editor__editable {
                min-height: 150px;
            }
        </style>


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