<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;


/* @var $this yii\web\View */

$this->title =  $operator->register_comapany_name . ' | Blocked View';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();

?>


<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Safari Tour Operator</h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="touroprator_section bg-white">
    <div class="container-fluid">
        <div class="row justify-content-center pt-4">
            <div class="col-xxl-8 col-xl-10 col-lg-12">
                <div class="top_opratorsBox logedin">
                    <div class="row gx-lg-2">
                        <div class="col-lg-3 col-md-4">
                            <div class="tourLogoes ">
                                <div class="images_tour">
                                    <img src="<?= isset($operator->logo) ? $operator->imagepath : '/img/witw.png' ?>" alt="">
                                </div>
                                <div class="slect_safricound2 d-flex justify-content-around mt-4">
                                    <div class="parks_text text-center">
                                        <p><?= $operator->parkcount ?></p>
                                        <p>Parks</p>
                                    </div>
                                    <div class="parks_text text-center">
                                        <p><?= $operator->packagecount ?></p>
                                        <p>Packages</p>
                                    </div>
                                    <div class="parks_text text-center">
                                        <p><?= $operator->sharedsafaricount ?></p>
                                        <p>Shared Safaris</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 pt-sm-3 pt-md-0 pt-3">
                            <div class="provider_details ps-lg-3">
                                <div class="title_tours d-flex justify-content-between align-items-center gap-md-2 gap-xxl-3">
                                    <h3><?= $operator->businessname ?></h3>
                                </div>
                                <div class="title_tours">
                                    <p class="pb-sm-0 pt-2"> <?= $operator->categorytitle ?></p>
                                </div>
                                <div class="providerNamerating tours d-flex flex-wrap gap-4 align-items-center pb-3 pt-1">
                                    <div class="d-flex gap-2">
                                        <div class="ratings">
                                            <p class="mb-0"><?= round($operator->google_rating, 1) ?> <?= GeneralModel::ratiing_views($operator->google_rating); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="detailsText pb-3">
                                    <p style="font-size: 14px;"><?= $operator->about_business ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="touroprator_section  margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-12">
                <div class="card card_bodyPadding mt-2">
                    <div class="card-body">
                        <h1 class="text-danger">"The operator has been deactivated."</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>