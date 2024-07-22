<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafariIntrested;

$this->title = 'Safari Packages';
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
                        <ul class="tab-mnu">
                            <a href="/plan-safari">
                                <li><img src="<?= $this->params['baseurl'] ?>/img/plans.png" alt="" width="30" class="me-2"> Plan Safari</li>
                            </a>
                            <a href="/safari-packages">
                                <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/package.png" alt="" width="30" class="me-1" style="padding:6px;"> Safari Packages</li>
                            </a>
                            <a href="/shared-safari">
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/car_852639.png" alt="" width="30" class="me-1" style="padding:6px;"> Shared Safari</li>
                            </a>
                        </ul>

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
<?php if ($packages) {
?>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2 class="pb-1">TOP SAFARI DEALS</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="articals_wrapper">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-xl-11 px-xl-4">
                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-4 px-2">
                        <?php if ($packages) {
                            foreach ($packages as $package) { ?>
                                <div class="col mb-lg-0 mb-3 ">
                                    <div class="sharesafri-card tourpackage">
                                        <div class="flotingdate">
                                            <div class="icons text-center">
                                                <p class="mb-0">3N/4D</p>
                                            </div>
                                        </div>
                                        <div class="shareimg">
                                            <a href="/package/<?= $package->package_slug ?>">
                                                <img src="http://app.walkintothewild.io/storage/safaripark/41/logo1718180001.jpg" alt=""></a>
                                        </div>
                                        <div class="card_body">
                                            <!-- <div class="top_seats">
                                                <div class="safari d-flex justify-content-between ">
                                                    <div class="safarinum d-flex gap-2 align-items-center ">
                                                        <p class="text_safari">NIGHTS</p>
                                                        <h6 class="number-safari"><?= $package->no_of_night ?></h6>
                                                    </div>
                                                    <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                        <p class="text_safari">SAFARIES</p>
                                                        <h6 class="number-safari"><?= $package->no_of_safari ?></h6>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="titleDate">
                                                <h6 class="pt-1"><a href=""><?= $package->package_name ?> </a></h6>
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
                                                <div class="col-7">
                                                    <div class="safaritourlogo">
                                                        <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="safari text-center">
                                                        <div class="joinsafari package">
                                                            <h6 class=" titlePrice"><?= $package->cost_per_person ?> + GST </h6>
                                                            <a href="/package/<?= $package->package_slug ?>">View Details</a>
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
    <!-- <div class="container-lg">
        <div class="row justify-content-center">
            <div class="joinshareView mt-xl-0 mt-3">
                <a href="/package" class="btn_shareView">View All</a>
            </div>
        </div>
    </div> -->
<?php } ?>
<?php if ($shared_safaries) { ?>

<section class="sharesafri">
    <div class="container-lg padditg_mobile">
        <div class="row justify-content-center ">
            <div class="col-xl-11  px-md-1 px-0 ">
                <div class="sharesafribg home px-lg-0 px-2">
                    <div class="safarishareBox py-3 pb-5">
                        <div class="row justify-content-center">
                            <div class="col-xl-3">

                            </div>
                            <div class="col-xxl-9 col-lg-12 col-xl-9">
                                <div class="title_safari JoinPadding d-flex justify-content-center justify-content-xl-between align-items-center flex-wrap">
                                    <h4 class="text-center ps-4">Discover and Join 100+ Shared Safaris</h4>
                                    <div class="joinshareView mt-xl-0 mt-3 pe-lg-4">
                                        <a href="/sharedsafari" class="btn_shareView">View All</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row postion_setsfari  pe-lg-4 ps-lg-5">
                            <div class="col-3"></div>
                            <?php foreach ($shared_safaries as $share_safari) { ?>
                                <div class="col-lg-3 col-sm-5 col-xxl-3 col-md-4 mb-4 ">
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
                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>" style="background-color: #007BFF !important;">Leave Safari</a>
                                                                <?php } else { ?>
                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                                <?php  }
                                                            } else { ?>
                                                                <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
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