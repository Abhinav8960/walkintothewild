<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;


/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Shared Safari';
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

        <?php if (Yii::$app->user->identity) { ?>
            <div class="row justify-content-center  mb-4">
                <?= $this->render('_free_quote', [
                    'model' => $model,
                    'operator' => $operator,
                ]) ?>
            </div>
        <?php } ?>
    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'sharedsafari', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class=" col-xxl-12 col-lg-12">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Organized <span class="numberFont"><?= $dataProvider->getTotalCount() ?></span> Shared Safari</h6>

                                            </div>

                                            <div class="row gx-5 justify-content-center">
                                                <?php
                                                if ($dataProvider->models) {
                                                    foreach ($dataProvider->models as $share_safari) { ?>
                                                        <div class="col-md-5 mb-4 ">
                                                            <div class="sharesafri-card">
                                                                <div class="flotingdate">
                                                                    <div class="icons text-center">
                                                                        <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                                        <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="shareimg">
                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                                                </div>
                                                                <div class="card_body">
                                                                    <div class="top_seats">
                                                                        <div class="safari d-flex justify-content-between ">
                                                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                                                <p class="text_safari">SAFARI</p>
                                                                                <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>
                                                                            </div>
                                                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                                                <p class="text_safari">SEATS</p>
                                                                                <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="titleDate">
                                                                        <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= isset($share_safari->park_id) ? GeneralModel::safariparkoption()[$share_safari->park_id] : '' ?></a></h6>
                                                                        <div class="orgnizer">
                                                                            <p>Organized by: <strong><?= isset($share_safari->user) ? $share_safari->user->name : '' ?></strong></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                                                        <div class="col-6">
                                                                            <div class="users">
                                                                                <?php if ($interests = $share_safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                                    $count = $share_safari->getIntrested()->count();
                                                                                    $avatar_count = 3;
                                                                                    foreach ($interests as $interest) {
                                                                                ?>
                                                                                        <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                                    <?php
                                                                                    }
                                                                                };
                                                                                $count = $share_safari->getIntrested()->count();
                                                                                $avatar_count = 3;
                                                                                $data = $count - $avatar_count;
                                                                                if ($data > 3) {  ?>
                                                                                    <div class="roundes_countuser">
                                                                                        <?= $data ?>+
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="safari text-center">
                                                                                <div class="joinsafari">
                                                                                    <?php if (Yii::$app->user->identity) {
                                                                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                                                        if ($share_safari_intrested) { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>" data-method="POST" style="background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;">Leave Safari</a>
                                                                                        <?php } else { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                                                        <?php  }
                                                                                    } else { ?>
                                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>