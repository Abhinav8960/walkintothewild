<?php

use backend\assets\AppAsset;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;

use frontend\assets\FrontAppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

FrontAppAsset::register($this);
AppAsset::register($this);

$webasset = $this->assetManager->getBundle('\backend\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Share Safari';
if ($share_safari->status != ShareSafari::STATUS_DELETE) {
    $this->params['title'] = $this->title;
} else {
    $this->params['title'] = $this->title . ' <span style="color:red;">(' . htmlspecialchars($share_safari->delete_reason) . ')</span>';
}

?>

<div class="row my-4">
    <div class="col-12">

        <div class="wrapper-skybgsafri pb-0">
            <div class="row border_bottom2 pb-4">
                <div class="col-lg-7 col-md-8 border-right">
                    <div class="row">


                        <div class="col-md-3">
                            <div class="safritimg">
                                <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                            </div>

                        </div>
                        <div class="col-md-9 pt-sm-0 pt-3">
                            <div class="safrititles">
                                <a href="<?= Yii::$app->params['frontend_url'] . '/sharedsafari/' . $share_safari->organizedslug . '/' . $share_safari->slug  ?>">
                                    <h5><?= $share_safari->share_safari_title ?></h5>
                                </a>
                                <h6><?= $share_safari->park->title ?></h6>
                                <div class="date_bx">
                                    <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                </div>
                                <p class="mb-0 pt-2">Organized by <strong><?= isset($share_safari->user) ? $share_safari->user->name : '' ?>
                                        (<?= $share_safari->hosttype ?>)</strong></p>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-5 pt-lg-0 pt-4">
                    <div class="row px-sm-4 px-0">
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                                </div>

                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->no_of_safari ?> Safaris</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/car-seat_5102816.png" alt="">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">Available Seats - <?= $share_safari->total_seat ?>/<?= $share_safari->share_seat ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="">
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
                                    <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">Premium</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/rupee_3104891.png" alt="">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">
                                        <?php if ($share_safari->estimate_price_min == 0 && $share_safari->estimate_price_max == 0) { ?>
                                            <span class="font_span">Free</span>
                                        <?php } else if ($share_safari->estimate_price_min == $share_safari->estimate_price_max) { ?>
                                            <span class="font_span"><?= number_format($share_safari->estimate_price_min) ?></span>
                                            Estimate Per Person Cost
                                        <?php } else { ?>
                                            <span class="font_span"><?= number_format($share_safari->estimate_price_min) ?> - <?= number_format($share_safari->estimate_price_max) ?></span>
                                            Estimate Per Person Cost
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($share_safari->status != ShareSafari::STATUS_DELETE) { ?>
                <div class="row ">
                    <div class="col-12">
                        <div class="btn-delet float-end pt-4">
                            <button class="btn_userarticle" style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/sharesafari/default/share-safari-delete', 'id' => $share_safari->id]) ?>"><i class="fas fa-edit me-1"></i>Delete</button>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row ">
                    <div class="col-12">
                        <div class="float-end pt-2 m-2">
                            <a class="btn_userarticle" style="background:#09422d !important;color:white !important;padding: 10px 16px !important; border:0; border-radius:10px" href="<?= \yii\helpers\Url::toRoute(['/sharesafari/default/share-safari-active', 'id' => $share_safari->id]) ?>"><i class="fas fa-edit me-1"></i>Active</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
                                <img src="<?= $share_safari->hostUser && $share_safari->hostUser->avatar <> '' ? $share_safari->hostUser->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr"><?= isset($share_safari->hostUser) ? $share_safari->hostUser->name : '' ?></h6>
                                <?php if ($share_safari->safari_plan) { ?>
                                    <p><?= $share_safari->safari_plan; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="comment-wrapper" id="comment-wrapper-section">
    <?= $this->render('_comment', [
        'share_safari' => $share_safari,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]) ?>
</div>

<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS


    
function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();

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