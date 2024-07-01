<?php


/* @var $this yii\web\View */

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::HOME;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>


<section class="banner_section main_homebanner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBannerhome-min.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBannerhome-min.png' ?>" class="d-block w-100" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner pb-1">
                        <h1>All Wildlife Safari Info, Multiple Operators, One Convenient Spot!</h1>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    <div class="tab-block" id="tab-block">
                        <ul class="tab-mnu">
                            <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="" class="me-2">Safari</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/birdingicon.png" alt="" width="29" class="me-2">Birding</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resorticon.png" alt="" width="29" class="me-2"> Resort</li>
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

    </div>
</section>

<section class="sharesafri">
    <div class="container-lg ">
        <div class="row justify-content-center">
            <div class="col-xl-11 px-md-1 px-0">
                <div class="sharesafribg home px-lg-0 px-2">
                    <div class="safarishareBox py-3">
                        <div class="row justify-content-center">
                            <div class="col-xxl-8 col-lg-12 col-xl-8">
                                <div class="title_safari text-center pt-3">
                                    <h4>Discover and Join 100+ Shared Safaris</h4>
                                    <!-- <div class="joinshare">
                  <a href="" class="btn_share">JOIN SHARED SAFARI</a>
                </div> -->
                                </div>
                            </div>

                        </div>
                        <div class="row pt-4 justify-content-center gx-5">
                            <div class="col-lg-4  col-xxl-3 col-md-5 mb-4 px-lg-3 ">
                                <div class="sharesafri-card">
                                    <div class="flotingdate">
                                        <div class="icons text-center">
                                            <p class="mb-0">OCT</p>
                                            <p class="mb-0">3</p>
                                        </div>
                                    </div>
                                    <div class="shareimg">
                                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                    </div>
                                    <div class="card_body">
                                        <div class="top_seats">
                                            <div class="safari d-flex justify-content-between ">
                                                <div class="safarinum d-flex gap-2 align-items-center ">
                                                    <p class="text_safari">SAFARI</p>
                                                    <h6 class="number-safari">5</h6>
                                                </div>
                                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                    <p class="text_safari">SEATS</p>
                                                    <h6 class="number-safari">5</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="titleDate">
                                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                            <div class="orgnizer">
                                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                            </div>
                                        </div>
                                        <div class="footer_card row pb-2 px-2 align-items-center">
                                            <div class="col-6">
                                                <div class="users">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <div class="roundes_countuser">
                                                        15+
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="safari text-center">
                                                    <div class="joinsafari">
                                                        <a href="/sharesafari">Join Safari</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4  col-xxl-3 col-md-5 mb-4 px-lg-3">
                                <div class="sharesafri-card">
                                    <div class="flotingdate">
                                        <div class="icons text-center">
                                            <p class="mb-0">OCT</p>
                                            <p class="mb-0">3</p>
                                        </div>
                                    </div>
                                    <div class="shareimg">
                                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                    </div>
                                    <div class="card_body">
                                        <div class="top_seats">
                                            <div class="safari d-flex justify-content-between ">
                                                <div class="safarinum d-flex gap-2 align-items-center ">
                                                    <p class="text_safari">SAFARI</p>
                                                    <h6 class="number-safari">5</h6>
                                                </div>
                                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                    <p class="text_safari">SEATS</p>
                                                    <h6 class="number-safari">5</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="titleDate">
                                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                            <div class="orgnizer">
                                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                            </div>
                                        </div>
                                        <div class="footer_card row pb-2 px-2 align-items-center">
                                            <div class="col-6">
                                                <div class="users">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <div class="roundes_countuser">
                                                        15+
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="safari text-center">
                                                    <div class="joinsafari">
                                                        <a href="/sharesafari">Join Safari</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</section>
<section class="safariduring_sesons">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>
<section class="animal-wrapper pb-4">
    <?= $this->render('_rare_exotic', [
        'rare_exotics' => $rare_exotics,
    ]) ?>
</section>
<section class="bg_sky">
    <div class="container-fluid">
        <div class="row px-xl-4">
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Safari Tour Operator</h6>

                        <div class="btn_r">
                            <a href="/safaritour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img  position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Birding Tour Operator</h6>

                        <div class="btn_r">
                            <a href="/birdingtour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="articals_wrapper  pb-5 mb-5">
    <?= $this->render('_featured_article', [
        'featured_articles' => $featured_articles,
    ]) ?>
</section>