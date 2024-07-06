<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<?php
if ($reviews) {
    foreach ($reviews as $review) {  ?>
        <div class="commentsOther  position-relative">
            <div class="objec-flgs">
                <?php if (Yii::$app->user->id) {  ?>
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/operator/default/flag', 'operator_id' => $operator->id, 'park_id' => $review->park_id, 'safari_operator_rating_id' => $review->id]) ?>">
                <?php } ?>
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
                            <p class="mb-0"> <?= $review->user->name ?></p>
                        </div>
                    </div>
                    <p><?= $review->review ?></p>
                </div>
            </div>
        </div>
<?php
    }
} ?>