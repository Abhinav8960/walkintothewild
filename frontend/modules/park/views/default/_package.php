<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\UserWishlist;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<section class="articals_wrapper py-3 " style="background-color: #fff;">
    <div class="container-fluid">
        <?= $this->render('@frontend/modules/park/views/default/tablist', [
            'package' => 'active',
            'model' => $model,
        ]) ?>
    </div>
</section>

<div class="row my-lg-4 my-2 justify-content-center margin_bottomfooter mb-5">
    <div class="col-lg-12 col-xl-10">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <?php if ($packages) { ?>
                            <div class="backgroud_oprator py-4">

                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 gx-xxl-2 g-xl-4 gx-xxl-4 ">

                                    <?php
                                    foreach ($packages as $model) { ?>
                                        <div class="col mb-4 padding_righ">
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
                                                                <a href="/package/unwishlist/<?= $model->package_slug ?>" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                            <?php } else { ?>
                                                                <a href="/package/wishlist/<?= $model->package_slug ?>" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                            <?php }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="shareimg">
                                                    <a href="/package/<?= $model->package_slug ?>">
                                                        <img src="<?= isset($model->package_image) ? $model->imagepath : $this->params['baseurl'] . '/img/blog_details01.jpg' ?>" alt=""></a>
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
                                                                <p class="mb-0"><?= $model->mastervehicle ? $model->mastervehicle->vehicle_name : 'N/A' ?></p>
                                                            </div>
                                                            <div class="icons_restro">
                                                                <i class="fa-solid fa-utensils"></i>
                                                                <p class="mb-0"><?= $model->meals ?></p>
                                                            </div>
                                                            <div class="icons_restro">

                                                                <i class="fa-solid fa-building"></i>
                                                                <p class="mb-0"><?= isset($model->packagerange->title) ? $model->packagerange->title : "" ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                                        <div class="col-7">
                                                            <div class="safaritourlogo">
                                                                <img src="<?= isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="safari text-center">
                                                                <div class="joinsafari package">
                                                                    <h6 class=" titlePrice">₹<?= number_format($model->total_price) ?> </h6>
                                                                    <a href="/package/<?= $model->package_slug ?>">View Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>