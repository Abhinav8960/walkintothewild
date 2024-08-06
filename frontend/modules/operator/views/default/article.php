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
<section class="touroprator_section  margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5">
                    <div class="col-md-12">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card_bodyPadding">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Published <span class="numberFont"><?= count($articles) ?></span> Article</h6>
                                                <?php if (count($articles) > 1) { ?>
                                                    <a class="SeeAll" href="<?= Url::toRoute(['/operator/default/article', 'slug' => $operator->slug]) ?>">See All</a>
                                                <?php } ?>
                                            </div>

                                            <div class="row">
                                                <?php if ($articles) {
                                                    foreach ($articles as $article) { ?>
                                                        <div class="col-md-6 mb-5">
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