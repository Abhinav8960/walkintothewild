<?php

use common\interfaces\Constants;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title =  $operator->register_comapany_name;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>


<section class="banner_section-inner  packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search   banner_search" alt="banner">
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
<section class="touroprator_section bg-white">
    <div class="container-fluid">
        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>

        <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) { ?>
            <div class="row justify-content-center  mb-4">
                <div class="col-lg-12 col-xxl-7 col-xl-10" id="memberview">
                    <?= $this->render('_free_quote', [
                        'model' => $model,
                        'operator' => $operator,
                        'disabled' => false,
                    ]) ?>
                </div>
            </div>
        <?php } else {  ?>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-12 col-xxl-7 col-xl-10 position-relative galssset " id="memberview">
                    <svg class="form-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="#02690e" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                    </svg>
                    <?= $this->render('_free_quote', [
                        'model' => $model,
                        'operator' => $operator,
                        'disabled' => true,
                    ]) ?>
                </div>
            </div>
        <?php }   ?>

    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'park', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-xxl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="row">
                            <div class="col-xxl-8 col-lg-8 mb-4">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="d-flex justify-content-between flex-wrap mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Operates in <span class="numberFont"><?= $count_operator_parks ?></span> Parks</h6>
                                                <?php if (count($operator_parks) > 4) { ?>
                                                    <a class="SeeAll mt-md-0 mt-3" href="<?= Url::toRoute(['/operator/default/parkseeall', 'slug' => $operator->slug]) ?>" data-pjax="0">See All</a>
                                                <?php } ?>
                                                <!-- <div class="whiteReview ">
                                                    <button class="follow_btn writeAReviewBtn text-capitlize" value="">View All</button>
                                                </div> -->
                                            </div>

                                            <div class="row">
                                                <?php
                                                if ($operator_parks) {
                                                    foreach ($operator_parks as $operator_park) {
                                                        $park_detail = $operator_park->park;
                                                        if ($park_detail) {
                                                ?>
                                                            <div class="col-md-4 col-lg-6 col-xxl-4 col-sm-6 gap-2  mb-4">
                                                                <div class="parksImgireview h-100">
                                                                    <a href="<?= \yii\helpers\Url::toRoute(['/park/default/view', 'slug' =>  $park_detail->slug]) ?>" data-pjax="0">
                                                                        <img src="<?= isset($park_detail->logo) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">

                                                                    </a>
                                                                    <div class="footer_safariname">
                                                                        <h6 class=""><?= $park_detail->title ?></h6>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                <?php }
                                                    }
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-lg-4">
                                <?= $this->render('_operator_rating_sidebar', ['operator' => $operator]) ?>
                                <?= $this->render('_shared_safari_sidebar', ['operator' => $operator]) ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>