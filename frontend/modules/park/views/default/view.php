<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;


/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::PARK_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();

if ($model->meta_description != '') {
    $this->params['meta_description'] = $model->meta_description;
}

if ($model->meta_keywords != '') {
    $this->params['meta_keywords'] = $model->meta_keywords;
}
if ($model->meta_title != '') {
    $this->title = $model->meta_title;
} else {
    $this->title = 'Safari ' . $model->title;
}
?>

<section class="banner_section-inner ee position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="tab-block" id="tab-block">
                                <div class="tab-cont">
                                    <div class="tab-pane">
                                        <div class="row gx-0">
                                            <?= $this->render('_advance_search', [
                                                'model' => $searchModel,
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<section class="articals_wrapper py-3 " style="background-color: #fff;">
    <div class="container-fluid">
        <div class="row py-3">
            <div class="col-12">
                <div class="title_heading text-center">
                    <h1 class="fs-2"><?= $model->title ?></h1>
                </div>
            </div>
        </div>
        <div class="row mb-4  justify-content-center mt-4">
            <div class="col-lg-12 col-xl-10 safartabs position-relative">
                <div class="right_button float-lg-end pb-2 d-lg-block d-flex justify-content-end">
                    <button value="<?= Url::toRoute(['/park/default/suggestion', 'park_id' => $model->id]) ?>" class="btn-exclamtion pe-1 writeSuggestionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M507.494 426.066 282.864 53.537a31.372 31.372 0 0 0-53.73 0L4.506 426.066a31.37 31.37 0 0 0 26.864 47.569h449.259a31.372 31.372 0 0 0 26.865-47.569zM256.167 167.227c12.901 0 23.817 7.278 23.817 20.178 0 39.363-4.631 95.929-4.631 135.292 0 10.255-11.247 14.554-19.186 14.554-10.584 0-19.516-4.3-19.516-14.554 0-39.363-4.63-95.929-4.63-135.292 0-12.9 10.584-20.178 24.146-20.178zm.331 243.791c-14.554 0-25.471-11.908-25.471-25.47 0-13.893 10.916-25.47 25.471-25.47 13.562 0 25.14 11.577 25.14 25.47 0 13.562-11.578 25.47-25.14 25.47z" fill="#585757" opacity="1" data-original="#000000" class=""></path></g></svg>
                   
                    </button>

                </div>
                <div id="flashMessage">
                    submit correction if found wrong information!
                </div>
                <ul class="nav nav-tabs d-none d-lg-flex gap-2 align-items-baseline" id="myTab" role="tablist">
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
                    <div class="btn_wrap pt-md-0 pt-3 d-lg-block d-none">
                        <?php

                        if ($model->official_website) { ?>
                            <a href="<?= $model->official_website ?>" target="_blank" class="intested_btn">OFFICIAL WEBSITE </i></a>
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
        <div class="row my-4 justify-content-center" id="safari_tour_operator_container">
            <div class="col-lg-12 col-xl-10">
                <?= $this->render('_operators', [
                    'operators' => $operators,
                    'model' => $model,
                    'operatorsearchModel' => $operatorsearchModel,
                    'shared_safaries' => $shared_safaries,
                    'device' => $device,
                    'reviews' => $reviews
                ]) ?>
            </div>

        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>


<!-- Modal -->
<div class="modal fade" id="suggestion-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Suggest Correction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function writesuggestionfunction() {
	$('.writeSuggestionBtn').on('click', function () {
        $('#suggestion-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writesuggestionfunction();


             
JS;
$this->registerJs($script);
?>