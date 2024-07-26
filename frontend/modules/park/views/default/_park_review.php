<?php

use common\models\GeneralModel;
use common\models\park\SafariParkRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$reviews = SafariParkRating::find()->where(['safari_park_id' => $safari_model->id, 'status' => 1])->all();

?>



<div class="filter-wrapper custoM-inputs d-lg-block d-none mb-2">
    <?php if ($reviews) { ?>
        <div class="title_top pb-2">
            <div class="userRatingTitle">
                <div class="providerNamerating d-flex  justify-content-between  align-items-center">
                    <h4 class="mb-0">Park Review</h4>
                    <div class="ratings">
                        <?php $avg = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $safari_model->id])->average('rating');
                        if ($avg) { ?>
                            <h4 class="mb-0  ">
                                <?= round($avg, 1) ?>
                                <!-- <?= GeneralModel::review_rating($avg); ?> -->
                            </h4>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
    <?php if (Yii::$app->user->id) {  ?>
        <div class="title_filter mb-2">
            <button value="<?= Url::toRoute(['/park/default/review', 'park_id' => $safari_model->id]) ?>" class="parkrevieBtn writeSuggestionBtn " data-bs-toggle="modal" data-bs-target="#exampleModal3">Write Review</button>
        </div>
    <?php } else {
        echo 'Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for giving your review';
    } ?>

    <div class="title_filter mb-2">

        <div id="review-list">
            <?php
            if ($reviews) {
                foreach ($reviews as $review) {  ?>
                    <div class="postcomment  pt-3">
                        <div class="text_com colors_p">
                            <div class="providerNamerating ">
                                <div class="googlerating names">
                                    <h6 class="mb-0 fs-6 pb-0"> <?= $review->user->name ?></h6>
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
                            <p class="suggest"><?= $review->review ?> &nbsp;
                                <?php if (Yii::$app->user->id == $review->user_id) { ?>
                                    <span class="writeSuggestionBtn" value="<?= Url::toRoute(['/park/default/reviewupdate', 'park_id' => $safari_model->id, 'user_id' => Yii::$app->user->id, 'id' => $review->id]) ?>"><i class="fa fa-edit"></i></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
            <?php
                }
            } ?>
        </div>
    </div>
    <?php if (count($reviews) >= 1) { ?>

        <div class="col-12">
            <div class="safari text-end">
                <div class="viewAllreview">
                    <a href="/park/<?= $safari_model->slug ?>/reviewlist">View All</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>