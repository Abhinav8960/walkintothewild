<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Safari ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::PARK_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>
<div class="fixedbanner">
    <section class="banner_section-inner ee position-relative">
        <picture class="position-relative">
            <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
            <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
        </picture>
        <div class="banner_searchBox">
            <div class="container-lg">
                <div class="row">
                    <div class="col-12 ">
                        <div class="tab-block" id="tab-block">
                            <ul class="tab-mnu">
                                <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="" class="me-2">Safari</li>
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/birdingicon.png" alt="" width="29" class="me-2">Birding</li>
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/resorticon.png" alt="" width="29" class="me-2"> Resort</li>
                            </ul>

                            <div class="tab-cont">
                                <div class="tab-pane">
                                    <?= $this->render('_advance_search', [
                                        'model' => $searchModel
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<section class="articals_wrapper py-3 margin-setposi">
    <div class="container-fluid">
        <div class="row mb-4  justify-content-center mt-4">
            <div class="col-lg-12 col-xl-10 pb-sm-4 safartabs">
                <div class="safrititles pt-xl-0 pt-3 d-sm-flex justify-content-center align-items-center">
                    <h1 class="titleSafri fs-2 text-center"><?= $model->title ?></h1>
                   
                </div>
            </div>
            <div class="col-lg-12 col-xl-10 safartabs">
                <div class="right_button float-lg-end pb-2 d-lg-block d-flex justify-content-end">
                    <button class="btn-exclamtion pe-1" data-bs-toggle="modal" data-bs-target="#exampleModal3"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M501.362 383.95 320.497 51.474c-29.059-48.921-99.896-48.986-128.994 0L10.647 383.95c-29.706 49.989 6.259 113.291 64.482 113.291h361.736c58.174 0 94.203-63.251 64.497-113.291zM256 437.241c-16.538 0-30-13.462-30-30s13.462-30 30-30 30 13.462 30 30-13.462 30-30 30zm30-120c0 16.538-13.462 30-30 30s-30-13.462-30-30v-150c0-16.538 13.462-30 30-30s30 13.462 30 30v150z" fill="#09422d" opacity="1" data-original="#000000" class=""></path></g></svg></button>
                </div>
                <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">OVERVIEW</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">ABOUT PARK</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">FLORA & FAUNA</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#howto-reach-pan" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">HOW TO REACH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-pane" type="button" role="tab" aria-controls="map-tab-pane" aria-selected="false">MAP</button>
                    </li>
                    <div class="btn_wrap pt-md-0 pt-3">
                        <?php

                        if ($model->official_website) { ?>
                            <a href="<?= $model->official_website ?>" target="_blank" class="intested_btn">OFFICIAL WEBSITE <i class="fa-solid fa-up-right-from-square ms-2"></i></a>
                        <?php } ?>
                    </div>
                </ul>
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <?= $this->render('_overview', [
                            'model' => $model,
                            // 'first_month' => $first_month,
                            // 'last_month' => $last_month,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <?= $this->render('_about', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <?= $this->render('_florafauna', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="howto-reach-pan" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <?= $this->render('_howtoreach', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="map-tab-pane" role="tabpanel" aria-labelledby="map-tab" tabindex="0">
                        <?= $this->render('_map', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <?= $this->render('_operators', [
                'operators' => $operators,
                'model' => $model,
                'operatorsearchModel' => $operatorsearchModel,
                'device' => $device
            ]) ?>
        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Suggest Correction</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'safariform',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'enableClientScript' => true,
                'action' => $suggestionmodel->action_url,
                'validationUrl' => $suggestionmodel->action_validate_url,
            ]); ?>
            <div class="modal-body modal_form">
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-center"><?= $model->title ?></h6>
                    </div>
                    <div class="col-12 mb-2">
                        <label for="" class="Modal_label">Select Category</label>
                        <?= $form->field($suggestionmodel, 'master_suggestion_id')->dropDownList(GeneralModel::suggestioncategory(), ['prompt' => 'Select', 'class' => "form-select form-select-lg ", 'aria-label' => "Large select example"])->label(false) ?>
                    </div>

                    <div class="col-lg-12 mb-2 mt-2">
                        <div class="textarea">
                            <?= $form->field($suggestionmodel, 'details')->textarea(['class' => "form-control", 'placeholder' => "Write about your plan"])->label(false) ?>
                        </div>
                    </div>

                </div>
                <div class="row mt-2 pe-0">
                    <div class="col-lg-8">
                        <label for="" class="Modal_label">You Are?</label>
                        <?= $form->field($suggestionmodel, 'you_are_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Who You Are?', 'class' => "form-select form-select-lg ", 'aria-label' => "Large select example"])->label(false) ?>
                    </div>
                    <div class="col-lg-4">
                        <div class="creat-safri">
                            <?= Html::submitButton('Submit', ['class' => 'safari_create font_set']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>