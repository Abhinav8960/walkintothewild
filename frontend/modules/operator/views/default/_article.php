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
        <?= $this->render('_view_navbar', ['active' => 'article', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-xxl-8 col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="fs-5 fw-bold">Article</h6>
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3  gx-xxl-5 gx-lg-4 ">
                                                <?php if ($articles) {
                                                    foreach ($articles as $article) { ?>
                                                        <div class="col mb-5">
                                                            <div class="artical_cards h-100">
                                                                <div class="image-box">
                                                                    <figure class="image"><a href="/article/<?= $article->slug ?>"><img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                                                    </figure>
                                                                </div>
                                                                <div class="lower-content">
                                                                    <ul class="artical-info ">
                                                                        <li><i class="fa-solid fa-user"></i><a href="<?= Url::toRoute(['/article/default/author', 'slug' => $article->articleAuthor ? $article->articleAuthor->slug : '']) ?>"><?= isset($article->articleAuthor) ? $article->articleAuthor->author_name : '' ?></a></li>

                                                                    </ul>
                                                                    <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>"><?= $article->title ?> </a></h3>

                                                                    <div class="artical-info justify-content-center">
                                                                        <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>

                                                                        <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($article->article_date)) ?></span>
                                                                    </div>


                                                                </div>
                                                                <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-lg-4">
                                    <div class="request_quote">
                                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                                            <?php if ($reviews) { ?>
                                                <?php $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->average('rating');
                                                if ($avg) { ?>
                                                    Operator Rating <?= round($avg, 1) ?>
                                                <?php } ?>
                                            <?php } ?></button>
                                        <div class="interst_wrapper pt-1 px-3 bg-white">
                                            <div id="review-list">
                                                <?php
                                                if ($reviews) {
                                                    foreach ($reviews as $review) {  ?>
                                                        <div class="commentsOther2  position-relative">
                                                            <div class="postcomment  pt-3">
                                                                <div class="text_com colors_p">
                                                                    <div class="providerNamerating ">
                                                                        <div class="googlerating names">
                                                                            <h6 class="mb-0 fs-6 pb-0"><?= $review->user->name ?></h6>
                                                                        </div>
                                                                        <div class="ratings colors">
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

                                                                    </div>
                                                                    <p class="suggest"><?= $review->review ?> &nbsp;</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                <?php
                                                    }
                                                } ?>
                                                <!-- <div class="whiteReview m-2">
                                                <?php if (Yii::$app->user->identity) { ?>
                                                    <button class="btn_review writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>">+ Write a Review</button>
                                                <?php } else { ?>
                                                    <a class="btn_review" href="/site/auth?authclient=google">Please Login to Review</a>
                                                <?php } ?>
                                            </div> -->
                                            </div>
                                            <div class="col-12">
                                                <div class="safari text-end">
                                                    <div class="viewAllreview">
                                                        <a href="">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="request_quote mt-4">
                                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                                            Organized Safari <?= count($organized_by); ?></button>
                                        <div class="interst_wrapper pt-3 px-md-5 bg-white">
                                            <div class="row justify-content-center">
                                                <?php if ($organized_by) {
                                                    foreach ($organized_by as $share_safari) {
                                                ?>
                                                        <div class="col-md-12 mb-4 padding_righ">
                                                            <div class="sharesafri-card">
                                                                <div class="flotingdate">
                                                                    <div class="icons text-center">
                                                                        <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                                        <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="shareimg">
                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                                                </div>
                                                                <div class="card_body">
                                                                    <div class="top_seats">
                                                                        <div class="safari d-flex justify-content-between ">
                                                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                                                <p class="text_safari">SAFARI</p>
                                                                                <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>

                                                                            </div>
                                                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                                                <p class="text_safari">SEATS</p>
                                                                                <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="titleDate">
                                                                        <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= $share_safari->park->title ?></a></h6>
                                                                        <div class="orgnizer">
                                                                            <p>Organized by: <strong><?= $share_safari->user->name ?></strong></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                                                        <div class="col-6">
                                                                            <div class="users">
                                                                                <?php if ($interests = $share_safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                                    $count = $share_safari->getIntrested()->count();
                                                                                    $avatar_count = 3;
                                                                                    foreach ($interests as $interest) {
                                                                                ?>
                                                                                        <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                                    <?php
                                                                                    };
                                                                                    $count = $share_safari->getIntrested()->count();
                                                                                    $avatar_count = 3;
                                                                                    $data = $count - $avatar_count;
                                                                                    if ($data > 3) {  ?>
                                                                                        <div class="roundes_countuser">
                                                                                            <?= $data ?>+
                                                                                        </div>
                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="safari text-center">
                                                                                <div class="joinsafari">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-12">
                                                <div class="safari text-end">
                                                    <div class="viewAllreview">
                                                        <a href="">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
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