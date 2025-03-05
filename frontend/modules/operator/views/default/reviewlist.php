<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $operator->register_comapany_name . ' | Reviews';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one(); ?>

<section class="banner_section-inner   packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100    banner_search" alt="banner">
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
        <?= $this->render('_view_navbar', ['active' => 'reviewlist', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section  margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-12">
                <div class="row pt-2">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-xxl-8 col-lg-8 mb-4">
                                    <div class="comments_safari operator_comment bg-white safriComments pt-3">
                                        <div class="commentsOther comments_parks  position-relative ">
                                            <div class=" d-flex justify-content-between flex-wrap">
                                                <?php if ($reviews) { ?>
                                                    <div class="userRatingTitle">
                                                        <h6 class="nameRating">Average User Rating</h6>
                                                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                                                            <div class="ratings">
                                                                <?php $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->average('rating');
                                                                if ($avg) { ?>
                                                                    <p class="mb-0">
                                                                        <?= round($avg, 1) ?>
                                                                        <?= GeneralModel::review_rating($avg); ?>
                                                                    </p>
                                                                <?php } ?>
                                                            </div>
                                                            <?php $count = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id, 'is_deleted' => 0])->andWhere(['parent_id' => 0])->count(); {
                                                                if ($count) { ?>
                                                                    <div class="googlerating">
                                                                        <p class="mb-0"><?= $count . " " ?>Reviews</p>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                <?php } else {  ?>
                                                    <h6 class="nameRating">Nobody has shared any review about <?= $operator->business_name ?></h6>
                                                <?php } ?>


                                                <div class="whiteReview mt-2 ">
                                                    <?php if (Yii::$app->user->identity) { ?>
                                                        <button class="parkrevieBtn  writeAReviewBtn text-capitlize" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>">+ Write a Review</button>
                                                    <?php } else { ?>
                                                        <a class="parkrevieBtn " href="/site/login?authclient=google&referrer=/operator/<?= $operator->slug ?>/reviewlist" data-pjax="0">Please Login to Review</a>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <?php if ($reviews) { ?>
                                                <div class="sort_wrapper py-3">
                                                    <div class="sortBy">Sort by</div>
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'newest' || $ratingsearchModel->custom_sort_by == '' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'newest']) ?>" data-pjax="0">Newest</a>
                                                        <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'highest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'highest']) ?>" data-pjax="0">Highest</a>
                                                        <a class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'lowest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, 'sort_by' => 'lowest']) ?>" data-pjax="0">Lowest</a>
                                                        <?= $this->render('_filter_park', ['model' => $ratingsearchModel, 'operator_id' => $operator->id, 'operator' => $operator]) ?>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <div id="review-list">
                                            <?php
                                            if ($reviews) {
                                                foreach ($reviews as $review) {  ?>
                                                    <div class="commentsOther comments_parks  position-relative">
                                                        <div class="objec-flgs opratorflag">
                                                            <?php if (Yii::$app->user->id) {  ?>
                                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/operator/default/flag', 'operator_id' => $operator->id, 'park_id' => $review->park_id, 'safari_operator_rating_id' => $review->id]) ?>">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="postcomment  pt-3">
                                                            <div class="text_com">
                                                                <h6 class="nameavatr"><a href="<?= Url::toRoute(['/park/default/view', 'slug' => isset($review->park) ? $review->park->slug : '']) ?>"><?= isset($review->park) ? $review->park->title : '' ?></a></h6>
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

                                                                    <?php if ($review->user) { ?>
                                                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $review->user->user_handle]) ?>" data-pjax="0">
                                                                            <p class="mb-0"> <?= $review->user->getName() ?></p>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                                <p><?= $review->review ?> &nbsp;
                                                                    <?php if (Yii::$app->user->id == $review->user_id) { ?>
                                                                        <span class="writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/reviewupdate', 'operator_id' => $operator->id, 'user_id' => Yii::$app->user->id, 'id' => $review->id]) ?>"><i class="fa fa-edit"></i></span>
                                                                    <?php } ?>
                                                                </p><?php
                                                                    $replies = $review->getcommentreply($review->id);
                                                                    if ($replies) { ?>
                                                                    <!-- put reply here -->
                                                                    <div class="comment-reply"><?php
                                                                                                foreach ($replies as $reply) { ?>
                                                                            <div class="blog-comment-text ms-lg-4 ms-2 position-relative w-100 flags_reply" style="border:none;">
                                                                                <div class="d-flex gap-2">
                                                                                    <div class="avatar">
                                                                                        <img src="<?= $reply->user && $reply->user->avatar <> '' ? $reply->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                                                                                    </div>
                                                                                    <div class="font-color">
                                                                                        <span class="comment-author"><?= isset($reply->user) ? $reply->user->getName() : '' ?></span>
                                                                                        <span class="comment-date"><a href=""><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i A", $reply->created_at) ?> </a></span>
                                                                                        <div class="comment-text">
                                                                                            <p><?= $reply->review ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><?php
                                                                                                } ?>
                                                                    </div><?php
                                                                        } else {
                                                                            if (Yii::$app->user->identity && Yii::$app->user->id ==  $operator->user_id) { ?>
                                                                        <button class="reply_btn" onclick="toggleReplyForm(this)" data-target="reply-form-<?= $review->id ?>"> <i class="fa-solid fa-reply me-1"></i>Reply </button>

                                                                        <div class="reply-form ms-lg-4 ms-2" style="display: none;" id="reply-form-<?= $review->id ?>">
                                                                            <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>
                                                                            <div class="mb-3">
                                                                                <?= $form->field($replymodel, 'safari_operator_rating_id')->hiddenInput(['value' => $review->id])->label(false) ?>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <?= $form->field($replymodel, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a reply...', 'class' => 'form-control w-100 reply-comment'])->label(false) ?>
                                                                            </div>
                                                                            <div class="btn-wrapper">
                                                                                <button type="button" class='post-comment post-comment-operator'>Submit</button>
                                                                            </div>
                                                                            <?php ActiveForm::end(); ?>
                                                                        </div><?php
                                                                            }
                                                                        } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } ?>
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
                                            <div class="mb-4 position-relative galssset " id="memberview">
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
                                    <?= $this->render('_shared_safari_sidebar', ['operator' => $operator]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







<div class="modal fade _standard-text order--modal" id="review-write-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
<script>
    function toggleReplyForm(link) {
        var target = link.getAttribute('data-target');
        var replyForm = document.querySelector('#' + target);
        if (replyForm.style.display === "none" || replyForm.style.display === "") {
            replyForm.style.display = "block";
        } else {
            replyForm.style.display = "none";
        }
    }
</script>

<?php
$script = <<< JS

$('.reply-comment').focusout(function(e){
    e.preventDefault();
    return false;
    //$("#reply-form").submit();
});

$('.post-comment-operator').focusout(function(){
    $("#reply-form").submit();
});

$('.toggle-replies').click(function() {
        var target = $(this).data('target');
        var container = $('#' + target);
        var isVisible = container.is(':visible');
        container.slideToggle();
        $(this).text(isVisible ? 'View replies' : 'Hide replies');
    });        
JS;
$this->registerJs($script);
?>