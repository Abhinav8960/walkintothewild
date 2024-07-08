<?php

use common\interfaces\StatusInterface;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Safari Tour Operator Registration';
$this->params['title'] = $this->title;
?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Join or Organize a Sharing Safari</h1>
                        <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="safari_wrapper py-3">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-7 mb-4 pb-lg-0 pb-2">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <div class="btn_set float-end">
                    <button class=" history_btn" value="<?= Url::toRoute(['/sharedsafari/default/history', 'slug' => $share_safari->slug]) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View History"><i class="fas fa-history"></i></i></button>
                </div>
                <div class="wrapper-skybgsafri">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="safritimg">
                                        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari->park->slug]) ?>"><?= $share_safari->park->title ?></a></h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <a href="<?= $share_safari->website_url <> '' ? $share_safari->website_url : '#' ?>" <?= $share_safari->website_url <> '' ? 'target="_blank"' : '' ?>><strong><?= $share_safari->user->name ?>
                                                    (<?= $share_safari->hosttype ?>)</strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="btn_wrap d-flex flex-column ">
                                <button class="intested_btn interestBtn mb-2" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i> <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?>
                                    Interested</button>

                                <?php if ($share_safari->status == 2) { ?>
                                    <a class="join_btn text-center mt-sm-0 mt-2" href="#">Closed Safari</a>
                                    <?php } else {
                                    if (Yii::$app->user->identity) {
                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                        if ($share_safari_intrested) { ?>
                                            <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                                        <?php } else { ?>
                                            <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                        <?php  }
                                    } else { ?>
                                        <a class="join_btn text-center mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
                                <?php }
                                } ?>

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
                                            <p class="mb-0">Available Seats - <?= $share_safari->total_seat ?>/<?= $share_safari->share_seat ?></p>
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
                                            <p class="mb-0">Premium</p>
                                        </div>
                                    </div>
                                </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4 align-items-center gx-4">
                        <div class="col-lg-6 d-lg-block  mobile_didplay_block">
                            <div class="btn_wrap">
                                <button class="intested_btn interestBtn" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i> <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?>
                                    Interested</button>
                                <?php if ($share_safari->status == 2) { ?>
                                    <a class="join_btn text-center mt-sm-0 mt-2" href="#">Closed Safari</a>
                                    <?php } else {
                                    if (Yii::$app->user->identity) {
                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                        if ($share_safari_intrested) { ?>
                                            <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                                        <?php } else { ?>
                                            <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                        <?php  }
                                    } else { ?>
                                        <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                <?php }
                                } ?>

                            </div>

                        </div>
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

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-lg-block  mobile_didplay_block">
                            <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                            
                                <?php if (Yii::$app->user->identity) {
                                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                    if ($share_safari_intrested) { ?>
                                        <a class="join_btn  mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                                    <?php } else { ?>
                                        <a class="join_btn  mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                    <?php  }
                                } else { ?>
                                    <a class="join_btn  mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                <?php } ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= $this->render('_comment', ['share_safari' => $share_safari, 'model' => $model, 'replymodel' => $replymodel]) ?>
            <div class="col-lg-3 order-lg-2 order-1 mb-lg-0 mb-3">
             <button class="intested_btn interestBtn " value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i> <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?>
                                    Interested</button>
                <div class="interst_wrapper">
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
                <div class="right_button py-lg-5 py-3 d-lg-block d-none">
                    <?php if ($share_safari->host_user_id == Yii::$app->user->id) { ?>
                        <button class="btn_newsafari organizeBtn w-100" value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                            Safari</button>
                    <?php } elseif (Yii::$app->user->identity) { ?>
                        <button class="btn_newsafari organizeBtn" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a New
                            Safari</button>
                    <?php } else {  ?>
                        <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/site/auth?authclient=google">+ Organize a New
                            Safari</a>
                    <?php } ?>
                </div>
                <div class="advertisment d-lg-block d-none">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box-2">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="footer_intrst d-lg-none d-block">
                    <div class="right_button py-lg-5 py-3">
                        <?php if ($share_safari->host_user_id) { ?>
                            <button class="btn_newsafari organizeBtn w-100" value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit"></i>Update
                                Safari</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid">
        <div class="row mt-4 pt-4">
            <div class="col-12">
                <div class="col-12">
                    <div class="title_web">
                        <h2>Shared safaris <br>you might be interested </h2>
                    </div>
                </div>
            </div>

        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-3 g-lg-5 mb-5 pb-5">
            <?php $rand_safari = ShareSafari::find()->where(['status' => StatusInterface::STATUS_ACTIVE])->orderBy('RAND()')->limit(5)->all();
            foreach ($rand_safari as $safari) { ?>
                <div class="col mb-4 padding_right">
                    <div class="sharesafri-card">
                        <div class="flotingdate">
                            <div class="icons text-center">
                                <p class="mb-0"><?= date('M', strtotime($safari->start_date)) ?></p>
                                <p class="mb-0"><?= date('d', strtotime($safari->start_date)) ?></p>
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
                                        <h6 class="number-safari"><?= $safari->no_of_safari ?></h6>
                                    </div>
                                    <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                        <p class="text_safari">SEATS</p>
                                        <h6 class="number-safari"><?= $safari->share_seat ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="titleDate">
                                <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $safari->slug]) ?>"><?= $safari->park->title ?></a></h6>
                                <div class="orgnizer">
                                    <p>Organized by: <strong><?= $safari->user->name ?></strong></p>
                                </div>
                            </div>
                            <div class="footer_card row pb-2 px-2 align-items-center">

                                <div class="col-6">
                                    <div class="users">
                                        <?php if ($interests = $safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                            $count = $safari->getIntrested()->count();
                                            $avatar_count = 3;
                                            foreach ($interests as $interest) {
                                        ?>
                                                <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                            <?php
                                            }
                                        };
                                        $count = $safari->getIntrested()->count();
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
                                                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $safari->id, 'status' => 1])->limit(1)->one();
                                                if ($share_safari_intrested) { ?>
                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $safari->slug]) ?>">Leave Safari</a>
                                                <?php } else { ?>
                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $safari->slug]) ?>">Join Safari</a>
                                                <?php  }
                                            } else { ?>
                                                <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $safari->slug]) ?>">Join Safari</a>
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