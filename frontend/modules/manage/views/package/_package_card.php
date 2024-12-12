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
    <div class="shareimg">
        <img src="<?= $model->imagepath ? $model->imagepath : $this->params['baseurl'] . '/img/thumbnailpakage.jpg' ?>" alt="">
    </div>
    <div class="card_body">
        <div class="titleDate">
            <h6 class="pt-1"><?= $model->package_name ?></h6>
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
                    <p class="mb-0"><?= isset($model->packagerange) ? $model->packagerange->title : "N/A" ?></p>
                </div>
            </div>
        </div>
        <div class="footer_card row pb-2 px-2 align-items-center">
            <div class="col-6 col-lg-7 col-md-7">
                <div class="safaritourlogo">
                    <img src="<?= isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : $this->params['baseurl'] . '/img/operator-placeholder-80.jpg' ?>" alt="" class="w-100">
                </div>
            </div>
            <div class="col-6 col-md-5 col-lg-5">
                <div class="safari text-center">
                    <div class="joinsafari package">
                        <h6 class=" titlePrice">₹ <?= number_format($model->total_price) ?> </h6>
                        <a href="<?= Url::toRoute(['update', 'slug' => $model->package_slug]) ?>" data-pjax="0"><i class="fa fa-edit"></i> Update</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>