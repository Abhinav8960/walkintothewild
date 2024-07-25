<?php

use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;
use yii\helpers\Url;

$this->title = 'Your Wishlist';
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12  mt-2">
            <h6 class="fs-3 fw-bold mb-4">Wishlist</h6>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-5">
            <div class="row mb-5">
                <div class="col-md-12">
                    <?= $this->render('@frontend/modules/account/views/wishlist/_navbar', ['package' => 'active']) ?>
                    <div class="tab-content m-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-5">
                                <?php if ($wishlist_items) {
                                    foreach ($wishlist_items as $wishlist_item) {
                                        $package_model = Package::find()->where(['id' => $wishlist_item->item_id])->limit(1)->one();
                                        if (!$package_model) {
                                            continue;
                                        }
                                ?>
                                        <div class="col-md-4 mb-4 padding_righ">
                                            <div class="sharesafri-card tourpackage">
                                                <div class="flotingdate">
                                                    <div class="icons text-center">
                                                        <p class="mb-0"><?= isset($package_model->no_of_day) ? $package_model->packagedaynightlabels : " " ?> </p>
                                                    </div>
                                                </div>
                                                <div class="floating-watchlist">
                                                    <?php
                                                    if (Yii::$app->user->identity) { ?>
                                                        <div class="heart_bx">
                                                            <a href="/package/unwishlist/<?= $package_model->package_slug ?>" style="color:#FD5634;"><i class="fa-solid fa-heart"></i></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="shareimg">
                                                    <a href="/package/<?= $package_model->package_slug ?>">
                                                        <img src="<?= isset($package_model->package_image) ? $package_model->imagepath : $this->params['baseurl'] . '/img/blog_details01.jpg' ?>" alt=""></a>
                                                </div>
                                                <div class="card_body">
                                                    <div class="titleDate">
                                                        <h6 class="pt-1"><a href=""><?= $package_model->package_name ?> </a></h6>
                                                        <div class="orgnizer_tour d-flex justify-content-between pt-2">
                                                            <div class="icons_restro">
                                                                <i class="fa-solid fa-car-side"></i>
                                                                <p class="mb-0"><?= $package_model->no_of_safari ?>Safaris</p>
                                                            </div>
                                                            <div class="icons_restro">
                                                                <i class="fa-solid fa-car"></i>
                                                                <p class="mb-0"><?= $package_model->pickanddrop ?></p>
                                                            </div>
                                                            <div class="icons_restro">
                                                                <i class="fa-solid fa-utensils"></i>
                                                                <p class="mb-0"><?= $package_model->meals ?></p>
                                                            </div>
                                                            <div class="icons_restro">

                                                                <i class="fa-solid fa-building"></i>
                                                                <p class="mb-0"><?= $package_model->packagerange->title ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                                        <div class="col-6">
                                                            <div class="safaritourlogo">
                                                                <img src="<?= isset($package_model->safarioperator->imagepath) ? $package_model->safarioperator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="safari text-center">
                                                                <div class="joinsafari package">
                                                                    <h6 class=" titlePrice"><?= $package_model->cost_per_person ?> + GST </h6>
                                                                    <a href="/package/<?= $package_model->package_slug ?>">View Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } else {
                                    echo 'No Shared Safari found in wishlist';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>