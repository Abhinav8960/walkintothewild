<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;


/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Shared Safari';
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
        <?= $this->render('_view_navbar', ['active' => 'sharedsafari', 'operator' => $operator]) ?>
    </div>
  
</section>
<section class="touroprator_section ">
<div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class=" col-xxl-8 col-lg-">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="row justify-content-center pt-3">
                                                <?php
                                                if ($shared_safaries) {
                                                    foreach ($shared_safaries as $share_safari) { ?>
                                                        <div class="col-md-5 mb-4 padding_right">
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
                                                                        <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= isset($share_safari->park_id) ? GeneralModel::safariparkoption()[$share_safari->park_id] : '' ?></a></h6>
                                                                        <div class="orgnizer">
                                                                            <p>Organized by: <strong><?= isset($share_safari->user) ? $share_safari->user->name : '' ?></strong></p>
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
                                                                                    }
                                                                                };
                                                                                $count = $share_safari->getIntrested()->count();
                                                                                $avatar_count = 3;
                                                                                $data = $count - $avatar_count;
                                                                                if ($data > 3) {  ?>
                                                                                    <div class="roundes_countuser">
                                                                                        <?= $data ?>+
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="safari text-center">
                                                                                <div class="joinsafari">
                                                                                    <?php if (Yii::$app->user->identity) {
                                                                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                                                        if ($share_safari_intrested) { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>">Leave Safari</a>
                                                                                        <?php } else { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                                                        <?php  }
                                                                                    } else { ?>
                                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } else {
                                                    echo '<p class="noData">No Shared Safari Found!</p>';
                                                } ?>
                                            </div>

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