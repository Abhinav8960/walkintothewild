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
    <div class="card">
        <div class="row mb-5">
            <div class="col-md-12 m-3 mt-2">
                <h5>Wishlist</h5>
            </div>
            <div class="col-md-12">
                <?= $this->render('@frontend/modules/account/views/wishlist/_navbar', ['package' => 'active']) ?>
                <div class="tab-content m-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                        <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">
                            <?php if ($packages) {
                                foreach ($packages as $package) {
                                    $package_model = Package::find()->where(['id' => $package->id])->limit(1)->one();
                            ?>
                                    <div class="col mb-4 padding_righ">
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
                                                        <?php
                                                        $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package_model->id, 'item_type_id' => 1, 'status' => 1])->limit(1)->one();
                                                        if ($wishlist) {
                                                        ?>
                                                            <a href="/package/unwishlist/<?= $package_model->package_slug ?>" style="color:black;"><i class="fa-solid fa-heart"></i></a>
                                                        <?php } else { ?>
                                                            <a href="/package/wishlist/<?= $package_model->package_slug ?>" style="color:black;"><i class="fa-regular fa-heart"></i></a>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="shareimg">
                                                <a href="/package/<?= $package_model->package_slug ?>">
                                                    <img src="<?= isset($package_model->package_image) ? $package_model->imagepath : $this->params['baseurl'] . '/img/blog_details01.jpg' ?>" alt=""></a>
                                            </div>
                                            <div class="card_body">
                                                <div class="top_seats">
                                                    <div class="safari d-flex justify-content-between ">
                                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                                            <p class="text_safari">NIGHTS</p>
                                                            <h6 class="number-safari"><?= $package_model->no_of_night ?></h6>
                                                        </div>
                                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                            <p class="text_safari">SAFARIES</p>
                                                            <h6 class="number-safari"><?= $package_model->no_of_safari ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="titleDate">
                                                    <h6 class="pt-1"><a href=""><?= $package_model->package_name ?> </a></h6>
                                                    <div class="orgnizer_tour d-flex justify-content-between pt-2">
                                                        <div class="icons_restro">
                                                            <i class="fa-solid fa-car-side"></i>
                                                            <p class="mb-0">5 Safaris</p>
                                                        </div>
                                                        <div class="icons_restro">
                                                            <i class="fa-solid fa-car"></i>
                                                            <p class="mb-0">Pick & Drop</p>
                                                        </div>
                                                        <div class="icons_restro">
                                                            <i class="fa-solid fa-utensils"></i>
                                                            <p class="mb-0">Meals</p>
                                                        </div>
                                                        <div class="icons_restro">

                                                            <i class="fa-solid fa-building"></i>
                                                            <p class="mb-0">Premium</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="footer_card row pb-2 px-2 align-items-center">
                                                    <div class="col-6">
                                                        <div class="safaritourlogo">
                                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
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