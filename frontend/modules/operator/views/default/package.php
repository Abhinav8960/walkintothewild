<?php

use yii\helpers\Url;
use yii\helpers\Html;

use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;

/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Reviews';
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

        <?php if (Yii::$app->user->identity) { ?>
            <div class="row justify-content-center  mb-4">
                <?= $this->render('_free_quote', [
                    'model' => $model,
                    'operator' => $operator,
                ]) ?>
            </div>
        <?php } ?>
    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'package', 'operator' => $operator]) ?>
    </div>


</section>
<section class="touroprator_section margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5 justify-content-center">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row justify-content-center">
                                <div class=" col-xxl-8 col-lg-8">
                                    <div class="card card_bodyPadding">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Created <span class="numberFont"><?= count($operator_packages) ?></span> Packages</h6>
                                                <?php if (count($operator_packages) > 1) { ?>
                                                    <a class="SeeAll" href="<?= Url::toRoute(['/operator/default/packageseeall', 'slug' => $operator->slug]) ?>">See All</a>
                                                <?php } ?>
                                                <!-- <div class="whiteReview ">
                                                    <button class="follow_btn writeAReviewBtn text-capitlize" value="">View All</button>
                                                </div> -->
                                            </div>

                                            <div class="row gx-5 ">
                                                <?php if ($operator_packages) {
                                                    foreach ($operator_packages as $model) { ?>
                                                        <div class="col-md-6 mb-4 padding_righ">
                                                            <div class="sharesafri-card tourpackage">
                                                                <div class="flotingdate">
                                                                    <div class="icons text-center">
                                                                        <p class="mb-0">3N/4D</p>
                                                                    </div>
                                                                </div>
                                                                <div class="floating-watchlist">
                                                                    <?php
                                                                    if (Yii::$app->user->identity) { ?>
                                                                        <div class="heart_bx">
                                                                            <?php
                                                                            $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $model->id, 'item_type_id' => 1, 'status' => 1])->limit(1)->one();
                                                                            if ($wishlist) {
                                                                            ?>
                                                                                <a href="/package/unwishlist/<?= $model->package_slug ?>" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                                            <?php } else { ?>
                                                                                <a href="/package/wishlist/<?= $model->package_slug ?>" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="shareimg">
                                                                    <a href="/package/<?= $model->package_slug ?>">
                                                                        <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt=""></a>
                                                                </div>
                                                                <div class="card_body">
                                                                    <div class="titleDate">
                                                                        <h6 class="pt-1"><a href=""><?= $model->package_name ?> </a></h6>
                                                                        <div class="orgnizer_tour d-flex justify-content-between pt-2">
                                                                            <div class="icons_restro">
                                                                                <i class="fa-solid fa-car-side"></i>
                                                                                <p class="mb-0">5 Safaris</p>
                                                                            </div>
                                                                            <div class="icons_restro">
                                                                                <i class="fa-solid fa-car"></i>
                                                                                <p class="mb-0">Pick & Drop</p>
                                                                            </div>
                                                                            <div class="icons_restro">
                                                                                <i class="fa-solid fa-utensils"></i>
                                                                                <p class="mb-0">Meals</p>
                                                                            </div>
                                                                            <div class="icons_restro">

                                                                                <i class="fa-solid fa-building"></i>
                                                                                <p class="mb-0">Premium</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                                                        <div class="col-7">
                                                                            <div class="safaritourlogo">
                                                                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-5">
                                                                            <div class="safari text-center">
                                                                                <div class="joinsafari package">
                                                                                    <h6 class=" titlePrice"><?= $model->cost_per_person ?> + GST </h6>
                                                                                    <a href="/package/<?= $model->package_slug ?>">View Details</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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