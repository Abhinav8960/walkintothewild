<?php

use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingSearch;
use yii\helpers\Url;

$ratingsearchModel = new SafariOperatorRatingSearch();
$ratingsearchModel->safari_operator_id = $operator->id;
$ratingsearchModel->status = 1;
$ratingdataProvider = $ratingsearchModel->search(Yii::$app->request->queryParams);
$reviews = $ratingdataProvider->getModels();
?>
<?php if ($reviews) { ?>

    <div class="request_quote mb-4">
        <button class="intested_btn interestBtn  d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;cursor: default;">

            Operator Rating <span><?= $operator->google_rating ?>/5 (<?= $operator->google_review_count ?>)</span>

        </button>
        <div class="interst_wrapper pt-1 px-3 bg-white">

            <?php if ($reviews) { ?>
                <div id="review-list">
                    <?php

                    foreach ($reviews as $review) {  ?>
                        <div class="commentsOther2  position-relative">
                            <div class="postcomment  pt-3">
                                <div class="text_com colors_p">
                                    <div class="providerNamerating ">
                                        <div class="googlerating names">
                                            <?php if ($review->user) { ?>
                                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $review->user->user_handle]) ?>" data-pjax="0">
                                                    <h6 class="mb-0 fs-6 pb-0"><?= $review->user->name ?></h6>
                                                </a>
                                            <?php } ?>

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
                    ?>
                </div>
                <div class="col-12">
                    <div class="safari text-end">
                        <div class="viewAllreview">
                            <a href="<?= \yii\helpers\Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug]) ?>" data-pjax="0">View All</a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
<?php } ?>