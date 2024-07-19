<?php

use common\models\GeneralModel;
use common\models\park\SafariParkRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$reviews = SafariParkRating::find()->where(['safari_park_id' => $safari_model->id, 'status' => 1])->all();

?>



<div class="filter-wrapper custoM-inputs d-lg-block d-none mb-2">
    <div class="title_top pb-4">
        <h4>Park Review</h4>
        <?php if ($reviews) { ?>
            <div class="userRatingTitle">
                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                    <div class="ratings">
                        <?php $avg = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $safari_model->id])->average('rating');
                        if ($avg) { ?>
                            <p class="mb-0">
                                <?= round($avg, 1) ?>
                                <?= GeneralModel::review_rating($avg); ?>
                            </p>
                        <?php } ?>
                    </div>
                    <?php $count = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $safari_model->id])->count(); {
                        if ($count) { ?>
                            <div class="googlerating">
                                <p class="mb-0"><?= $count . " " ?>Reviews</p>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="title_filter mb-2">
        <button value="<?= Url::toRoute(['/park/default/review', 'park_id' => $safari_model->id]) ?>" class="btn_newsafari writeSuggestionBtn " data-bs-toggle="modal" data-bs-target="#exampleModal3">Write Review</button>

    </div>
    <div class="title_filter mb-2">

        <div id="review-list">
            <?php
            if ($reviews) {
                foreach ($reviews as $review) {  ?>
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

</div>