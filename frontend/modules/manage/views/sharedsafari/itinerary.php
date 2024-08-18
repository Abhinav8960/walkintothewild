<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';
$this->params['title'] = $this->title;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4">
            <h6 class="fs-3 fw-bold "><?= $this->title ?></h6>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8  itenary_tabs">
            <div class="card account-settingside safartabs">
                <div class="card-body p-4">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['sharedsafari' => $shared_safari_departure_model, 'itinerary_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12  Modal_form">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php
                                    $no_of_day = $shared_safari_departure_model->tour_duration;
                                    for ($i = 1; $i <= $no_of_day; $i++) { ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <a class="accordion-button" href="<?= Url::toRoute(['/manage/sharedsafari/itinerary', 'slug' => $shared_safari_departure_model->slug, 'day' => $i]) ?>">
                                                    Day <?= $i ?>
                                                </a>
                                            </h2>


                                            <div id="flush-collapse<?= $i ?>" class="accordion-collapse collapse <?= ($i == $model->day) ? 'show' : ''; ?>" aria-labelledby="flush-heading<?= $i ?>" data-bs-parent="#accordionFlushExample">
                                                <?php if ($i == $model->day) { ?>
                                                    <div class="accordion-body p-0">
                                                        <div class="wrap_days">
                                                            <div class="card-body">
                                                                <?php $form = ActiveForm::begin(); ?>

                                                                <?= $form->field($model, 'share_safari_id')->hiddenInput(['value' => $shared_safari_departure_model->id])->label(false) ?>

                                                                <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $shared_safari_departure_model->tour_duration])->label(false) ?>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <?= $form->field($model, 'day')->textInput([
                                                                            'maxlength' => true,
                                                                            'value' => $i,
                                                                            'placeholder' => 'Enter Day',
                                                                            'id' => 'dayitineraryform-day' . $i,
                                                                        ])->label('Day', ['class' => 'Modal_label']) ?>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <?= $form->field($model, 'day_title')->textInput([
                                                                            'maxlength' => true,
                                                                            'placeholder' => 'Enter Day Title',
                                                                            'id' => 'dayitineraryform-day_title' . $i,
                                                                        ])->label('Day Title', ['class' => 'Modal_label']) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <?= $form->field($model, 'day_description')->textarea([
                                                                            'rows' => '2',
                                                                            'placeholder' => 'Description Detail',
                                                                            'id' => 'dayitineraryform-day_description' . $i,
                                                                        ])->label('Description', ['class' => 'Modal_label']) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
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
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="creat-safri d-flex justify-content-end ">
                                                                            <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php ActiveForm::end(); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $script = <<< JS
                                                        editor('dayitineraryform-day_description{$i}');
                                                        JS;
                                                   // $this->registerJs($script);
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
            </div>
        </div>
    </div>
</div>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>