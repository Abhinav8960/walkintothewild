<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Fixed Departure';
$this->params['title'] = $this->title;

?>




<section class="safari_wrapper  bg-white pt-4">
    <div class="container-lg">
        <div class="row packageSfari">
            <div class="col-12">
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-8 col-md-8 border-right">
                            <div class="row">
                                <div class="col-3 col-sm-3 col-md-3 col-lg-2 maxWidth">
                                    <div class="safritimg innerImg">
                                        <img src="<?= isset($share_safari->safarioperator->imagepath) ? $share_safari->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-9 col-sm-9 col-md-9 col-lg-10 pt-sm-0 pt-3 maxWidth">
                                    <div class="safrititles">
                                        <div class="date_bx">
                                            <h6><span style="color:black;">Fixed Departure</span> <?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?> <?= isset($share_safari->cut_off_date) ? ' | <span style="color:black;">Cut off Date</span> ' . date('d M y', strtotime($share_safari->cut_off_date)) : '' ?> </h6>
                                        </div>
                                        <h6 class="titler_safari"><a href="#" data-pjax="0"><i class="fa-solid fa-location-dot me-1"></i> <?= $share_safari->park->title ?></a></h6>
                                        <p class="mb-0 pt-1">Organized by <a href="#" data-pjax="0"><strong><?= $share_safari->organizedbyname ?></strong></a></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="pakageCost text-center mb-3">
                                <h6 class="fs-5 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px"><?= number_format($share_safari->cost_per_person) ?> / <span class="perpersonText">Per Person</span></h6>
                            </div>

                        </div>
                        <div class="col-lg-4 pt-lg-0 pt-4">
                            <div class="row ps-1">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->tour_duration - 1 ?> Nights , <?= $share_safari->tour_duration ?> Days</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $pick_drop_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($pick_drop_includes) ? 'Included' : 'Not Included';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/newicon.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->no_of_safari ?> Shared Safari
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meals">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">
                                            <p class="mb-0"><?= $share_safari->meals ?></p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
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
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset(GeneralModel::budgetoption()[$share_safari->stay_category_id]) ?  GeneralModel::budgetoption()[$share_safari->stay_category_id] : 'Not Included'  ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 border_bottom2 pb-4">

                        <div class="col-lg-4 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mt-lg-0 mt-3">
                                <div class="pakageCost mb-2 mb-md-2 mb-xxl-0">
                                    <h6 class="fs-5 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px"><?= number_format($share_safari->cost_per_person) ?> / <span class="perpersonText">Per Person</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  mt-5 itenary_tabs">
                    <div class="col-lg-12 col-xl-11 safartabs position-relative">
                        <ul class="nav nav-tabs slider_packagemobile d-flex gap-2" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion-tab-pane" type="button" role="tab" aria-controls="discussion-tab-pane" aria-selected="true">DISCUSSION</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ITINERARY</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">INCLUSIONS</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#getting-there" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">GETTING THERE</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">POLICY INFO</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane" aria-selected="false" tabindex="-1">FAQ</button>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<section class="safari_wrapper mb-5 margin_bottomfooter">
    <div class="container-lg">
        <div class="row mb-lg-5  mt-5  itenary_tabs">
            <div class="col-lg-9 col-xl-9  safartabs position-relative">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item mb-3" id="discussion-tab-pane" role="tabpanel" aria-labelledby="discussion-tab">
                        <div class="accordion_disscutions">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Overview
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body profile-description">
                                            <div class="text show-more-height">
                                                <?= $share_safari->safari_plan ?>
                                            </div>
                                            <div class="show-more">See More</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <div class="itenary-title">
                                    <h6 class="fs-6 fw-bold " style="padding-bottom: 0 !important;">About Trip / Overview</h6>
                                </div>
                                <div class="itenary_text">
                                    <p><?= $share_safari->safari_plan ?></p>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('_overview', ['share_safari' => $share_safari]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <?= $this->render('_inclusion', ['share_safari' => $share_safari]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="getting-there" role="tabpanel" aria-labelledby="howto-reach">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <?= $this->render('_getting_there', ['share_safari' => $share_safari]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade  accordion-item mb-3" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                        <div class="policytabs">

                            <?= $this->render('_policy', ['share_safari' => $share_safari]) ?>

                        </div>
                    </div>
                    <div class="tab-pane fade  accordion-item mb-3" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab">
                        <div class="ff">
                            <div class="faqsss">
                                <?= $this->render('_faq', ['faqs' => $faqs]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="desclaimers pb-3 pt-lg-0 pt-3">
                    <div class="itenary-title">
                        <h6 class="fs-5 pb-2">Disclaimer</h6>
                    </div>
                    <div class="itenary_text">
                        <ul>
                            <li>This tour is operated by <strong><?= isset($share_safari->safarioperator) ? $share_safari->safarioperator->businessname : '' ?></strong> and not by Walk Into The Wild.</li>
                            <li><strong><?= isset($share_safari->safarioperator) ? $share_safari->safarioperator->businessname : '' ?></strong> reserves the right to adjust the rates advertised by Walk Into The Wild.</li>
                            <li>The specific itinerary, inclusions, and pricing of this tour are dependent on availability.</li>
                            <li>In the event that accommodations are fully booked, <strong><?= isset($share_safari->safarioperator) ? $share_safari->safarioperator->businessname : '' ?></strong> will propose a suitable alternative.</li>
                            <li>This tour is governed by the terms and conditions set forth by Walk Into The Wild.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 mb-lg-5 pb-lg-4">
                <div class="request_quote mb-4">
                    <button class="intested_btn  interestBtn modal_intrest" style="background-color: var(--background-primary) !important;" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i>
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
                                            <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user_intersted->user_handle]); ?>">
                                                <img src="<?= $user_intersted->profileimage <> '' ? $user_intersted->profileimage : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $intrested_user->user ? $intrested_user->user->name : '' ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <?php if ($share_safari->sharesafarigallery) {
                    $galleries = $share_safari->sharesafarigallery;
                ?>
                    <div class="request_quote photoGallry mb-4">
                        <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
                            Photo Gallery <span><?= count($galleries) ?></span>
                        </button>
                        <div class="interst_wrapper p-0 bg-white">
                            <div class="photoSlider owl-carousel owl-theme">
                                <?php foreach ($galleries as $gallery) { ?>
                                    <div class="items_img">
                                        <a href="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" data-fancybox="gallery" data-caption="No caption available" class="gallery-item">
                                            <img src="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" width="100%">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>



</section>


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

<div class="modal fade modal_enquiry" id="exampleModalenquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="modal-title fs-5 text-center pb-3" id="exampleModalLabel">Enquire</h1>
            </div>
            <div class="modal-body px-2 pt-0">
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
function enquiryfunction() {
	$('.enquiryBtn').on('click', function () {
        $('#exampleModalenquiry').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
enquiryfunction();
       

function interestfucntion() {
	$('.modal_intrest').on('click', function () {
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
    .disclaimer {
        top: 2375px;
        left: 303px;
        width: 687px;
        height: 148px;
        /* UI Properties */
        text-align: left;
        font: normal normal normal 16px/25px Roboto;
        letter-spacing: 0px;
        color: #151C2C;
        opacity: 1;


    }

    .tab-content {
        >.tab-pane {
            display: none;
        }

        >.active {
            display: block;
        }
    }
</style>