<?php

use common\interfaces\Constants;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name;
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

        <div class="row justify-content-center  mb-4 pt-4">
            <?= $this->render('_free_quote', [
                'model' => $model,
                'operator' => $operator,
            ]) ?>
        </div>

    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'park', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="row">
                            <div class="col-xxl-8 col-lg-8">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->business_name ?> Operates in <span class="numberFont"><?= count($operator_parks) ?></span> Parks</h6>
                                                <a class="SeeAll" href="">See All</a>
                                                <!-- <div class="whiteReview ">
                                                    <button class="follow_btn writeAReviewBtn text-capitlize" value="">View All</button>
                                                </div> -->
                                            </div>

                                            <div class="row">
                                                <?php
                                                if ($operator_parks) {
                                                    foreach ($operator_parks as $operator_park) {
                                                        $park_detail = $operator_park->park;
                                                ?>
                                                        <div class="col-md-6 col-lg-4 gap-2  mb-4">
                                                            <div class="parksImgireview h-100">
                                                                <a href="<?= \yii\helpers\Url::toRoute(['/park/default/view', 'slug' => $park_detail->slug]) ?>">
                                                                    <img src="<?= isset($park_detail->logo) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">

                                                                </a>
                                                                <div class="footer_safariname">
                                                                    <h6 class=""><?= $park_detail->title ?></h6>
                                                                </div>
                                                            </div>

                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-lg-4">
                                <?= $this->render('_operator_rating_sidebar', ['operator' => $operator]) ?>

                                <?= $this->render('_shared_safar_sidebar', ['operator' => $operator]) ?>

                            </div>
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