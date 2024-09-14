<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title =  'Shared Safari';
$this->params['title'] = $this->title; ?>

<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Shared Safari</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="safari_wrapper bg-white pt-4 pb-0 ">
    <!--    <div class="container-lg  px-slider2">
        <div class="wrapper-skybgsafri bg-white pb-0 px-slider2">
            <div class="row packageSfari ">
                <div class="col-12">
                    <div class="imagesSafari">
                    <img src="<?= $this->params['baseurl'] ?>/img/test.jpg" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="container-lg">
        <div class="row mb-4">
            <div class="col-12">
                <div class="wrapper-skybgsafri bg-white pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-8 col-md-8 border-right">
                            <div class="row">
                                <div class="col-3 col-sm-3 col-md-3 col-lg-2 maxWidth">
                                    <div class="safritimg innerImg">
                                        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-9 col-sm-9 col-md-9 col-lg-10 pt-sm-0 pt-3 maxWidth">
                                    <div class="safrititles 44">
                                        <h5><?= $share_safari->share_safari_title ?>
                                            <?php
                                            if (Yii::$app->user->identity) { ?>
                                                <?php
                                                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1])->limit(1)->one();
                                                if ($wishlist) {
                                                ?>
                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/unwishlist', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-pjax="0" data-method="POST" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/wishlist', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-pjax="0" data-method="POST" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <h6 class="titler_safari"><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari->park->slug]) ?>" data-pjax="0"><i class="fa-solid fa-location-dot me-1"></i> <?= $share_safari->park->title ?></a></h6>
                                        <?php
                                        if (Yii::$app->user->identity) { ?>
                                            <p class="mb-0 pt-1">Organized by <a href="<?= $share_safari->organizedbyprofileurl <> '' ? $share_safari->organizedbyprofileurl : '#' ?>" data-pjax="0"><strong><?= $share_safari->organizedbyname ?></strong></a></p><?php
                                                                                                                                                                                                                                                                } else { ?>
                                            <p class="mb-0 pt-1">Organized by <a href="/site/login?referrer=<?= Url::toRoute(['/profile/default/index', 'user_handle' => $share_safari->getOrganizedbyuserhandel()]) ?>" data-pjax="0"><strong><?= $share_safari->organizedbyname ?></strong></a></p><?php
                                                                                                                                                                                                                                                                                                    } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="right_button  ">
                                <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->type == 1) { ?>
                                    <button class="btn_newsafari organizeBtn " value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                        Safari</button>
                                <?php } ?>

                            </div>
                            <div class="btns-safaries">
                                <?php if ($share_safari->status == ShareSafari::STATUS_SUSPEND) { ?>
                                    <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-block" href="#">Closed Safari</a>
                                <?php } else if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) { ?>
                                    <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-block" href="#">No Seat Available</a>
                                    <?php } else {
                                    if (Yii::$app->user->identity) {
                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                        if ($share_safari_intrested) { ?>
                                            <a class="join_btn leavesafrai text-center mt-sm-0 mt-2 d-block" href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-method="POST" data-pjax="0"> Leave Safari</a>
                                        <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-block" href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-method="POST" data-pjax="0">Join Safari</a>
                                        <?php }
                                    } else { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-block" href="/site/login?authclient=google&referrer=<?= Url::toRoute([
                                                                                                                                                        '/sharedsafari/default/view',
                                                                                                                                                        'slug' => $share_safari->slug,
                                                                                                                                                        'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                                                                                                                                                    ]) ?>" data-pjax="0"> Join Safari</a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-lg-4 pt-lg-0 pt-4">
                            <div class="row px-sm-2 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/newicon.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->no_of_safari ?> Shared Safari</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Seats">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Available Seats - <?= $share_safari->share_seat ?>/<?= $share_safari->total_seat ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <?php if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 1) { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } else if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 3) { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } ?>
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">
                                                <?= isset(GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id]) ? GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id] : 'Not Included' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset(GeneralModel::budgetoption()[$share_safari->stay_category_id]) ? GeneralModel::budgetoption()[$share_safari->stay_category_id] : 'Not Included' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($share_safari->type == 1) { ?>
                                    <div class="col-12 ">
                                        <div class="safridetails_form d-flex gap-3 align-items-center">
                                            <div class="iconImg">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cost">
                                            </div>
                                            <div class="text-form">
                                                <p class="mb-0"><span class="font_span"><?= number_format($share_safari->estimate_price_min) ?>- <?= number_format($share_safari->estimate_price_max) ?></span> Estimate Per Person Cost</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if ($share_safari->type == 2) { ?>
                                    <div class="col-12 ">
                                        <div class="safridetails_form d-flex gap-3 align-items-center">
                                            <div class="iconImg">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="">
                                            </div>
                                            <div class="text-form">
                                                <p class="mb-0"><?= $share_safari->cost_per_person ?> Estimate Per Person Cost</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 pb-4">
                        <div class="col-lg-6">
                            <div class="social-share flex-wrap d-flex gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-xl-3">
                                    <?php
                                    $shared_url = urlencode(Url::to('', true));
                                    ?>
                                    <ul>
                                        <?= \frontend\widgets\ShareButton::widget([
                                            'style' => 'horizontal',
                                            'networks' => ['facebook', 'twitter', 'instagram', 'whatsapp', 'linkedin', 'telegram', 'clipboard'],
                                        ]); ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-lg-block  mobile_didplay_block">
                            <div class="btn_wrap float-lg-end pt-lg-0 pt-3 d-flex gap-2 align-items-center">
                                <div class="right_button  ">
                                    <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->type == 1) { ?>
                                        <button class="btn_newsafari organizeBtn " value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                            Safari</button>
                                    <?php } ?>

                                </div>
                                <div class="btns-safaries">
                                    <?php if ($share_safari->status == ShareSafari::STATUS_SUSPEND) { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-inline-block" href="#">Closed Safari</a>
                                    <?php } else if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-inline-block" href="#">No Seat Available</a>
                                        <?php } else {
                                        if (Yii::$app->user->identity) {
                                            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                            if ($share_safari_intrested) { ?>
                                                <a class="join_btn leavesafrai text-center mt-sm-0 mt-2 d-inline-block" href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-method="POST"> Leave Safari</a>
                                            <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                                <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-inline-block" href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-method="POST">Join Safari</a>
                                            <?php }
                                        } else { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2 d-inline-block" href="/site/login?authclient=google&referrer=<?= Url::toRoute([
                                                                                                                                                                    '/sharedsafari/default/view',
                                                                                                                                                                    'slug' => $share_safari->slug,
                                                                                                                                                                    'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                                                                                                                                                                ]) ?>"> Join Safari</a>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="advertisment my-4" style="display:none">
                        <div class="google-ad-box  ">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="safari_wrapper margin_bottomfooter pt-3">
    <div class="container-lg">
        <div class="row mb-5 pb-lg-5 pb-0">
            <?= $this->render('_comment', ['share_safari' => $share_safari, 'model' => $model, 'login_safarioperator' => $login_safarioperator]) ?>
            <div class="col-lg-3  mb-lg-0 mb-3">
                <button class="intested_btn interestBtn " style="background-color: var(--background-primary) !important;" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i>
                    Interested - <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?></button>
                <div class="interst_wrapper bg-white ">
                    <!-- <div class="titlerescent pb-3">
                        <h3>Intrested</h3>
                    </div> -->
                    <div class="users_profile d-flex gap-2 align-items-center flex-wrap">
                        <?php if ($intrested_users = $share_safari->getIntrested()->joinWith('user')->andWhere(['user.status' => 10, 'share_safari_intrested.status' => 1])->all()) {
                            foreach ($intrested_users as $intrested_user) {
                        ?>
                                <?php if ($user_intersted = $intrested_user->user) { ?>
                                    <div class="profileavtar">
                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user_intersted->user_handle]); ?>" data-pjax="0">
                                            <img src="<?= $user_intersted->profileimage <> '' ? $user_intersted->profileimage : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $intrested_user->user ? $intrested_user->user->name : '' ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                        <?php }
                        } ?>
                    </div>
                </div>

                <div class="advertisment pt-md-2 pt-5" style="padding-top: 2.5rem !important" >
                    <div class="google-ad-box  mb-5" style="border:none">
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-client="ca-pub-6116324330184807"
                            data-ad-slot="9287923659"
                            data-ad-format="auto"
                            data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                

            </div>
        </div>
        <div class="row pb-5 d-lg-none">
            <div class="col-12 text-center">
                <div class="joinshareView mt-md-0 mt-3">
                    <a href="/sharedsafari" class="btn_shareView pakage" data-pjax="0"> <i class="fa-solid fa-arrow-left me-2"></i> Back</a>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-12">
                <div class="footer_intrst d-lg-none d-block">
                    <div class="right_button py-lg-5 py-3">
                        <?php if ($share_safari->host_user_id == Yii::$app->user->id) { ?>
                            <button class="btn_newsafari organizeBtn w-100" value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                Safari</button>
                        <?php } elseif (Yii::$app->user->identity) { ?>
                            <button class="btn_newsafari organizeBtn w-100" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a New
                                Safari</button>
                        <?php } else {  ?>
                            <a class="join_btn ms-sm-3 mt-sm-0 mt-2 w-100" href="/site/auth?authclient=google">+ Organize a New
                                Safari</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> -->
        <?= $this->render('_recommended_safari_list', ['safari_park' => $share_safari->park, 'active_safari' => $share_safari]) ?>

    </div>
</section>


<!-- Modal -->

<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="history-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">History</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="interest-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Interest</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Report Content
                    <br>
                    <p>Please report inappropriate members and/or content to help our Trust & Safety team keep our Community safe for everyone.</p>
                </h6>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt=""></button>
            </div>

            <div class="modal-body modal_form">
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

function historyfucntion() {
	$('.history_btn').on('click', function () {
        $('#history-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
historyfucntion();

function interestfucntion() {
	$('.intested_btn').on('click', function () {
        $('#interest-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
interestfucntion();
const textContainer = $(".profile-description .text");
    const showMoreButton = $(".profile-description .show-more");
    const lineHeight = parseInt(textContainer.css('line-height'));

    const threeLinesHeight = lineHeight * 3;

    if (textContainer[0].scrollHeight > threeLinesHeight) {
        showMoreButton.show();
    }

    showMoreButton.click(function () {
        textContainer.toggleClass("show-more-height");
        if (textContainer.hasClass("show-more-height")) {
            $(this).text("See More");
        } else {
            $(this).text("See Less");
        }
    });
             
JS;
$this->registerJs($script);
?>

<style>
    .safari_completed {
        background-color: lightgreen;
        padding: 10px 20px;
        font-size: var(--fs-16);
        font-weight: 600;
        font-family: "Roboto", sans-serif !important;
        color: #152F1B;
        border: 0;
        border-radius: 8px;
        margin: 2px;
    }
</style>