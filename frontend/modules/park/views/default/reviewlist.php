<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\park\SafariParkRating;

/* @var $this yii\web\View */

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<section>

    <?= $this->render('@frontend/modules/park/views/default/tablist', [
        'review' => 'active',
        'model' => $model,
    ]) ?>

</section>

<section class="">
    <div class="container-fluid">
        <div class="row my-lg-4 my-2 pt-3 justify-content-center margin_bottomfooter mb-">
            <div class="col-lg-12 col-xxl-11">
                <div class="tab-content_tour mb-4 active">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="comments_safari operator_comment bg-white">
                                <div class="commentsOther  position-relative px-5 pt-4">
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
                                            <?php if (Yii::$app->user->identity) {
                                                if ($my_review) {
                                                    echo 'Review Already Submitted!';
                                                } else { ?>
                                                    <button value="<?= Url::toRoute(['/park/default/review', 'park_id' => $model->id]) ?>" class="parkrevieBtn writeSuggestionBtn " data-bs-toggle="modal" data-bs-target="#exampleModal3">Write Review</button>
                                                <?php  }
                                                ?>
                                            <?php } else { ?>
                                                <a class="parkrevieBtn py-2" href="/site/login?authclient=google&referrer=/park/<?= $model->slug ?>/reviewlist">Please Login to Review</a>
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
                                                                <?php if ($review->user) { ?>
                                                                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $review->user->user_handle]) ?>">
                                                                        <p class="mb-0"> <?= $review->user->name ?> <?= date("F j, Y", $review->created_at) . ' at ' . date("H:i A", $review->created_at) ?></p>
                                                                    </a>
                                                                <?php } ?>

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