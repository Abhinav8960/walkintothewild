<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafariIntrested;

$this->title = 'India’s first wildlife network platform';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['meta_description'] = "Introducing India’s first wildlife network platform, where you can connect with fellow adventurers, join shared safaris, and access comprehensive park details to choose the perfect tiger reserve. Discover tour packages and operators—all for free.";

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::HOME;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>

<script type="application/ld+json">
    {
        "@type": "Organization",
        "image": "<?= Yii::$app->params['frontend_url'] ?>img/default_witw_jeep.png",
        "url": "<?= Yii::$app->params['frontend_url'] ?>",
        "name": "<?= $this->title ?>"
    }
</script>


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
                                <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/plans.png" alt="" width="30" class="me-2"> Plan Safari</li>
                            </a>
                            <a href="/safari-packages">
                                <li> <img src="<?= $this->params['baseurl'] ?>/img/package.png" alt="" width="30" class="me-1" style="padding:6px;"> Safari Packages</li>
                            </a>
                            <a href="/shared-safari">
                                <li><img src="<?= $this->params['baseurl'] ?>/img/car_852639.png" alt="" width="30" class="me-1" style="padding:6px;"> Shared Safari</li>
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

<!-- <section class="px-md-0 px-3">
<div class="google-ad-box margin-topset" >

</div>
</section> -->

<?php if ($shared_safaries) { ?>
    <section class="sharesafri">
        <div class="container-lg padditg_mobile">
            <div class="row justify-content-center ">
                <div class="col-xl-11  px-md-1 px-0 ">
                    <div class="sharesafribg home px-lg-0 px-2">
                        <div class="safarishareBox py-xxl-3 pb-xxl-5">
                            <div class="row justify-content-center">
                                <div class="col-xxl-3">

                                </div>
                                <div class="col-xxl-9 col-lg-12 col-xl-12">
                                    <div class="title_safari JoinPadding phone_padding d-flex justify-content-center justify-content-md-between align-items-center flex-wrap">
                                        <h4 class="text-center ps-lg-4">Discover and Join multiple Shared Safaris</h4>
                                        <div class="joinshareView mt-md-0 mt-3 pe-lg-4 d-sm-block d-none">
                                            <a href="/sharedsafari" class="btn_shareView" data-pjax="0">View All</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row postion_setsfari  pe-lg-4 ps-lg-4 ps-xxl-5 padding_mobileAdded">
                                <div class="col-lg-12 col-sm-12 col-xxl-3 col-md-12 mb-4"></div>
                                <?php
                                $safari_printed = 0;
                                foreach ($shared_safaries as $share_safari) {
                                    if ($safari_printed >= 3) {
                                        continue;
                                    }

                                    if (Yii::$app->user->identity) {
                                        if ($share_safari->type == 2) { // Fixed  Safai
                                            if ($safarioperator = $share_safari->safarioperator) {
                                                if ($safarioperator->user_id == Yii::$app->user->identity->id) {
                                                    continue;
                                                }
                                            }
                                        } else {
                                            if ($share_safari->host_user_id == Yii::$app->user->identity->id) {
                                                continue;
                                            }
                                        }
                                    }
                                ?>
                                    <div class="col-lg-4 col-sm-6 col-xxl-3 col-md-6 mb-4 ">
                                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                    </div>

                                <?php $safari_printed++;
                                } ?>
                                <div class="joinshareView pb-sm-0 pb-4 text-center pe-lg-4 d-sm-none d-block col-xxl-3">
                                    <a href="/sharedsafari" class="btn_shareView w-100 d-block" data-pjax="0">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php if ($packages) { ?>
    <section class="sharesafri">
        <div class="container-lg  padditg_mobile">
            <div class="row justify-content-center">
                <div class="col-xl-11 px-md-1 px-0">
                    <div class="PackageBox_home p-sm-2 p-md-4">
                        <div class="row justify-content-left">
                            <div class="col-xxl-12 col-lg-12 col-xl-12 pb-3">
                                <div class="title_safari JoinPadding d-flex justify-content-left justify-content-md-between align-items-left flex-wrap">
                                    <h4 class="text-center" style="color:var(--background-primary) !important;">Discover The Best Safari Deals</h4>
                                    <div class="joinshareView mt-md-0 mt-3">
                                        <a href="/package" class="btn_shareView pakage" data-pjax="0">View All</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-5">
                            <?php if ($packages) {
                                foreach ($packages as $package) { ?>

                                    <div class="col mb-lg-0 mb-3 padding_righ">
                                        <?= $this->render('@frontend/modules/package/views/default/_package_card', ['model' => $package]) ?>
                                    </div>

                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
<?php } ?>
<section class="px-md-0 px-3" style="display: none">
    <!-- <div class="google-ad-box margin-topset" style="border:none">

    </div> -->
</section>
<section class="safariduring_sesons paddiinTop_add">
    <?= \frontend\widgets\FeatureParkWidget::widget(['section_title' => $banner ? $banner->feature_park_title : '']) ?>
</section>
<section class="animal-wrapper  paddiinTop_add">
    <?= \frontend\widgets\RareExoticWidget::widget() ?>
</section>
<section class="px-md-0 px-3" style="display: none">
    <div class="google-ad-box margin-topset" style="border:none">

    </div>
</section>
<section class="articals_wrapper  margin_bottomfooter mb-5 paddiinTop_add">
    <?= $this->render('_featured_article', [
        'featured_articles' => $featured_articles,
    ]) ?>
</section>