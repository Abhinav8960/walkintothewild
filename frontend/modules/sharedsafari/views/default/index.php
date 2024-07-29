<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;

$this->title = 'Share Safari';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();


?>

<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/banner-share.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/banner-share.png" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Join or Organize a Sharing Safari</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row justify-content-center ">
            <div class="col-lg-6 mb-4 d-lg-block d-none">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4 justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4">
                        <div class="right_button mb-3">
                            <?php if (Yii::$app->user->identity) { ?>
                                <button class="btn_newsafari organizeBtn newbg" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a New
                                    Safari</button>
                            <?php } else {  ?>
                                <a class="btn_newsafari organizeBtn newbg d-block text-center" href="/site/auth?authclient=google">+ Organize a New
                                    Safari</a>
                            <?php } ?>
                        </div>
                        <div id="targetDiv">
                            <?= $this->render('filter_search', [
                                'searchModel' => $searchModel,
                                'device' => $device,

                            ]) ?>

                        </div>
                        <div class="advertisment pt-md-5 ">
                            <p class="text-center">ADVERTISMENT</p>
                            <div class="advertisment_box-2">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-xxl-10 pe-lg-0">
                        <div class="row ">
                            <div class="col-12  mb-xl-4 mb-3">
                                <div class="tag-container">

                                    <?php if ($searchModel->park_id) {
                                        $selected_park = $searchModel->parkoption[$searchModel->park_id];
                                        if ($selected_park) { ?>
                                            <div class="tag"><?= $selected_park ?> <span class="close-btn remove_dropdown_filter" data-attribute="park_id">×</span></div>
                                    <?php }
                                    } ?>

                                    <?php if ($searchModel->month_id) {
                                        $selected_month = GeneralModel::monthoption()[$searchModel->month_id];
                                        if ($selected_month) { ?>
                                            <div class="tag"><?= $selected_month ?> <span class="close-btn remove_dropdown_filter" data-attribute="month_id">×</span></div>
                                    <?php }
                                    } ?>


                                    <?php if ($searchModel->stay_category_id) {
                                        foreach ($searchModel->stay_category_id as  $stay_category_id) {
                                            $selected_price = GeneralModel::budgetoption()[$stay_category_id];
                                            if ($selected_price) {
                                    ?>
                                                <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $stay_category_id ?>" data-attribute="stay_category_id">×</span></div>

                                    <?php }
                                        }
                                    } ?>

                                    <?php if ($searchModel->estimated_price_filter) {
                                        foreach ($searchModel->estimated_price_filter as  $estimated_price_filter) {
                                            $selected_price = GeneralModel::estimatedpriceoption()[$estimated_price_filter];
                                            if ($selected_price) {
                                    ?>
                                                <div class="tag">Rs. <?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $estimated_price_filter ?>" data-attribute="estimated_price_filter">×</span></div>

                                    <?php }
                                        }
                                    } ?>

                                    <?php if ($searchModel->host_type) {
                                        foreach ($searchModel->host_type as  $host_type) {
                                            $selected_price = GeneralModel::hostoption()[$host_type];
                                            if ($selected_price) {
                                    ?>
                                                <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $host_type ?>" data-attribute="host_type">×</span></div>

                                    <?php }
                                        }
                                    } ?>


                                    <?php if ($searchModel->share_safari_agenda_id) {
                                        foreach ($searchModel->share_safari_agenda_id as  $share_safari_agenda_id) {
                                            $selected_price = GeneralModel::agendaoption()[$share_safari_agenda_id];
                                            if ($selected_price) {
                                    ?>
                                                <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $share_safari_agenda_id ?>" data-attribute="share_safari_agenda_id">×</span></div>

                                    <?php }
                                        }
                                    } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="topfilter d-lg-flex d-none justify-content-between align-items-center w-100">
                                    <div class="left_text">
                                        <p>There are currently <strong><?= count($models) ?> </strong> active shared safaris created by individuals</p>
                                    </div>
                                    <?= $this->render('sort_by_month', ['searchModel' => $searchModel]) ?>
                                </div>
                                <div class="top_mobilefilter mb-3 d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
                                    <div class="left_text">
                                        <p class="mb-0">There are currently <strong><?= $dataProvider->totalcount ?></strong> active shared safaris created by individuals</p>
                                    </div>
                                    <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
                                        <div class="input_check pb-0">
                                            <div class="filter_searchbox">
                                                <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">

                            <?php if ($models = $dataProvider->models) {
                                foreach ($models as $share_safari) {
                            ?>
                                    <div class="col mb-4 padding_righ">
                                        <div class="sharesafri-card">
                                            <div class="flotingdate">
                                                <div class="icons text-center">
                                                    <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                    <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                                </div>
                                            </div>
                                            <!-- <div class="floating-watchlist">
                                                <?php
                                                if (Yii::$app->user->identity) { ?>
                                                    <div class="heart_bx">
                                                        <?php
                                                        $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => 2, 'status' => 1])->limit(1)->one();
                                                        if ($wishlist) {
                                                        ?>
                                                            <a href="/sharedsafari/unwishlist/<?= $share_safari->slug ?>" style="color:#FD5634;"><i class="fa-solid fa-heart"></i></a>
                                                        <?php } else { ?>
                                                            <a href="/sharedsafari/wishlist/<?= $share_safari->slug ?>" style="color:black;"><i class="fa-regular fa-heart"></i></a>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div> -->
                                            <?php if ($share_safari->type == 2) { ?>
                                                <div class="fixed-depart">
                                                    <p>Fixed Departure</p>
                                                </div>
                                            <?php } ?>

                                            <div class="shareimg">
                                                <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                            </div>
                                            <div class="card_body">
                                                <?php
                                                $class = '';
                                                if (Yii::$app->user->identity) {
                                                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                    if ($share_safari_intrested) {
                                                        $class = 'background-color: #007BFF;';
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
                                                    <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= $share_safari->park->title ?></a></h6>
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
                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>" style="background-color: #007BFF;">Leave Safari</a>
                                                                        <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                                        <?php  }
                                                                    } else { ?>
                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
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

        </div>

    </div>

</section>

<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>



<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Organize a New Safari</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>




<?php
$script = <<< JS
function organizefunction() {
	$('.organizeBtn').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();

JS;
$this->registerJs($script);
?>