<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Package : ' . $package_version_model->package_name;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'itinerary_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div aria-multiselectable="true" class="accordion" id="accordion" role="tablist">
                    <?php
                    $no_of_day = $package_version_model->no_of_day;
                    for ($i = 1; $i <= $no_of_day; $i++) { ?>
                        <div class="card mb-0">
                            <div class="card-header" id="heading<?= $i ?>" role="tab">
                                <a class="day-accordion-link" aria-controls="collapse<?= $i ?>" aria-expanded="<?= ($i == 1) ? 'true' : 'false'; ?>" data-day="<?= $i ?>" href="#" style="text-decoration:none;">Day <?= $i ?></a>
                            </div>
                            <div aria-labelledby="heading<?= $i ?>" class="collapse <?= ($i == $model->day) ? 'show' : ''; ?>" data-parent="#accordion" id="collapse<?= $i ?>" role="tabpanel">
                                <div class="card-body">
                                    <?php $form = ActiveForm::begin(); ?>

                                    <?= $form->field($model, 'package_id')->hiddenInput(['value' => $package_version_model->id])->label(false) ?>

                                    <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $package_version_model->no_of_day])->label(false) ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?= $form->field($model, 'day')->textInput([
                                                'maxlength' => true,
                                                'value' => $i,
                                                'placeholder' => 'Enter Day',
                                                'id' => 'dayitineraryform-day' . $i,
                                            ])->label('DAY'); ?>
                                        </div>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'day_title')->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Enter Day Title',
                                                'id' => 'dayitineraryform-day_title' . $i,
                                            ])->label('DAY TITLE'); ?>
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
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'start_location')->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Enter',
                                                'id' => 'dayitineraryform-start_location' . $i,
                                            ])->label('START LOCATION'); ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'end_location')->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Enter',
                                                'id' => 'dayitineraryform-end_location' . $i,
                                            ])->label('END LOCATION'); ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'hotel_name')->textInput([
                                                'maxlength' => true,
                                                'placeholder' => 'Enter',
                                                'id' => 'dayitineraryform-hotel_name' . $i,
                                            ])->label('ACCOMODATION') ?>
                                        </div>

                                        <div class="col-md-2">
                                            <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('ACCOMODATION LATITUDE') ?>
                                        </div>

                                        <div class="col-md-2">
                                            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('ACCOMODATION LONGITUDE') ?>
                                        </div>
                                        <?php

                                        $latitude = $model->latitude;
                                        $longitude = $model->longitude;

                                        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                        if (!empty($latitude) && !empty($longitude)) {
                                        ?>
                                            <div class="col-md-4">

                                                <iframe width="500" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                </iframe>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <?php if ($model->package_day_model->day_image) { ?>
                                            <div class="col-md-4">
                                                <?= $form->field($model, 'day_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                            </div>
                                            <div class="col-md-1">
                                                <?= Html::img($model->package_day_model->imagepath, ['width' => '75', 'height' => '75']) ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-4">
                                                <?= $form->field($model, 'day_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $script = <<< JS
                            editor('dayitineraryform-day_description{$i}');
                            JS;
                        $this->registerJs($script);
                        ?>
                    <?php } ?>
                </div>
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
        var url = '/packageapproval/default/itinerary?id={$package_version_model->id}&day=' + dayNumber + '#' + accordionId;

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