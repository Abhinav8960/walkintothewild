<?php

use common\models\sharesafari\ShareSafariIntrested;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\helpers\Url;

FrontAppAsset::register($this);
AppAsset::register($this);

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Share Safari';
$this->params['title'] = $this->title;
?>

<div class="row my-4">
    <div class="col-12">
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

                        <?php if (Yii::$app->user->identity) {
                            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                            if ($share_safari_intrested) { ?>
                                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>"> Leave Safari</a>
                            <?php } else { ?>
                                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>">Join Safari</a>
                            <?php  }
                        } else { ?>
                            <a class="join_btn text-center mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
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

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-9 order-lg-1 order-2">
        <div class="comments_safari">
            <div class="top_replysafari">
                <?php
                if ($share_safari->host_user_id) { ?>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-2">
                            <div class="avatar">
                                <img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr"><?= $share_safari->user->name ?></h6>
                                <?php if ($share_safari->safari_plan) { ?>
                                    <p><?= $share_safari->safari_plan; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="commentsOther  position-relative">
                <?php if ($parent_comments = $share_safari->getComments()->where("parent_id IS NULL")->andWhere(['status' => 1])->all()) {
                    foreach ($parent_comments as $comments) {
                        $replies = $comments->getReplies()->where(['status' => 1])->all();

                ?>
                        <div class="objec-flgs">
                            <?php if (Yii::$app->user->id) {  ?>
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharesafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $comments->id]) ?>">
                            <?php } ?>

                        </div>
                        <div class="postcomment d-flex gap-2 pt-3 w-100">
                            <div class="avatar">
                                <img src="<?= $comments->user && $comments->user->avatar <> '' ? $comments->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr"><?= $comments->user->name ?></h6>
                                </div>
                                <p><?= $comments->comment ?></p>
                            </div>
                        </div>
                        <div class="comment-reply">
                            <?php if ($replies) { ?>
                                <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2 toggle-replies" data-target="comment-container-<?= $comments->id ?>">View <?= count($replies) ?> replies</h6>
                                <div class="blog-comment-container" id="comment-container-<?= $comments->id ?>" style="display: none;">
                                    <!-- <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2">Replies</h6> -->
                                    <?php foreach ($replies as $reply) { ?>
                                        <div class="blog-comment-text ms-lg-4 ms-2 position-relative w-100 flags_reply" style="border:none;">
                                            <div class="d-flex gap-2">
                                                <div class="avatar">
                                                    <img src="<?= $reply->user && $reply->user->avatar <> '' ? $reply->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                                                </div>
                                                <div class="font-color">
                                                    <span class="comment-author"><a href=""><?= $reply->user->name ?></a></span>
                                                    <span class="comment-date"><a href=""><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i A", $reply->created_at) ?> </a></span>
                                                    <div class="comment-text">
                                                        <p><?= $reply->comment ?></p>
                                                    </div>
                                                    <?php if (Yii::$app->user->id) {  ?>
                                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharesafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $reply->id]) ?>">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                <?php
                    }
                } ?>
            </div>
        </div>
    </div>
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
    </div>
</div>

<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    List of flags
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


    
function writeareviewfunction() {
    $('.flagBtn').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();
        $('.toggle-replies').click(function() {
        var target = $(this).data('target');
        var container = $('#' + target);
        var isVisible = container.is(':visible');
        container.slideToggle();
        $(this).text(isVisible ? 'View replies' : 'Hide replies');
    });   
          
             
JS;
$this->registerJs($script);
?>