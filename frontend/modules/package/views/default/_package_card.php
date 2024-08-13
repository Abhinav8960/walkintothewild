<?php

use common\models\UserWishlist;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>


<div class="sharesafri-card tourpackage">
    <div class="flotingdate">
        <div class="icons text-center">
            <p class="mb-0"><?= isset($model->no_of_day) ? $model->packagedaynightlabels : " " ?> </p>
        </div>
    </div>
    <div class="floating-watchlist">
        <?php
        if (false && Yii::$app->user->identity) { ?>
            <div class="heart_bx">
                <?php
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $model->id, 'item_type_id' => 1, 'status' => 1])->limit(1)->one();
                if ($wishlist) {
                ?>
                    <a href="<?= Url::toRoute(['/package/default/unwishlist', 'slug' => $model->package_slug]) ?>" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                <?php } else { ?>
                    <a href="<?= Url::toRoute(['/package/default/wishlist', 'slug' => $model->package_slug]) ?>" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                <?php }
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="shareimg">
        <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $model->package_slug]) ?>">
            <img src="<?= isset($model->imagepath) ? $model->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt=""></a>
    </div>
    <div class="card_body">
        <div class="titleDate">
            <h6 class="pt-1"><a href=""><?= $model->package_name ?> </a></h6>
            <div class="orgnizer_tour d-flex justify-content-between pt-2">
                <div class="icons_restro">
                    <i class="fa-solid fa-car-side"></i>
                    <p class="mb-0"><?= $model->no_of_safari ?> Safaris</p>
                </div>
                <div class="icons_restro">
                    <i class="fa-solid fa-car"></i>
                    <p class="mb-0"><?= isset($model->mastervehicle) ? $model->mastervehicle->vehicle_name : 'N/A' ?></p>
                </div>
                <div class="icons_restro">
                    <i class="fa-solid fa-utensils"></i>
                    <p class="mb-0"><?= $model->meals ?></p>
                </div>
                <div class="icons_restro">

                    <i class="fa-solid fa-building"></i>
                    <p class="mb-0"><?= isset($model->packagerange) ? $model->packagerange->title : "" ?></p>
                </div>
            </div>
        </div>
        <div class="footer_card row pb-2 px-2 align-items-center">
            <div class="col-6 col-lg-7 col-md-7">
                <div class="safaritourlogo">
                    <img src="<?= isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                </div>
            </div>
            <div class="col-6 col-md-5 col-lg-5">
                <div class="safari text-center">
                    <div class="joinsafari package">
                        <h6 class=" titlePrice">₹ <?= number_format($model->total_price) ?> </h6>
                        <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $model->package_slug]) ?>">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>