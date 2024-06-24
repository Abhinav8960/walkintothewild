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
<section class="banner_section-inner position-relative">
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
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="29" class="me-2">Birding</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="29" class="me-2"> Resort</li>
                        </ul>

                        <div class="tab-cont">
                            <div class="tab-pane">
                                <?= $this->render('_search', [
                                    'model' => $searchModel,
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row mb-4  justify-content-center mt-4">
            <div class="col-lg-12 col-xl-10 safartabs">
                <div class="right_button float-lg-end pb-2 d-lg-block d-flex justify-content-end">
                    <button class="btn-exclamtion" data-bs-toggle="modal" data-bs-target="#exampleModal3"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="m58.353 29.197-5.682-3.051a1.168 1.168 0 0 1-.5-1.551l2.79-5.813a3.178 3.178 0 0 0-3.29-4.532l-6.393.87a1.177 1.177 0 0 1-1.32-.96l-1.141-6.342a3.181 3.181 0 0 0-5.333-1.731l-4.652 4.462a1.184 1.184 0 0 1-1.64 0L26.54 6.087a3.181 3.181 0 0 0-5.333 1.73l-1.14 6.343a1.188 1.188 0 0 1-1.32.96l-6.393-.87a3.198 3.198 0 0 0-3.292 4.533l2.801 5.812a1.181 1.181 0 0 1-.51 1.55l-5.682 3.052a3.184 3.184 0 0 0 0 5.602l5.682 3.052a1.168 1.168 0 0 1 .5 1.55l-2.79 5.813a3.2 3.2 0 0 0 3.29 4.532l6.393-.87a1.177 1.177 0 0 1 1.32.96l1.141 6.342a3.181 3.181 0 0 0 5.333 1.731l4.652-4.462a1.184 1.184 0 0 1 1.64 0l4.652 4.462a3.203 3.203 0 0 0 5.333-1.73l1.14-6.343a1.182 1.182 0 0 1 1.32-.96l6.393.87a3.198 3.198 0 0 0 3.292-4.532L52.16 39.4a1.181 1.181 0 0 1 .51-1.55l5.682-3.052a3.206 3.206 0 0 0 0-5.602zM32.012 45.004a2.516 2.516 0 0 1 0-5.033 2.516 2.516 0 0 1 0 5.033zm3.401-22.09-1.01 13.416a2.41 2.41 0 0 1-4.772.07L28.6 22.854a3.41 3.41 0 0 1 .81-2.671 3.45 3.45 0 0 1 6.002 2.731z" fill="#09422d" opacity="1" data-original="#000000" class=""></path>
                                <path d="M30.921 21.494a1.427 1.427 0 0 0-.33 1.14l1.03 13.546a.406.406 0 0 0 .791-.06l1.02-13.416a1.45 1.45 0 0 0-2.51-1.21zM31.492 42.482a.52.52 0 0 0 1.04 0 .52.52 0 0 0-1.04 0z" fill="#09422d" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg></button>
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
                </ul>
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <?= $this->render('_overview', [
                            'model' => $model,
                            'first_month' => $first_month,
                            'last_month' => $last_month,
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
                'operatorsearchModel' => $operatorsearchModel
            ]) ?>
        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
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
                        <?= $form->field($suggestionmodel, 'you_are_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Safari tour Oprator', 'class' => "form-select form-select-lg ", 'aria-label' => "Large select example"])->label(false) ?>
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