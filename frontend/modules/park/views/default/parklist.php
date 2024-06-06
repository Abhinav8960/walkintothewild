<?php


/* @var $this yii\web\View */

$this->title = 'Park Search Result';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/articlebanner.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/banner-share.png" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 ">
                    <div class="tab-block" id="tab-block">
                        <ul class="tab-mnu">
                            <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="26" class="me-2">Safari</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2">Birding</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2"> Resort</li>
                        </ul>

                        <div class="tab-cont">
                            <div class="tab-pane">
                                <div class="row gx-0">
                                    <?= $this->render('_search', [
                                        'model' => $searchModel,
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="articals_wrapper py-3">
    <div class="container-fluid">
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
            <div class="col-lg-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">

                <?= $this->render('_park_side_search', [
                    'model' => $searchModel,
                ]) ?>
            </div>
            <div class="col-lg-8 col-xxl-10 col-xl-9">
                <div class="topfilter d-md-flex justify-content-between align-items-center w-100">
                    <div class="left_text">
                        <p class="">We found <strong><?= count($models) ?> parks</strong> for you</p>
                    </div>
                    <div class="right-select mb-md-0 mb-4">
                        <div class="input_check pb-0">

                            <select class="form-select mb-2" aria-label="Default select example">
                                <option selected>Sort By: Relevant</option>
                                <option value="1">January</option>
                                <option value="2">Febraury</option>
                                <option value="3">March</option>
                            </select>
                        </div>

                    </div>
                </div>
                <?php if ($models) {
                    foreach ($models as $model) { ?>
                        <a href="/park/<?= $model->slug ?>" class="parking_Box">

                            <div class="searchSafari_wraper mb-4">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="Slider_safariimg3 h-100">
                                            <img src="<?= isset($model->galleryimag) ? $model->galleryimag->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-9">
                                        <div class="safariSearch_wrap">
                                            <div class="safrititles pt-md-0 pt-3">
                                                <h6 class=""><?= $model->title ?></h6>
                                            </div>
                                            <div class="seelctes_text pt-2 pb-4 ">
                                                <p>
                                                    <?= $model->long_description ?>
                                                </p>
                                            </div>
                                            <div class="taglines">
                                                <p>Top Safari Tour Operators</p>
                                            </div>
                                            <div class="touroprators">
                                                <div class="opratios-slider owl-carousel owl-theme">
                                                    <div class="slidesImg">
                                                        <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                                                    </div>
                                                    <div class="slidesImg">
                                                        <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                                    </div>
                                                    <div class="slidesImg">
                                                        <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                                                    </div>
                                                    <div class="slidesImg">
                                                        <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
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
</section>



<section class="safariduring_sesons innerpage">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
</section>