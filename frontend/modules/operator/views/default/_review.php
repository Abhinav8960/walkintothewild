<?php

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\bootstrap5\ActiveForm;
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
                    <div class="whiteReview">
                        <?php if (Yii::$app->user->identity) { ?>
                            <button class="btn_review writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>">+ Write a Review</button>
                        <?php } else { ?>
                            <a class="btn_review" href="/site/auth?authclient=google">Please Login to Review</a>
                        <?php } ?>

                    </div>
                </div>
                <div class="sort_wrapper py-3">
                    <div class="sortBy">Sort by</div>
                    <button class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'newest' || $ratingsearchModel->custom_sort_by == '' ? 'active' : '' ?>" value="<?= Url::toRoute(['/operator/default/reviewwise', 'slug' => $operator->slug, 'sort_by' => 'newest']) ?>">Newest</button>
                    <button class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'highest' ? 'active' : '' ?>" value="<?= Url::toRoute(['/operator/default/reviewwise', 'slug' => $operator->slug, 'sort_by' => 'highest']) ?>">Highest</button>
                    <button class="review-button btn_sort <?= $ratingsearchModel->custom_sort_by == 'lowest' ? 'active' : '' ?>" value="<?= Url::toRoute(['/operator/default/reviewwise', 'slug' => $operator->slug, 'sort_by' => 'lowest']) ?>">Lowest</button>
                </div>
            </div>

            <div id="review-list">
                <?= $this->render('_review_tab', [
                    'ratingsearchModel' => $ratingsearchModel,
                    'reviews' => $reviews,
                    'operator' => $operator,
                ]) ?>
            </div>


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