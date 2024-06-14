<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Coming Soon';
$this->params['title'] = $this->title;
?>

<section class="commingsoon position-relative">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="logo_area">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="" width="180">
                </div>
            </div>
        </div>
    </div>
    <picture class="banner_img">
        <source media="(min-width: 991px)" srcset="<?= $this->params['baseurl'] ?>/img/soonbanner.jpg">
        <source media="(min-width: 577px)" srcset="<?= $this->params['baseurl'] ?>/img/tabbanner.jpg">
        <source media="(max-width: 576px)" srcset="<?= $this->params['baseurl'] ?>/img/mobilebanner.jpg">
        <img src="<?= $this->params['baseurl'] ?>/img/soonbanner.jpg" alt="banner">
        <div class="banner_heding">
            <h4 class="title_white h4">One-stop Solution <br> For Safaris In India </h4>
            <h1 class="title_yellow h1">Coming Soon</h1>
        </div>
    </picture>
    <div id="section01" class="demo">
        <a href="javascript:void(0)" id="arrow"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="60" height="60" x="0" y="0" viewBox="0 0 6.35 6.35" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                    <path d="M2.912.532 2.91 5.177l-.87-.868a.265.265 0 0 0-.189-.08.265.265 0 0 0-.183.453L2.99 6.006a.265.265 0 0 0 .375 0l1.322-1.324c.259-.25-.127-.633-.375-.373l-.873.873.002-4.65a.265.265 0 1 0-.529 0z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path>
                </g>
            </svg></a>
    </div>
</section>

<section class="bg_sky " id="section02">
    <div class="container-fluid">
        <div class="row pb-md-5 pb-2 gx-0 px-xl-5 px-0">
            <div class="col-lg-6 mb-5 pb-md-3 pb-3 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br> Safari Tour Operator <br></h6>

                        <div class="btn_r">
                            <a href="/safaritour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3  pb-5 pb-md-3 mb-lg-5">
                <div class="registration_img  position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br> Birding Tour Operator </h6>

                        <div class="btn_r">
                            <a href="/birdingtour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>