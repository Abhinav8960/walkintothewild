<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafariIntrested;

$this->title = 'Home';
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
                        <h1>All Wildlife Safari Info, Multiple Operators, One Convenient Spot!</h1>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    <div class="tab-block" id="tab-block">
                        <ul class="tab-mnu">
                            <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="" class="me-2">Safari</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/birdingicon.png" alt="" width="29" class="me-2">Birding</li>
                            <!-- <li> <img src="<?= $this->params['baseurl'] ?>/img/resorticon.png" alt="" width="29" class="me-2"> Resort</li> -->
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
<?php if ($shared_safaries) { ?>

    <section class="sharesafri">
        <div class="container-lg padditg_mobile">
            <div class="row justify-content-center">
                <div class="col-xl-11 px-md-1 px-0">
                    <div class="sharesafribg home px-lg-0 px-2">
                        <div class="safarishareBox py-3">
                            <div class="row justify-content-center">
                                <div class="col-xxl-8 col-lg-12 col-xl-8">
                                    <div class="title_safari text-center pt-3">
                                        <h4>Discover and Join 100+ Shared Safaris</h4>
                                        <!-- <div class="joinshare">
                  <a href="" class="btn_share">JOIN SHARED SAFARI</a>
                </div> -->
                                    </div>
                                </div>

                            </div>
                            <div class="row pt-4 justify-content-center gx-lg-5">
                                <?php foreach ($shared_safaries as $share_safari) { ?>
                                    <div class="col-lg-4 col-sm-6 col-xxl-3 col-md-5 mb-4 px-lg-3 ">
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
                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>">Leave Safari</a>
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
<section class="animal-wrapper pb-4">
    <?= $this->render('_rare_exotic', [
        'rare_exotics' => $rare_exotics,
    ]) ?>
</section>
<section class="bg_sky">
    <div class="container-fluid">
        <div class="row px-xl-4">
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Safari Tour Operator</h6>
                        <?php if (Yii::$app->user->id) {  ?>

                            <div class="btn_r">
                                <a href="/safaritour-registration" class="btn_registrtion">Register Now</a>
                            </div>
                        <?php } else {
                            echo '<p style="color:white !important;">Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for register now</p>';
                        } ?>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img  position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100" loading="lazy">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Birding Tour Operator</h6>
                        <?php if (Yii::$app->user->id) {  ?>
                            <div class="btn_r">
                                <a href="/birdingtour-registration" class="btn_registrtion">Register Now</a>
                            </div>
                        <?php } else {
                            echo '<p style="color:white !important;">Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for register now</p>';
                        } ?>


                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="articals_wrapper  pb-5 mb-5">
    <?= $this->render('_featured_article', [
        'featured_articles' => $featured_articles,
    ]) ?>
</section>