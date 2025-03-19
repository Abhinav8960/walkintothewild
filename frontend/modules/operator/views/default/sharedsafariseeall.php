<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;


/* @var $this yii\web\View */

$this->title =  $operator->register_comapany_name . ' | Shared Safari';
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
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                                Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="touroprator_section bg-white">
    <div class="container-fluid">
        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>

    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'sharedsafari', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-12">
                <div class="row pt-2 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class=" col-xxl-8 col-lg-8">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Organized <span class="numberFont"><?= $dataProvider->getTotalCount() ?></span> Shared Safaris</h6>

                                            </div>

                                            <div class="row gx-lg-3 gx-4 ">
                                                <?php
                                                if ($dataProvider->models) {
                                                    foreach ($dataProvider->models as $share_safari) { ?>
                                                        <div class="col-md-6  mb-4 ">
                                                            <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                                        </div>
                                                <?php }
                                                } else {
                                                    echo '<p class="noData">No Shared Safari Found!</p>';
                                                } ?>
                                            </div>
                                            <?php
                                            echo \yii\widgets\LinkPager::widget([
                                                'pagination' => $dataProvider->pagination,
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-lg-4">
                                <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) { ?>

                                    <div class="mb-4" id="memberview">
                                        <?= $this->render('_free_quote', [
                                            'model' => $model,
                                            'operator' => $operator,
                                            'disabled' => false,
                                        ]) ?>
                                    </div>
                                <?php } else {  ?>

                                    <div class="mb-4 position-relative galssset " id="memberview">
                                        <svg class="form-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="#02690e" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                                        </svg>
                                        <?= $this->render('_free_quote', [
                                            'model' => $model,
                                            'operator' => $operator,
                                            'disabled' => true,
                                        ]) ?>
                                    </div>
                                <?php }   ?>
                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>