<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use frontend\assets\FrontAppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
FrontAppAsset::register($this);
AppAsset::register($this);

?>

<div class="d-flex justify-content-between align-items-center mt-5">
    <h3 class="mt-5">Package : <?= Html::encode($package->package_name) ?></h3>
    <div>
        <?= Html::a('<i class="fa fa-edit" style="font-size:15px; margin-right:5px"></i>View', [Url::toRoute(['view', 'id' => $package->id])], ['class' => 'btn mt-3', 'style' => 'background-color:#F48270', 'title' => 'View']) ?>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body" style="background-color:#1677FF33">
                    <div class="media d-flex align-items-center">
                        <img src="<?= $this->params['baseurl'] ?>/img/package_card.png" alt="" style="width: 60px; height: 60px; object-fit: contain; margin-right: 15px;">

                        <div class="media-body">
                            <h3 class="mb-0">156</h3>
                            <span>Wishlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body" style="background-color:#12772933">
                    <div class="media d-flex align-items-center">
                        <img src="<?= $this->params['baseurl'] ?>/img/package_card.png" alt="" style="width: 60px; height: 60px; object-fit: contain; margin-right: 15px;">

                        <div class="media-body">
                            <h3>156</h3>
                            <span>Booking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body" style="background-color:#D9D9FFCC">
                    <div class="media d-flex align-items-center">
                        <img src="<?= $this->params['baseurl'] ?>/img/package_card.png" alt="" style="width: 60px; height: 60px; object-fit: contain; margin-right: 15px;">

                        <div class="media-body">
                            <h3>156</h3>
                            <span>Quote Request</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="mb-2">
            <img src="<?= isset($package->imagebannerpath) ? $package->imagebannerpath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100 banner_image">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="wrapper-skybgsafri pb-0" style="background-color: #F5F5F5 !important;">
            <div class="row border_bottom2 pb-4">
                <div class="col-lg-7 col-md-8 border-right">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="images_tour select_safrai">
                                <img src="<?= isset($package->safarioperator->imagepath) ? $package->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8 pt-sm-0 pt-3">
                            <div class="safrititles">
                                <h5 class="fs-4"><?= $package->package_name ?></h5>
                                <p class="mb-0 ">Organized by <strong><?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></strong></p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pt-lg-0 pt-4">
                    <div class="row ps-1">
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->no_of_night ?> Nights , <?= $package->no_of_day ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->pickanddrop ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->no_of_safari ?> <?php
                                                                                    if ($package->safari_type == 1) {
                                                                                        echo 'Shared Safari';
                                                                                    } elseif ($package->safari_type == 2) {
                                                                                        echo 'Private Safari';
                                                                                    } else {
                                                                                        echo 'Shared Safari';
                                                                                    } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meals">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->meals ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <?php if ($package->package_agenda_id && $package->package_agenda_id == 1) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } else { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } ?>
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">
                                        <?= isset(GeneralModel::agendaoption()[$package->package_agenda_id]) ? GeneralModel::agendaoption()[$package->package_agenda_id] : 'Not Included' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= isset(GeneralModel::packageoption()[$package->stay_category_id]) ? GeneralModel::packageoption()[$package->stay_category_id] : 'Not Included' ?></p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 m-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">
                        <div class="pakageCost mb-xxl-0 mb-2">
                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?> / <span class="perpersonText">Per Person</span></h6>
                        </div>
                        <div class="btn-delet float-end py-2">
                            <!-- <a style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" href="<?= \yii\helpers\Url::toRoute(['/package/preview/update', 'id' => $package->id]) ?>"><i class="fas fa-check me-1"></i>Mark Package As Pouplar</a>
                                    <button class="btn_userarticle" style="background:red !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/package/preview/delete', 'id' => $package->id]) ?>"><i class="fas fa-trash me-1"></i>Delete</button> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 pt-4">
                <div class="text_safaripackage">
                    <p><?= $package->package_description ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.banner_image{
    height: 220px !important;
    object-fit: cover !important;
}
</style>