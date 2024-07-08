<?php

use common\interfaces\Constants;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;


/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>


<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Safari Tour Operator</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                                Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="touroprator_section">
    <div class="container-fluid">


        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>


        <div class="row justify-content-center  mb-4">
            <?= $this->render('_free_quote', [
                'model' => $model,
                'operator' => $operator,
            ]) ?>
        </div>

    </div>
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="row pt-5">
                    <div class="col-lg-4 col-md-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">
                        <div class="safri_tour">
                            <div class="titlerescent" style="justify-content:left !important;">
                                <h3 style="text-align:left !important;"><?= $operator->business_name ?></h3>
                            </div>
                            <div class="topics_listing">
                                <?= $this->render('_view_navbar', ['active' => 'safari', 'operator' => $operator]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-xxl-10 col-xl-9 ">
                        <div class="tab-content_tour active">
                            <?php
                            if ($operator_parks) {
                                foreach ($operator_parks as $operator_park) {
                                    $park_detail = $operator_park->park;
                            ?>
                                    <a href="<?= \yii\helpers\Url::toRoute(['/park/default/view', 'slug' => $park_detail->slug]) ?>">
                                        <div class="searchSafari_parks mb-4">
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="parksImg h-100">
                                                        <img src="<?= isset($park_detail->logo) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 ">
                                                    <div class="parks_body">
                                                        <div class="safrititles pt-md-0 pt-3">
                                                            <h6 class=""><?= $park_detail->title ?></h6>
                                                        </div>
                                                        <div class="seelctes_text pt-2 pb-3 ">
                                                            <p><?= $park_detail->long_description ?></p>
                                                        </div>
                                                        <div class="row ">
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Location">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0"><?= isset($park_detail->state) ? $park_detail->state->state_name . ',' : '' ?> <?= isset($park_detail->location) ? $park_detail->location->title : '' ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vechile">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0">
                                                                            <?php if ($park_detail->vehicles) {
                                                                                $vehicle_name = '';
                                                                                foreach ($park_detail->vehicles as $vehicle) {
                                                                                    if ($vehicle->mastervehicle) {
                                                                                        $vehicle_name .= $vehicle->mastervehicle->vehicle_name . ', ';
                                                                                    }
                                                                                }
                                                                                echo substr($vehicle_name, 0, -2);
                                                                            } ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Railway Station">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0"><?= isset($park_detail->railwaystation) ? $park_detail->railwaystation->title . ' , ' : '' ?><?= isset($park_detail->railwaystationtwo) ? $park_detail->railwaystationtwo->title : '' ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-xl-0 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safari Seasion">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0">
                                                                            <?php if ($park_detail->sessions) {

                                                                                $metasession_title = '';
                                                                                foreach ($park_detail->sessions as $session) {
                                                                                    if ($session->metasession) {
                                                                                        $metasession_title .= $session->metasession->title . ', ';
                                                                                    }
                                                                                }
                                                                                echo substr($metasession_title, 0, -2);
                                                                            } ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-xl-0 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Airport">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0"><?= isset($park_detail->airport) ? $park_detail->airport->name : '' ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-xl-4 col-lg-6 mb-xl-0 mb-3">
                                                                <div class="safridetails_form d-flex gap-3 ">
                                                                    <div class="iconImg">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Animals">
                                                                    </div>
                                                                    <div class="text-form">
                                                                        <p class="mb-0">
                                                                            <?php if ($park_detail->animal_text) {
                                                                                echo $park_detail->animal_text ?>
                                                                            <?php
                                                                            } ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>