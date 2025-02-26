<?php

use yii\helpers\Url;
use yii\helpers\Html;

use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;

/* @var $this yii\web\View */

$this->title = $operator->register_comapany_name . ' | Reviews';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>


<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
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
    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'package', 'operator' => $operator]) ?>
    </div>


</section>
<section class="touroprator_section margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-xxl-9 col-lg-12">
                <div class="row pt-5 justify-content-center">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row justify-content-center">
                                <div class=" col-xxl-8 col-lg-8 mb-4">
                                    <div class="card card_bodyPadding">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-wrap mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Created <span class="numberFont"><?= $operator->packagecount ?></span> Packages</h6>
                                                <?php if (count($operator_packages) > 4) { ?>
                                                    <a class="SeeAll mt-sm-0 mt-3" href="<?= Url::toRoute(['/operator/default/packageseeall', 'slug' => $operator->slug]) ?>" data-pjax="0">See All</a>
                                                <?php } ?>
                                                <!-- <div class="whiteReview ">
                                                    <button class="follow_btn writeAReviewBtn text-capitlize" value="">View All</button>
                                                </div> -->
                                            </div>

                                            <div class="row gx-xxl-5  ">
                                                <?php if ($operator_packages) {
                                                    foreach ($operator_packages as $modell) { ?>
                                                        <div class="col-md-6 mb-4 padding_righ">
                                                            <?= $this->render('@frontend/modules/package/views/default/_package_card', ['model' => $modell]) ?>
                                                        </div>
                                                <?php }
                                                } else {
                                                    echo '<p class="noData">No Package Found!</p>';
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-4">
                                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) { ?>

                                        <div class="mb-4" id="memberview">
                                            <?= $this->render('_free_quote', [
                                                'model' => $model,
                                                'operator' => $operator,
                                                'disabled' => false,
                                            ]) ?>
                                        </div>
                                    <?php } else {  ?>

                                        <div class="galssset mb-4" id="memberview">
                                            <svg class="form-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path fill="#02690e" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                                            </svg>
                                            <?= $this->render('_free_quote', [
                                                'model' => $model,
                                                'operator' => $operator,
                                                'disabled' => true,
                                            ]) ?>
                                        </div>
                                    <?php }   ?>
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

JS;
$this->registerJs($script);
?>