<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Reviews';
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
<section class="touroprator_section bg-white">
    <div class="container-fluid">
        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>
        <div class="row justify-content-center  mb-4">
            <?= $this->render('_free_quote', [
                'model' => $model,
                'operator' => $operator,
            ]) ?>
        </div>
    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'contact', 'operator' => $operator]) ?>
    </div>
</section>
<section class="touroprator_section ">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-xxl-8 col-lg-8">

                                    <?php if (Yii::$app->user->identity) { ?>
                                        <div class="card card_bodyPadding">
                                            <div class="card-body">
                                                <h6 class="fs-6 fw-bold">Address</h6>
                                                <h6 class="mb-0 cmpny_name"><?= $operator->register_comapany_name ?></h6>
                                                <p><?= $operator->address ?></p>
                                                <h6 class="fs-6 fw-bold">Contact Details</h6>
                                                <div class="contaicts d-flex gap-2">
                                                    <strong>Phone :</strong>
                                                    <p> <?= $operator->phone_no ?></p>
                                                </div>
                                                <div class="contaicts d-flex gap-2">
                                                    <strong>Email :</strong>
                                                    <p> <?= $operator->email ?></p>
                                                </div>
                                                <div class="contaicts d-flex gap-2">
                                                    <strong>Website :</strong>
                                                    <p><?= $operator->website ?></p>
                                                </div>
                                                <br>
                                                <?php if ($operator->instagram_url <> '' || $operator->facebook_url <> '' || $operator->youtube_link <> '') { ?>
                                                    <h6 class="fs-6 fw-bold"> Social Media</h6>
                                                    <?php if ($operator->instagram_url <> '') { ?>
                                                        <div class="links_sociels d-flex gap-2">
                                                            <a href="" class="iconSize sizecontact"><i class="fa-brands fa-instagram me-1"></i></a>
                                                            <p>Instragram
                                                                <span><?= $operator->instagram_url ?></span>
                                                            </p>
                                                        </div>
                                                    <?php } ?>


                                                    <?php if ($operator->facebook_url <> '') {  ?>
                                                        <div class="links_sociels d-flex gap-2">
                                                            <a href="" class="iconSize sizecontact"><i class="fa-brands fa-facebook-f me-1"></i></a>
                                                            <p>Facebook
                                                                <span><?= $operator->facebook_url ?></span>
                                                            </p>
                                                        </div>

                                                    <?php } ?>
                                                    <?php if ($operator->youtube_link <> '') { ?>
                                                        <div class="links_sociels d-flex gap-2">
                                                            <a href="" class="iconSize sizecontact"><i class="fa-brands fa-youtube me-1"></i></a>
                                                            <p>Youtube
                                                                <span><?= $operator->youtube_link ?></span>
                                                            </p>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                                <hr>
                                                <div class="viewAllreview">
                                                    <button class="btn btn-info reportBtn" value="<?= Url::toRoute(['/operator/default/report-operator', 'slug' => $operator->slug]) ?>">Report Page</button>
                                                </div>
                                                <!-- <button class="rounded-pill btn btn-dark"></button> -->
                                            </div>
                                        </div>

                                    <?php } else { ?>

                                        <div class="card position-relative" style="min-height: 350px;">
                                            <div class="card-body">
                                                <div class="withoutlogedin">
                                                    <h6 class="fs-6 fw-bold">Contact Details</h6>
                                                    <div class="contaicts d-flex gap-2">
                                                        <strong>Phone :</strong>
                                                        <p class="mb-0"> 98xxxxxxxx</p>
                                                    </div>
                                                    <div class="contaicts d-flex gap-2">
                                                        <strong>Email :</strong>
                                                        <p> xxxxx@gmail.com</p>
                                                    </div>
                                                </div>

                                                <div class="logininfo text-center">
                                                    <h6>Please log in to view the tour <br> operator's contact information.</h6>
                                                    <div class="viewAllreview">
                                                        <a href="/site/auth?authclient=google">Login</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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

<div class="modal fade _standard-text order--modal" id="review-write-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Write a Review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="report-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Report Content
                    <br>
                    <p>Please report inappropriate members and/or content to help our Trust & Safety team keep our Community safe for everyone.</p>
                </h6>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt=""></button>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS


$(document).ready(function() {
    $(".review-button").click(function(){
        var review_url=$(this).attr("value");
        $('.review-button.active').removeClass('active');
        $(this).addClass("active")
        $.get(review_url, function( data ) {
            $("#review-list").html(data);
        });
    })
});
    
function writeareviewfunction() {
	$('.writeAReviewBtn').on('click', function () {
        $('#review-write-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

    $('.flagBtn').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();


function reportfunction() {
	$('.reportBtn').on('click', function () {
        $('#report-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
reportfunction();
              
             
JS;
$this->registerJs($script);
?>