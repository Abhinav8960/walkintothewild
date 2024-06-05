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
            <?= $this->render('_park_side_search', [
                'searchModel' => $searchModel,
            ]) ?>
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
                                        <div class="col-xl-3 col-lg-4">
                                            <div class="Slider_safariimg3 h-100">
                                                <img src="<?= isset($model->galleryimag) ? $model->galleryimag->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-xl-9">
                                            <div class="safariSearch_wrap">
                                                <div class="safrititles pt-md-0 pt-3">
                                                    <h6 class=""><?= $model->title ?></h6>
                                                </div>
                                                <div class="seelctes_text pt-2 pb-4 ">
                                                    <p>
                                                        <?= $model->short_description ?>
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
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2>BEST SAFARIS DURING <br>MONSOON SEASON</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="safari-carousel owl-carousel owl-theme">
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Jim Corbett.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">JIM CORBETT</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">JIM CORBETT</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Gir.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Kanha.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarh.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">BANDHAVGARH</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">BANDHAVGARH</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Kaziranga.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">KAZIRANGA</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">KAZIRANGA</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
    </div>
</section>