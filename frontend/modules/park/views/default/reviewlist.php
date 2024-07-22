<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\park\SafariParkRating;

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
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1><?= $model->title ?></h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="articals_wrapper py-3 ">
    <div class="container-fluid">
        <div class="row mb-4  justify-content-center mt-4">
            <div class="col-lg-12 col-xl-10 safartabs position-relative">
                <div class="right_button float-lg-end pb-2 d-lg-block d-flex justify-content-end">
                    <button value="<?= Url::toRoute(['/park/default/suggestion', 'park_id' => $model->id]) ?>" class="btn-exclamtion pe-1 writeSuggestionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal3"><svg xmlns="http://www.w3.org/2000/svg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="submit correction if found wrong information!" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="30" x="0" y="0" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M501.449 368.914 320.566 66.207C306.751 43.384 282.728 29.569 256 29.569s-50.752 13.815-64.567 36.638L10.55 368.914c-13.812 23.725-14.113 51.954-.599 75.678 13.513 23.723 37.836 37.838 65.165 37.838h361.766c27.329 0 51.653-14.115 65.165-37.838 13.516-23.724 13.215-51.953-.598-75.678z" style="" fill="#f9d600" data-original="#e50027" opacity="1" class=""></path>
                                <path d="M502.049 444.592c-13.513 23.723-37.836 37.838-65.165 37.838H256V29.57c26.727 0 50.752 13.815 64.567 36.638L501.45 368.915c13.812 23.724 14.113 51.953.599 75.677z" style="" fill="#f9d600" data-original="#c1001f" class="" opacity="1"></path>
                                <path d="M75.109 452.4c-16.628 0-30.851-8.27-39.063-22.669-8.211-14.414-8.065-31.087.469-45.72L217.23 81.549c8.27-13.666 22.816-21.951 38.769-21.951s30.5 8.284 38.887 22.157l180.745 302.49c8.388 14.4 8.534 31.072.322 45.485-8.211 14.4-22.435 22.669-39.063 22.669H75.109v.001z" style="" fill="#f9d600" data-original="#fd003a" class="" opacity="1"></path>
                                <path d="M436.891 452.4c16.628 0 30.851-8.27 39.063-22.669 8.211-14.414 8.065-31.087-.322-45.485L294.886 81.754c-8.388-13.871-22.933-22.157-38.887-22.157V452.4h180.892z" style="" fill="#f9d600" data-original="#e50027" opacity="1" class=""></path>
                                <path d="M286.03 152.095v120.122c0 16.517-13.514 30.03-30.03 30.03s-30.031-13.514-30.031-30.03V152.095c0-16.517 13.514-30.031 30.031-30.031s30.03 13.514 30.03 30.031z" style="" fill="#09422d" data-original="#e1e4fb" class="" opacity="1"></path>
                                <path d="M286.03 152.095v120.122c0 16.517-13.514 30.03-30.03 30.03V122.064c16.516 0 30.03 13.514 30.03 30.031z" style="" fill="#09422d" data-original="#c5c9f7" class="" opacity="1"></path>
                                <path d="M256 332.278c-24.926 0-45.046 20.119-45.046 45.046 0 24.924 20.119 45.046 45.046 45.046s45.046-20.121 45.046-45.046c0-24.926-20.121-45.046-45.046-45.046z" style="" fill="#09422d" data-original="#e1e4fb" class="" opacity="1"></path>
                                <path d="M301.046 377.323c0 24.924-20.119 45.046-45.046 45.046v-90.091c24.925 0 45.046 20.12 45.046 45.045z" style="" fill="#09422d" data-original="#c5c9f7" class="" opacity="1"></path>
                            </g>
                        </svg>
                    </button>

                </div>
                <div id="flashMessage">
                    submit correction if found wrong information!
                </div>
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
        <div class="row my-4 justify-content-center" id="safari_tour_operator_container">
            <div class="col-lg-12 col-xl-10">
                <div class="row pt-5">
                    <div class="col-lg-12 col-md-11 col-xxl-12 col-xl-10 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-12 mb-4 mt-5">
                                    <div class="comments_safari operator_comment">
                                        <div class="commentsOther  position-relative">
                                            <div class=" d-flex justify-content-between flex-wrap">
                                                <?php
                                                if ($reviews) { ?>
                                                    <div class="userRatingTitle">
                                                        <h6 class="nameRating">Average User Rating</h6>
                                                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                                                            <div class="ratings">
                                                                <?php $avg = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $model->id])->average('rating');
                                                                if ($avg) { ?>
                                                                    <p class="mb-0">
                                                                        <?= round($avg, 1) ?>
                                                                        <?= GeneralModel::review_rating($avg); ?>
                                                                    </p>
                                                                <?php } ?>
                                                            </div>
                                                            <?php $count = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $model->id])->count(); {
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
                                                        <button value="<?= Url::toRoute(['/park/default/review', 'park_id' => $model->id]) ?>" class="btn_newsafari writeSuggestionBtn " data-bs-toggle="modal" data-bs-target="#exampleModal3">Write Review</button>
                                                    <?php } else { ?>
                                                        <a class="btn_review" href="/site/auth?authclient=google">Please Login to Review</a>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <?php if ($reviews) { ?>
                                                <div class="sort_wrapper py-3">
                                                    <div class="sortBy">Sort by</div>
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <a class="review-button btn_sort <?= $searchModel->custom_sort_by == 'newest' || $searchModel->custom_sort_by == '' ? 'active' : '' ?>" href="<?= Url::toRoute(['/park/default/reviewlist', 'slug' => $model->slug, 'sort_by' => 'newest']) ?>">Newest</a>
                                                        <a class="review-button btn_sort <?= $searchModel->custom_sort_by == 'highest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/park/default/reviewlist', 'slug' => $model->slug, 'sort_by' => 'highest']) ?>">Highest</a>
                                                        <a class="review-button btn_sort <?= $searchModel->custom_sort_by == 'lowest' ? 'active' : '' ?>" href="<?= Url::toRoute(['/park/default/reviewlist', 'slug' => $model->slug, 'sort_by' => 'lowest']) ?>">Lowest</a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <div id="review-list">
                                            <?php
                                            if ($reviews) {
                                                foreach ($reviews as $review) {  ?>
                                                    <div class="commentsOther  position-relative">
                                                        <div class="postcomment  pt-3">
                                                            <div class="text_com">
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
                                                                <p><?= $review->review ?> &nbsp;
                                                                    <?php if (Yii::$app->user->id == $review->user_id) { ?>
                                                                        <span class="writeAReviewBtn" value="<?= Url::toRoute(['/park/default/reviewupdate', 'park_id' => $model->id, 'user_id' => Yii::$app->user->id, 'id' => $review->id]) ?>"><i class="fa fa-edit"></i></span>
                                                                    <?php } ?>
                                                                </p>
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