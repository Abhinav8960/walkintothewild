<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafariIntrested;

$this->title = 'Shared Safari';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::HOME;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>


<section class="banner_section main_homebanner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBannerhome-min.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBannerhome-min.png' ?>" class="d-block w-100" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner pb-1">
                        <h1>Find, plan and share Safaris - Your Ultimate Portal to the Wild</h1>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    <div class="tab-block" id="tab-block">
                        <!-- <ul class="tab-mnu">
                            <a href="/plan-safari">
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/plans.png" alt="" width="30" class="me-2"> Plan Safari</li>
                            </a>
                            <a href="/safari-packages">
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/package.png" alt="" width="30" class="me-1" style="padding:6px;">Safari Packages</li>
                            </a>
                            <a href="/shared-safari">
                                <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/car_852639.png" alt="" width="30" class="me-1" style="padding:6px;">Shared Safari</li>
                            </a>
                        </ul> -->

                        <div class="tab-cont">
                            <div class="tab-pane">
                                <?= $this->render('_search', [
                                    'model' => $searchModel,
                                ]) ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
<?php if ($shared_safaries) {
?>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2 class="pb-1">TOP SHARED SAFARI</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="articals_wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-xxl-10 px-xxl-3  col-lg-12">
                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5 padding_setCard">
                        <?php if ($shared_safaries) {
                            foreach ($shared_safaries as $share_safari) { ?>
                                <div class="col mb-4 padding_righ">
                                    <div class="sharesafri-card">
                                        <div class="flotingdate">
                                            <div class="icons text-center">
                                                <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                            </div>
                                        </div>
                                        <div class="shareimg">
                                            <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                        </div>
                                        <div class="card_body">
                                            <?php
                                            $class = '';
                                            if (Yii::$app->user->identity) {
                                                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                if ($share_safari_intrested) {
                                                    $class = 'background-color: #007BFF !important;';
                                                }
                                            } ?>
                                            <div class="top_seats" style='<?= $class ?>'>
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
                                                <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>"><?= $share_safari->park->title ?></a></h6>
                                                <div class="orgnizer">
                                                    <p>Organized by: <strong><?= $share_safari->organizedbyname ?></strong></p>
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
                                                            };
                                                            $count = $share_safari->getIntrested()->count();
                                                            $avatar_count = 3;
                                                            $data = $count - $avatar_count;
                                                            if ($data > 3) {  ?>
                                                                <div class="roundes_countuser">
                                                                    <?= $data ?>+
                                                                </div>
                                                            <?php }
                                                        } else { ?>
                                                            <img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="safari text-center">
                                                        <div class="joinsafari">
                                                            <?php if ($share_safari->status == 2) { ?>
                                                                <a href="#">Closed Safari</a>
                                                                <?php } else {
                                                                if (Yii::$app->user->identity) {
                                                                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                                    if ($share_safari_intrested) { ?>
                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>" style="background-color: #007BFF !important;" data-method="POST">Leave Safari</a>
                                                                    <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                                    <?php  }
                                                                } else { ?>
                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>

<section class="safariduring_sesons">
    <?= \frontend\widgets\FeatureParkWidget::widget(['section_title' => $banner ? $banner->feature_park_title : '']) ?>
</section>
<section class="animal-wrapper pb-5 mb-5">
    <?= \frontend\widgets\RareExoticWidget::widget() ?>
</section>