<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Fixed Departure : ' . $shared_safari_departure_model->share_safari_title . '';
$this->params['title'] = $this->title;
?>


<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['shared_safari_departure_model' => $shared_safari_departure_model, 'itinerary_active' => 'active']) ?>

    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="accordionMianBox">
            <div class="accordionItems">
                <div class="accordion" id="accordionExample">
                    <?php
                    $no_of_day = $shared_safari_departure_model->tour_duration;
                    for ($i = 1; $i <= $no_of_day; $i++) { ?>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="heading<?= $i ?>">
                                <a class="accordion-button day-accordion-link" aria-controls="collapse<?= $i ?>" aria-expanded="<?= ($i == 1) ? 'true' : 'false'; ?>" data-day="<?= $i ?>">Day <?= $i ?></a>
                            </h2>

                            <div aria-labelledby="heading<?= $i ?>" class=" collapse <?= ($i == $model->day) ? 'show' : ''; ?>" data-parent="#accordion" id="collapse<?= $i ?>" role="tabpanel">
                                <?php if ($i == $model->day) { ?>
                                    <div class="accordion-body">

                                        <?php $form = ActiveForm::begin(); ?>

                                        <?= $form->field($model, 'share_safari_id')->hiddenInput(['value' => $shared_safari_departure_model->id])->label(false) ?>

                                        <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $shared_safari_departure_model->tour_duration])->label(false) ?>
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


                                            <?php if (false) { ?>
                                                <div class="row" style='display: none;'>
                                                    <div class="col-md-4 mb-3">
                                                        <?= $form->field($model, 'start_location')->textInput([
                                                            'maxlength' => true,
                                                            'placeholder' => 'Enter Start Location',
                                                            'id' => 'dayitineraryform-start_location' . $i,
                                                        ])->label('Start Location', ['class' => 'Modal_label']) ?>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <?= $form->field($model, 'end_location')->textInput([
                                                            'maxlength' => true,
                                                            'placeholder' => 'Enter End Location',
                                                            'id' => 'dayitineraryform-end_location' . $i,
                                                        ])->label('End Location', ['class' => 'Modal_label']) ?>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <?= $form->field($model, 'hotel_name')->textInput([
                                                            'maxlength' => true,
                                                            'placeholder' => 'Enter Accommodation Name',
                                                            'id' => 'dayitineraryform-hotel_name' . $i,
                                                        ])->label('Accommodation', ['class' => 'Modal_label']) ?>
                                                    </div>
                                                </div>
                                                <div class="row" style='display: none;'>
                                                    <div class="col-md-6 mb-3">
                                                        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Latitude'])->label('Accommodation Latitude', ['class' => 'Modal_label']) ?>
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Longitude'])->label('Accommodation Longitude', ['class' => 'Modal_label']) ?>
                                                    </div>
                                                    <?php

                                                    $latitude = $model->latitude;
                                                    $longitude = $model->longitude;

                                                    $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                                    if (!empty($latitude) && !empty($longitude)) {
                                                    ?>
                                                        <div class="col-md-4 mt-2">

                                                            <iframe width="400" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="row" style='display: none;'>
                                                    <?php if ($model->share_safari_day_model->day_image) { ?>
                                                        <div class="col-md-6">
                                                            <?= $form->field($model, 'day_image')->fileInput()->label('Day Image (JPEG / JPG / PNG / 940px * 430px / 250kb)', ['class' => 'Modal_label']) ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?= Html::img($model->share_safari_day_model->imagepath, ['width' => '75', 'height' => '75']) ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-md-5">
                                                            <?= $form->field($model, 'day_image')->fileInput()->label('Share Safari Image (JPEG / JPG / PNG / 940px * 430px / 250kb)', ['class' => 'Modal_label']) ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>

                                            <div class="col-lg-12">
                                                <div class="form-group float-end">
                                                    <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
                                                </div>
                                            </div>
                                        </div>


                                        <?php ActiveForm::end(); ?>

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
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ck-editor__editable {
        min-height: 350px;
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
        var url = '/sharesafari/default/itinerary?id={$shared_safari_departure_model->id}&day=' + dayNumber + '#' + accordionId;

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