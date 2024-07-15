<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Package : ' . $package_model->package_name;
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<section class="banner_section-inner ee position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1><?= $package_model->package_name ?></h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="articals_wrapper py-3 mb-5">
    <div class="container-fluid">
        <div class="row mb-4  justify-content-center mt-4">
            <div class="col-lg-12 col-xl-10 safartabs position-relative">

                <?= $this->render('@frontend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'itinerary_active' => 'active']) ?>
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                        <div class="row pt-4">
                            <div class="col-12 inner_accordion">
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
                                                                        'placeholder' => 'Enter Hotel Name',
                                                                        'id' => 'dayitineraryform-hotel_name' . $i,
                                                                    ]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Latitude']) ?>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Longitude']) ?>
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
</section>
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
        var url = '/package/profile/itinerary/{$package_model->id}/' + dayNumber + '#' + accordionId;

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