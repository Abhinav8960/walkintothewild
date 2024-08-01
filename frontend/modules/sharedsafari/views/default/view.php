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

$this->title = 'Safari Tour Operator Registration';
$this->params['title'] = $this->title;
?>

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
                        <h1>Join or Organize a Sharing Safari</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="safari_wrapper bg-white pt-3 pb-0">
    <div class="container-lg">
        <div class="row my-4">
            <div class="col-12">
                <!-- <div class="btn_set float-end">
                    <button class=" history_btn" value="<?= Url::toRoute(['/sharedsafari/default/history', 'share_safari_id' => $share_safari->id]) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View History"><i class="fas fa-history"></i></i></button>
                </div> -->
                <div class="wrapper-skybgsafri bg-white">
                    <div class="row packageSfari pb-3">
                        <div class="col-12">
                            <div class="imagesSafari">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100">
                            </div>
                        </div>
                    </div>
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="safritimg innerImg">
                                        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles 44">
                                        <h5><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari->park->slug]) ?>"><?= $share_safari->park->title ?></a>
                                            <?php
                                            if (Yii::$app->user->identity) { ?>
                                                <?php
                                                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1])->limit(1)->one();
                                                if ($wishlist) {
                                                ?>
                                                    <a href="/sharedsafari/unwishlist/<?= $share_safari->slug ?>" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                <?php } else { ?>
                                                    <a href="/sharedsafari/wishlist/<?= $share_safari->slug ?>" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <a href="<?= $share_safari->organizedbyprofileurl <> '' ? $share_safari->organizedbyprofileurl : '#' ?>"><strong><?= $share_safari->organizedbyname ?></strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->status != 2) { ?>
                                    <?= Html::a('Mark as Completed', ['completed', 'slug' => $share_safari->slug], [
                                        'class' => 'join_btn text-center mt-sm-0 mt-2 d-block',
                                        'style' => 'background-color:green; color:white;',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to Completed this Safari?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                <?php } ?>

                                <?php if ($share_safari->status == 2) { ?>
                                    <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="#">Closed Safari</a>
                                    <?php } else {
                                    if (Yii::$app->user->identity) {
                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                        if ($share_safari_intrested) { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                                        <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                        <?php }
                                    } else { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
                                <?php }
                                } ?>

                            </div>
                            <div class="right_button  mt-2">
                                <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->type == 1) { ?>
                                    <button class="btn_newsafari organizeBtn " value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                        Safari</button>
                                <?php } else if (false && $share_safari->host_user_id == Yii::$app->user->id && $share_safari->type == 2) { ?>
                                    <button class="btn_newsafari organizeBtn " value="<?= Url::toRoute(['/sharedsafari/default/update-fixed-departure', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                        Fixed Departure</button>
                                <?php } else if (!Yii::$app->user->identity) {  ?>
                                    <a class="btn_newsafari organizeBtn" href="/site/auth?authclient=google">+ Organize a New
                                        Safari</a>
                                <?php } ?>


                            </div>
                        </div>
                        <div class="col-lg-5 pt-lg-0 pt-4">
                            <div class="row px-sm-4 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/safari_4391688.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->no_of_safari ?> Safaris</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Available Seats - <?= $share_safari->share_seat ?>/<?= $share_safari->total_seat ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            if ($share_safari->share_safari_agenda_id == 1) {
                                                                echo "Photography";
                                                            } elseif ($share_safari->share_safari_agenda_id == 2) {
                                                                echo "Vlogging";
                                                            } elseif ($share_safari->share_safari_agenda_id == 3) {
                                                                echo "Safari Experience";
                                                            } ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/resort_11834952.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            if ($share_safari->stay_category_id == 1) {
                                                                echo "Budget";
                                                            } elseif ($share_safari->stay_category_id == 2) {
                                                                echo "Economical";
                                                            } elseif ($share_safari->stay_category_id == 3) {
                                                                echo "Premium";
                                                            } ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($share_safari->type == 1) { ?>
                                    <div class="col-12 ">
                                        <div class="safridetails_form d-flex gap-3 align-items-center">
                                            <div class="iconImg">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="">
                                            </div>
                                            <div class="text-form">
                                                <p class="mb-0"><?= $share_safari->estimate_price_min ?>- <?= $share_safari->estimate_price_max ?> Estimate Per Person Cost</p>
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
                    <div class="row pt-md-4 align-items-center gx-4">

                        <div class="col-lg-6">
                            <div class="social-share d-flex gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-3">
                                    <?php
                                    $shared_url = urlencode(Url::to('', true));
                                    ?>
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li><a href="https://wa.me/?text=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                        </li>
                                        <li><a href="https://twitter.com/intent/tweet?url=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-linkedin-in"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-telegram"></i></a>
                                        </li>

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
                                    <?php } else if (false && $share_safari->host_user_id == Yii::$app->user->id && $share_safari->type == 2) { ?>
                                        <button class="btn_newsafari organizeBtn " value="<?= Url::toRoute(['/sharedsafari/default/update-fixed-departure', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                            Fixed Departure</button>
                                    <?php } else if (!Yii::$app->user->identity) {  ?>
                                        <a class="btn_newsafari organizeBtn" href="/site/auth?authclient=google">+ Organize a New
                                            Safari</a>
                                    <?php } ?>


                                </div>
                                <div class="btns-safaries">
                                    <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->status != 2) { ?>
                                        <?= Html::a('Mark as Completed', ['completed', 'slug' => $share_safari->slug], [
                                            'class' => 'join_btn text-center mt-sm-0 mt-2',
                                            'style' => 'background-color:green; color:white;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to Completed this Safari?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    <?php } ?>

                                    <?php if ($share_safari->status == 2) { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="#">Closed Safari</a>
                                        <?php } else {
                                        if (Yii::$app->user->identity) {
                                            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                            if ($share_safari_intrested) { ?>
                                                <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                                            <?php } else if ($share_safari->host_user_id != Yii::$app->user->identity->id) { ?>
                                                <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                            <?php }
                                        } else { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
                                    <?php }
                                    } ?>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="safari_wrapper margin_bottomfooter pt-3">
    <div class="container-lg">
        <div class="row mb-5 pb-5">
            <?= $this->render('_comment', ['share_safari' => $share_safari, 'model' => $model, 'replymodel' => $replymodel]) ?>


            <div class="col-lg-3 order-lg-2 order-1 mb-lg-0 mb-3">
                <button class="intested_btn interestBtn " style="background-color: var(--background-primary) !important;" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i>
                    Interested - <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?></button>
                <div class="interst_wrapper bg-white " style="min-height: 200px;">
                    <!-- <div class="titlerescent pb-3">
                        <h3>Intrested</h3>
                    </div> -->
                    <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                        <?php if ($intrested_users = $share_safari->getIntrested()->where(['status' => 1])->all()) {
                            foreach ($intrested_users as $intrested_user) {
                        ?>
                                <div class="profileavtar">
                                    <img src="<?= $intrested_user->user && $intrested_user->user->avatar <> '' ? $intrested_user->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $intrested_user->user ? $intrested_user->user->name : '' ?>">
                                </div>

                        <?php }
                        } ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
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
        </div>
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