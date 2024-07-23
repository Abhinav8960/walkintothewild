<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Package : ' . $package_model->package_name;
$this->params['title'] = $this->title;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['package' => $package_model, 'itinerary_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php
                                    $no_of_day = $package_model->no_of_day;
                                    for ($i = 1; $i <= $no_of_day; $i++) { ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $i ?>" aria-expanded="<?= ($i == 1) ? 'true' : 'false'; ?>" aria-controls="flush-collapse<?= $i ?>" data-day="<?= $i ?>" href="#">
                                                    Day <?= $i ?>
                                                </a>
                                            </h2>
                                            <div id="flush-collapse<?= $i ?>" class="accordion-collapse collapse <?= ($i == $model->day) ? 'show' : ''; ?>" aria-labelledby="flush-heading<?= $i ?>" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="wrap_days">
                                                        <div class="card-body">
                                                            <?php $form = ActiveForm::begin(); ?>

                                                            <?= $form->field($model, 'package_id')->hiddenInput(['value' => $package_model->id])->label(false) ?>

                                                            <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $package_model->no_of_day])->label(false) ?>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'day')->textInput([
                                                                        'maxlength' => true,
                                                                        'value' => $i,
                                                                        'placeholder' => 'Enter Day',
                                                                        'id' => 'dayitineraryform-day' . $i,
                                                                    ]) ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'day_title')->textInput([
                                                                        'maxlength' => true,
                                                                        'placeholder' => 'Enter Day Title',
                                                                        'id' => 'dayitineraryform-day_title' . $i,
                                                                    ]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <?= $form->field($model, 'day_description')->textarea([
                                                                        'rows' => '2',
                                                                        'placeholder' => 'Description Detail',
                                                                        'id' => 'dayitineraryform-day_description' . $i,
                                                                    ])->label('Description') ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'start_location')->textInput([
                                                                        'maxlength' => true,
                                                                        'placeholder' => 'Enter Start Location',
                                                                        'id' => 'dayitineraryform-start_location' . $i,
                                                                    ]) ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'end_location')->textInput([
                                                                        'maxlength' => true,
                                                                        'placeholder' => 'Enter End Location',
                                                                        'id' => 'dayitineraryform-end_location' . $i,
                                                                    ]) ?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'hotel_name')->textInput([
                                                                        'maxlength' => true,
                                                                        'placeholder' => 'Enter Accommodation Name',
                                                                        'id' => 'dayitineraryform-hotel_name' . $i,
                                                                    ])->label('Accommodation') ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Latitude'])->label('Accommodation Latitude') ?>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Longitude'])->label('Accommodation Longitude') ?>
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
                                                            <div class="row">
                                                                <?php if ($model->package_day_model->day_image) { ?>
                                                                    <div class="col-md-3">
                                                                        <?= $form->field($model, 'day_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <?= Html::img($model->package_day_model->imagepath, ['width' => '75', 'height' => '75']) ?>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="col-md-3">
                                                                        <?= $form->field($model, 'day_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group float-end">
                                                                        <?= Html::submitButton('Create ', ['class' => 'btn_newsafari font_set w-auto ms-2']) ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php ActiveForm::end(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
editor('dayitineraryform-day_description1');
editor('dayitineraryform-day_description2');
editor('dayitineraryform-day_description3');
editor('dayitineraryform-day_description4');
editor('dayitineraryform-day_description5');
editor('dayitineraryform-day_description6');
editor('dayitineraryform-day_description7');
editor('dayitineraryform-day_description8');
editor('dayitineraryform-day_description9');
editor('dayitineraryform-day_description10');
editor('dayitineraryform-day_description11');
editor('dayitineraryform-day_description12');
editor('dayitineraryform-day_description12');
editor('dayitineraryform-day_description13');
editor('dayitineraryform-day_description14');
editor('dayitineraryform-day_description15');
JS;
$this->registerJs($script);
?>


<?php
$script = <<< JS
$(document).ready(function() {
    // Handle accordion link clicks
    $('.accordion-button').on('click', function(e) {
        e.preventDefault();
        
        var dayNumber = $(this).data('day');
        var accordionId = 'collapse' + dayNumber;
        var url = '/manage/package/itinerary/{$package_model->id}/' + dayNumber + '#' + accordionId;

        // Update URL
        window.history.pushState({ path: url }, '', url);

        // Collapse all accordions
        $('.card-header').attr('aria-expanded', 'false');
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