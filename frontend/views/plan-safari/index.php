<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafariIntrested;

$this->title = 'Plan Safari';
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
<?php if ($shared_safaries) { ?>

    <section class="sharesafri">
        <div class="container-lg padditg_mobile">
            <div class="row justify-content-center ">
                <div class="col-xl-11  px-md-1 px-0 ">
                    <div class="sharesafribg home px-lg-0 px-2">
                        <div class="safarishareBox py-3 pb-5">
                            <div class="row justify-content-center">
                                <div class="col-xxl-3">

                                </div>
                                <div class="col-xxl-9 col-lg-12 col-xl-12">
                                    <div class="title_safari JoinPadding d-flex justify-content-center justify-content-md-between align-items-center flex-wrap">
                                        <h4 class="text-center ps-4">Discover and Join 100+ Shared Safaris</h4>
                                        <div class="joinshareView mt-md-0 mt-3 pe-lg-4">
                                            <a href="/sharedsafari" class="btn_shareView">View All</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row postion_setsfari  pe-lg-4 ps-lg-3 ps-xxl-5 padding_mobileAdded">
                                <div class="col-lg-12 col-sm-12 col-xxl-3 col-md-12 mb-4"></div>
                                <?php foreach ($shared_safaries as $share_safari) { ?>
                                    <div class="col-lg-4 col-sm-6 col-xxl-3 col-md-6 mb-4 ">
                                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
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

<?php if ($packages) { ?>
    <section class="sharesafri">
        <div class="container-lg  padditg_mobile">
            <div class="row justify-content-center">
                <div class="col-xl-11 px-md-1 px-0">
                    <div class="PackageBox_home p-sm-4">
                        <div class="row justify-content-left">
                            <div class="col-xxl-12 col-lg-12 col-xl-12 pb-3">
                                <div class="title_safari JoinPadding d-flex justify-content-left justify-content-md-between align-items-left flex-wrap">
                                    <h4 class="text-center" style="color:var(--background-primary) !important;">Discover The Best Safari Deal</h4>
                                    <div class="joinshareView mt-md-0 mt-3">
                                        <a href="/package" class="btn_shareView pakage">View All</a>
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

<section class="safariduring_sesons paddiinTop_add">
    <?= \frontend\widgets\FeatureParkWidget::widget(['section_title' => $banner ? $banner->feature_park_title : '']) ?>
</section>
<section class="animal-wrapper  paddiinTop_add">
    <?= \frontend\widgets\RareExoticWidget::widget() ?>
</section>
<section class="articals_wrapper  margin_bottomfooter mb-5 paddiinTop_add">
    <?= $this->render('_featured_article', [
        'featured_articles' => $featured_articles,
    ]) ?>
</section>