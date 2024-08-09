<?php

use common\models\sharesafari\ShareSafariIntrested;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\helpers\Url;

FrontAppAsset::register($this);
AppAsset::register($this);

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Share Safari Request';
$this->params['title'] = $this->title;
// echo '<pre>';
// print_r($share_safari_request);
// die();
?>

<div class="row my-4">
    <div class="col-12">
        <div class="btn_set float-end">
            <button class="history_btn" value="<?= Url::toRoute(['/sharesafari/request/approved', 'id' => $share_safari_request->id]) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?= $share_safari_request->approvallabel ?>" style="color:white;"><?= $share_safari_request->approvallabel ?></button>
        </div>
        <div class="wrapper-skybgsafri">
            <div class="row border_bottom2 pb-4">
                <div class="col-lg-7 col-md-8 border-right">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="safritimg">
                                <img src="<?= $share_safari_request->sharedimagepath ? $share_safari_request->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                            </div>
                        </div>
                        <div class="col-sm-10 pt-sm-0 pt-3">
                            <div class="safrititles">
                                <h5><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari_request->park->slug]) ?>"><?= $share_safari_request->park->title ?></a></h5>
                                <div class="date_bx">
                                    <h6><?= date('d M y', strtotime($share_safari_request->start_date)) ?> - <?= date('d M y', strtotime($share_safari_request->end_date)) ?></h6>
                                </div>
                                <p class="mb-0 pt-2">Organized by <a href="<?= $share_safari_request->website_url <> '' ? $share_safari_request->website_url : '#' ?>" <?= $share_safari_request->website_url <> '' ? 'target="_blank"' : '' ?>><strong><?= $share_safari_request->user->name ?>
                                            (<?= $share_safari_request->hosttype ?>)</strong></a></p>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-lg-none mobile_didplay_none">
                    <div class="btn_wrap d-flex flex-column ">

                        <?php if (Yii::$app->user->identity) {
                            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari_request->id, 'status' => 1])->limit(1)->one();
                            if ($share_safari_intrested) { ?>
                                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari_request->slug ?>"> Leave Safari</a>
                            <?php } else { ?>
                                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari_request->slug ?>">Join Safari</a>
                            <?php  }
                        } else { ?>
                            <a class="join_btn text-center mt-sm-0 mt-2" href="/site/login?authclient=google&referrer=/sharedsafari/<?= $share_safari_request->slug ?>"> Join Safari</a>
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
                                    <p class="mb-0"><?= $share_safari_request->no_of_safari ?> Safaris</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">Available Seats - <?= $share_safari_request->total_seat ?>/<?= $share_safari_request->share_seat ?></p>
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
                                                    if ($share_safari_request->share_safari_agenda_id == 1) {
                                                        echo "Photography";
                                                    } elseif ($share_safari_request->share_safari_agenda_id == 2) {
                                                        echo "Vlogging";
                                                    } elseif ($share_safari_request->share_safari_agenda_id == 3) {
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
                                    <p class="mb-0"><?= $share_safari_request->estimate_price_min ?>- <?= $share_safari_request->estimate_price_max ?> Estimate Per Person Cost</p>
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


<div class="modal fade" id="modalApprove" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Approval Form
                </h6>
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

    $('.history_btn').on('click', function () {
        $('#modalApprove').modal('show')
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