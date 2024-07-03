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
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <div class="wrapper-skybgsafri">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 border-right">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="safritimg">
                                        <a href=""><img src="<?= isset($share_safari->park) && isset($share_safari->park->logo) ? $share_safari->park->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100"></a>
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari->park->slug]) ?>"><?= $share_safari->park->title ?></a></h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                                Influencer)</strong></p>
                                    </div>

                                </div>
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
                        <div class="col-lg-6">
                            <div class="btn_wrap">
                                <button class="intested_btn"><i class="fa-solid fa-user-group"></i> <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?>
                                    Interested</button>
                                <?php if (Yii::$app->user->identity) {
                                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                    if ($share_safari_intrested) { ?>
                                        <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Unjoin Safari</a>
                                    <?php } else { ?>
                                        <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                                    <?php  }
                                } else { ?>
                                    <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="social-share d-flex gap-2 align-items-center float-lg-end pt-lg-0 pt-3">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-3">
                                    <?php
                                    $shared_url = urlencode(Url::to('', true));
                                    ?>
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shared_url ?>" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li><a href="https://wa.me/?text=<?= $shared_url ?>" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                        </li>
                                        <li><a href="https://twitter.com/intent/tweet?url=<?= $shared_url ?>" class="iconSize"><i class="fa-brands fa-x-twitter" style="color: black;"></i></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="comments_safari">
                    <div class="top_replysafari">
                        <div class="comments-persons">
                            <div class="postcomment d-flex gap-2">
                                <div class="avatar">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                </div>
                                <div class="text_com">
                                    <h6 class="nameavatr">Gufran Ahmad</h6>
                                    <p>Oh, that sounds amazing! I've always wanted to experience the thrill of
                                        seeing
                                        wild animals up close.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="commentsOther  position-relative">
                        <div class="objec-flgs">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" data-bs-toggle="modal" data-bs-target="#modalFlag">
                        </div>
                        <div class="postcomment d-flex gap-2 pt-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr">Gufran Ahmad</h6>
                                    <button class="request_btn">Request Contact</button>
                                </div>
                                <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                                    wild animals up close.</p>
                            </div>
                        </div>
                    </div>
                    <div class="commentsOther position-relative">
                        <div class="objec-flgs">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                        </div>
                        <div class="postcomment d-flex gap-2 pt-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr">Amit</h6>
                                    <button class="request_btn">Request Contact</button>
                                </div>
                                <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                                    wild animals up close.</p>
                            </div>
                        </div>
                    </div>
                    <div class="commentsOther position-relative">
                        <div class="objec-flgs">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                        </div>
                        <div class="postcomment d-flex gap-2 pt-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr">vimal</h6>
                                    <button class="request_btn">Request Contact</button>
                                </div>
                                <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                                    wild animals up close.</p>
                            </div>
                        </div>
                    </div>
                    <div class="commentsOther position-relative">
                        <div class="objec-flgs">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                        </div>
                        <div class="postcomment d-flex gap-2 pt-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr">Rakesh</h6>
                                    <button class="request_btn">Request Contact</button>
                                </div>
                                <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                                    wild animals up close.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="comments-persons pe-0 pt-4">
                    <div class="postcomment d-flex gap-3">
                        <div class="avatar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                        </div>
                        <div class="text-area">
                            <textarea name="" class="form-control w-100" placeholder="Write a comment..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end pt-3">
                    <div class="col-lg-9 col-xl-8">
                        <div class="post_text">
                            <p>Commenting on this thread will notify all event attendees via email and will also be visible to
                                everyone viewing the event.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3 ">
                        <div class="comment_button float-end mb-lg-0 mb-3">
                            <button class="post-comment">Post Comment</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="interst_wrapper">
                    <div class="titlerescent pb-3">
                        <h3>Intrested</h3>
                    </div>
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
                <div class="right_button py-lg-5 py-3">
                    <?php if ($share_safari->host_user_id == Yii::$app->user->identity->id) { ?>
                        <button class="btn_newsafari organizeBtn w-100" value="<?= Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) ?>">+ Update
                            Safari</button>
                    <?php } ?>
                </div>
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box-2">

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
                            <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $safari->slug]) ?>"><img src="<?= isset($safari->park) && isset($safari->park->logo) ? $safari->park->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
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
                                        <h6 class="number-safari"><?= $safari->total_seat ?></h6>
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
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                        <div class="roundes_countuser">
                                            15+
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="safari text-center">
                                        <div class="joinsafari">
                                            <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $safari->slug]) ?>">Join Safari</a>
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
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
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