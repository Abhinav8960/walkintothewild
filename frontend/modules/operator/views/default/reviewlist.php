<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
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
<section class="touroprator_section">
    <div class="container-fluid">

        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>

        <div class="row justify-content-center  mb-4">
            <?= $this->render('_free_quote', [
                'model' => $model,
                'operator' => $operator,
            ]) ?>
        </div>

    </div>
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="row pt-5">
                    <div class="col-lg-4 col-md-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">
                        <div class="safri_tour">
                            <div class="titlerescent" style="justify-content:left !important;">
                                <h3 style="text-align:left !important;"><?= $operator->business_name ?></h3>
                            </div>
                            <div class="topics_listing">
                                <?= $this->render('_view_navbar', ['active' => 'reviewlist', 'operator' => $operator]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-xxl-10 col-xl-9 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-12">
                                    <div class="comments_safari operator_comment">
                                        <div class="commentsOther  position-relative">
                                            <div class=" d-flex justify-content-between flex-wrap">

                                                <?php if ($reviews) { ?>
                                                    <div class="userRatingTitle">
                                                        <h6 class="nameRating">Average User Rating</h6>
                                                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                                                            <div class="ratings">
                                                                <?php $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->average('rating');
                                                                if ($avg) { ?>
                                                                    <p class="mb-0">
                                                                        <?= round($avg, 1) ?>
                                                                        <?= GeneralModel::review_rating($avg); ?>
                                                                    </p>
                                                                <?php } ?>
                                                            </div>
                                                            <?php $count = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->count(); {
                                                                if ($count) { ?>
                                                                    <div class="googlerating">
                                                                        <p class="mb-0"><?= $count . " " ?>Reviews</p>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <div class="whiteReview mt-2">
                                                    <?php if (Yii::$app->user->identity) { ?>
                                                        <button class="btn_review writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>">+ Write a Review</button>
                                                    <?php } else { ?>
                                                        <a class="btn_review" href="/site/auth?authclient=google">Please Login to Review</a>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <?php if ($reviews) { ?>
                                                <div class="sort_wrapper py-3">
                                                    <div class="sortBy">Sort by</div>
                                                    <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'newest' || $ratingsearchModel->custom_sort_by == '' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'newest']) ?>">Newest</a>
                                                    <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'highest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'highest']) ?>">Highest</a>
                                                    <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'lowest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'lowest']) ?>">Lowest</a>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <div id="review-list">
                                            <?php
                                            if ($reviews) {
                                                foreach ($reviews as $review) {  ?>
                                                    <div class="commentsOther  position-relative">
                                                        <div class="objec-flgs">
                                                            <?php if (Yii::$app->user->id) {  ?>
                                                                <button class="btn btn-warning writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/reviewupdate', 'operator_id' => $operator->id, 'user_id' => Yii::$app->user->id]) ?>">Edit</button>
                                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/operator/default/flag', 'operator_id' => $operator->id, 'park_id' => $review->park_id, 'safari_operator_rating_id' => $review->id]) ?>">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="postcomment  pt-3">
                                                            <div class="text_com">
                                                                <h6 class="nameavatr"><?= $review->park->title ?></h6>
                                                                <div class="providerNamerating d-flex gap-4 align-items-center pb-2">

                                                                    <div class="ratings">
                                                                        <p class="mb-0">
                                                                            <?php if ($rating_count = $review->rating) {
                                                                                for ($i = 1; $i <= $rating_count; $i++) { ?>
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                <?php }

                                                                                for ($i = $rating_count; $i < 5; $i++) { ?>
                                                                                    <i class='far fa-star'></i>
                                                                            <?php
                                                                                }
                                                                            } ?>
                                                                        </p>
                                                                    </div>

                                                                    <div class="googlerating">
                                                                        <p class="mb-0"> <?= $review->user->name ?></p>
                                                                    </div>
                                                                </div>
                                                                <p><?= $review->review ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } ?>
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



<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              
             
JS;
$this->registerJs($script);
?>