<?php

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-12">
        <div class="comments_safari operator_comment">
            <div class="commentsOther  position-relative">
                <div class=" d-flex justify-content-between flex-wrap">
                    <div class="userRatingTitle">
                        <h6 class="nameRating">Average User Rating</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                            <div class="ratings">
                                <?php $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->average('rating');
                                if ($avg) { ?>
                                    <p class="mb-0">
                                        <?= $avg ?>
                                        <?= GeneralModel::ratiing_views($avg); ?>
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
                    <div class="whiteReview">
                        <?php if (Yii::$app->user->identity) { ?>
                            <button class="btn_review writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>">+ Write a Review</button>
                        <?php } else { ?>
                            <button class="btn_review" value="#">Please Login to Review</button>
                        <?php } ?>

                    </div>
                </div>
                <div class="sort_wrapper py-3">
                    <div class="sortBy">Sort by</div>
                    <button class="btn_sort active">Newest</button>
                    <button class="btn_sort">Highest</button>
                    <button class="btn_sort">Lowest</button>
                </div>
            </div>
            <?php
            $reviews = SafariOperatorRating::find()->where(['safari_operator_id' => $operator->id])->all();
            if ($reviews) {
                foreach ($reviews as $review) {  ?>
                    <div class="commentsOther  position-relative">
                        <div class="objec-flgs">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
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
                                        <p class="mb-0"><?= $review->user->name ?></p>
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
function writeareviewfunction() {
	$('.writeAReviewBtn').on('click', function () {
        $('#review-write-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();
             
JS;
$this->registerJs($script);
?>