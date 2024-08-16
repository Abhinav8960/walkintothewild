<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Package : ' . $package_model->package_name;
$this->params['title'] = $this->title;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
            <div class="d-flex justify-content-between">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2 " target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
            </div>
        </div>
        <div class="col-md-3 col-xl-2 col-xxl-2 mb-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-9 col-xl-10 col-xxl-10">
            <div class="card account-settingside itenary_tabs">
                <div class="card-body p-4 safartabs">
                    <div class="row">
                        <div class="col-12">
                            <?= $this->render('_profile_navbar', ['package' => $package_model, 'itinerary_active' => 'active']) ?>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php
                                    $no_of_day = $package_model->no_of_day;
                                    for ($i = 1; $i <= $no_of_day; $i++) { ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <a class="accordion-button" href="<?= Url::toRoute(['/manage/package/itinerary', 'package_id' => $package_model->id, 'day' => $i]) ?>">
                                                    Day <?= $i ?>
                                                </a>
                                            </h2>
                                            <div id="flush-collapse<?= $i ?>" class="accordion-collapse collapse <?= ($i == $model->day) ? 'show' : ''; ?>" aria-labelledby="flush-heading<?= $i ?>" data-bs-parent="#accordionFlushExample">
                                                <?php if ($i == $model->day) { ?>
                                                    <div class="accordion-body Modal_form">
                                                        <div class="wrap_days">
                                                            <div class="card-body">
                                                                <?php $form = ActiveForm::begin(); ?>

                                                                <?= $form->field($model, 'package_id',)->hiddenInput(['value' => $package_model->id])->label(false) ?>

                                                                <?= $form->field($model, 'no_of_day')->hiddenInput(['value' => $package_model->no_of_day])->label(false) ?>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <?= $form->field($model, 'day', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput([
                                                                            'maxlength' => true,
                                                                            'value' => $i,
                                                                            'placeholder' => 'Enter Day',
                                                                            'id' => 'dayitineraryform-day' . $i,
                                                                        ]) ?>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <?= $form->field($model, 'day_title', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput([
                                                                            'maxlength' => true,
                                                                            'placeholder' => 'Enter Day Title',
                                                                            'id' => 'dayitineraryform-day_title' . $i,
                                                                        ]) ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <?= $form->field($model, 'day_description', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textarea([
                                                                            'rows' => '2',
                                                                            'placeholder' => 'Description Detail',
                                                                            'id' => 'dayitineraryform-day_description' . $i,
                                                                        ])->label('Description') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 mb-4">
                                                                        <?= $form->field($model, 'start_location', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput([
                                                                            'maxlength' => true,
                                                                            'placeholder' => 'Enter Start Location',
                                                                            'id' => 'dayitineraryform-start_location' . $i,
                                                                        ]) ?>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <?= $form->field($model, 'end_location', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput([
                                                                            'maxlength' => true,
                                                                            'placeholder' => 'Enter End Location',
                                                                            'id' => 'dayitineraryform-end_location' . $i,
                                                                        ]) ?>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <?= $form->field($model, 'hotel_name', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput([
                                                                            'maxlength' => true,
                                                                            'placeholder' => 'Enter Accommodation Name',
                                                                            'id' => 'dayitineraryform-hotel_name' . $i,
                                                                        ])->label('Accommodation') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 mb-4">
                                                                        <?= $form->field($model, 'latitude', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Latitude'])->label('Accommodation Latitude') ?>
                                                                    </div>

                                                                    <div class="col-md-4 mb-4">
                                                                        <?= $form->field($model, 'longitude', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->textInput(['maxlength' => true, 'placeholder' => 'Enter Accommodation Longitude'])->label('Accommodation Longitude') ?>
                                                                    </div>
                                                                    <?php

                                                                    $latitude = $model->latitude;
                                                                    $longitude = $model->longitude;

                                                                    $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                                                    if (!empty($latitude) && !empty($longitude)) {
                                                                    ?>
                                                                        <div class="col-md-4 mb-4">

                                                                            <iframe width="400" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                                            </iframe>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="row">
                                                                    <?php if ($model->package_day_model->day_image) { ?>
                                                                        <div class="col-md-5">
                                                                            <?= $form->field($model, 'day_image', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <?= Html::img($model->package_day_model->imagepath, ['width' => '75', 'height' => '75']) ?>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div class="col-md-5">
                                                                            <?= $form->field($model, 'day_image', [
                                                                            'labelOptions' => ['class' => 'Modal_label']
                                                                        ])->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="creat-safri float-end w-auto">
                                                                            <?= Html::submitButton('Create ', ['class' => 'safari_create font_set ']) ?>
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
            </div>
        </div>
    </div>
</div>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>