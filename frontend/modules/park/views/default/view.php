<?php


/* @var $this yii\web\View */

$this->title = 'Safari ' . $model->title;
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
        <div class="row mb-5 pb-4">
            <div class="col-lg-12 safartabs">
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
                'model' => $model,
            ]) ?>
        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
</section>