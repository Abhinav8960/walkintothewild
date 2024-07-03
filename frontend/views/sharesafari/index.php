<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

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
                                        <a href=""><img src="<?= $this->params['baseurl'] ?>/img/jimcorbettsmall.jpg" alt="" class="w-100"></a>
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5><a href="Selected-Safari.html">Jim Corbett National Park</a></h5>
                                        <div class="date_bx">
                                            <h6>17 Oct 2024 - 17 Oct 2024</h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <strong>Dhawal Bharija (Wildlife
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
                                            <p class="mb-0">4 Safaris</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Available Seats - 4/6</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Photography</p>
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
                                            <p class="mb-0">7,000 - 9,000 Estimate Per Person Cost</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4 align-items-center gx-4">
                        <div class="col-lg-6">
                            <div class="btn_wrap">
                                <button class="intested_btn"><i class="fa-solid fa-user-group"></i> 12
                                    Interested</button>
                                <button class="join_btn ms-sm-3 mt-sm-0 mt-2"> Join Safari</button>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="social-share d-flex gap-2 align-items-center float-lg-end pt-lg-0 pt-3">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-3">
                                    <ul>
                                        <li><a href="" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li><a href="" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                        </li>
                                        <li><a href="" class="iconSize"><i class="fa-brands fa-x-twitter" ></i></a>
                                        </li>
                                        <li><a href="" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
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
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                        <div class="profileavtar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpinterested.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="right_button py-lg-5 py-3">
                    <button class="btn_newsafari w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Organize a New
                        Safari</button>
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
            <div class="col mb-4 padding_right">
                <div class="sharesafri-card">
                    <div class="flotingdate">
                        <div class="icons text-center">
                            <p class="mb-0">OCT</p>
                            <p class="mb-0">3</p>
                        </div>
                    </div>
                    <div class="shareimg">
                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                        <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                                <div class="safarinum d-flex gap-2 align-items-center ">
                                    <p class="text_safari">SAFARI</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                    <p class="text_safari">SEATS</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="titleDate">
                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                            <div class="orgnizer">
                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
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
                                        <a href="/sharesafari">Join Safari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4 padding_right">
                <div class="sharesafri-card">
                    <div class="flotingdate">
                        <div class="icons text-center">
                            <p class="mb-0">OCT</p>
                            <p class="mb-0">3</p>
                        </div>
                    </div>
                    <div class="shareimg">
                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                        <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                                <div class="safarinum d-flex gap-2 align-items-center ">
                                    <p class="text_safari">SAFARI</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                    <p class="text_safari">SEATS</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="titleDate">
                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                            <div class="orgnizer">
                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
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
                                        <a href="/sharesafari">Join Safari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4 padding_right">
                <div class="sharesafri-card">
                    <div class="flotingdate">
                        <div class="icons text-center">
                            <p class="mb-0">OCT</p>
                            <p class="mb-0">3</p>
                        </div>
                    </div>
                    <div class="shareimg">
                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                        <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                                <div class="safarinum d-flex gap-2 align-items-center ">
                                    <p class="text_safari">SAFARI</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                    <p class="text_safari">SEATS</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="titleDate">
                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                            <div class="orgnizer">
                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
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
                                        <a href="/sharesafari">Join Safari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4 padding_right">
                <div class="sharesafri-card">
                    <div class="flotingdate">
                        <div class="icons text-center">
                            <p class="mb-0">OCT</p>
                            <p class="mb-0">3</p>
                        </div>
                    </div>
                    <div class="shareimg">
                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                        <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                                <div class="safarinum d-flex gap-2 align-items-center ">
                                    <p class="text_safari">SAFARI</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                    <p class="text_safari">SEATS</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="titleDate">
                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                            <div class="orgnizer">
                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
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
                                        <a href="/sharesafari">Join Safari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4 padding_right">
                <div class="sharesafri-card">
                    <div class="flotingdate">
                        <div class="icons text-center">
                            <p class="mb-0">OCT</p>
                            <p class="mb-0">3</p>
                        </div>
                    </div>
                    <div class="shareimg">
                        <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                        <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                                <div class="safarinum d-flex gap-2 align-items-center ">
                                    <p class="text_safari">SAFARI</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                    <p class="text_safari">SEATS</p>
                                    <h6 class="number-safari">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="titleDate">
                            <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                            <div class="orgnizer">
                                <p>Organized by: <strong>Dhawal Bharija</strong></p>
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
                                        <a href="/sharesafari">Join Safari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
 
    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Orgnize a New Safari</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body modal_form">
                <div class="row">
                    <div class="col-12 mb-2">
                        <label for="" class="Modal_label">Select a Safari Park</label>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Select a Safari park</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="" class="Modal_label">Agenda</label>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Agenda</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="" class="Modal_label">Number of Safaris</label>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>No of Safari</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-2">
                        <div class="d-flex  gap-3 align-items-center w-100 mb-3">
                            <div class="start w-100">
                                <label for="" class="Modal_label">Start Date</label>
                                <input type="text" class="form-control w-100 " placeholder="1 Oct 2024">
                            </div>
                            <span class="pt-4">-</span>
                            <div class="start w-100">
                                <label for="" class="Modal_label">End Date</label>
                                <input type="text" class="form-control w-100 pe-1" placeholder="3 OCt 2024">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="" class="Modal_label">Stay Category</label>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Agenda</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label for="" class="Modal_label">Estimate Price Per Person</label>
                        <div class="d-flex  gap-3 align-items-center ">
                            <input type="number" class="form-control w-50 pe-1" placeholder="1000">
                            -
                            <input type="number" class="form-control w-50 pe-1" placeholder="2000">
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <div class="textarea">
                            <textarea name="" id="" class="form-control" placeholder="Write about your plan"></textarea>
                        </div>
                    </div>

                </div>
                <div class="row mt-2 pe-0">
                    <div class="col-lg-8">
                        <label for="" class="Modal_label">You Are?</label>
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Safari tour Oprator</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <div class="d-flex align-items-center gap-2">
                            <div class="selects w-100">
                                <label for="" class="Modal_label">Total Seat</label>
                                <select class="form-select form-select-lg" aria-label="Large select example">
                                    <option selected>6</option>
                                    <option value="1">7</option>
                                    <option value="2">8</option>
                                    <option value="3">10</option>
                                </select>
                            </div>
                            <div class="selects w-100">
                                <label for="" class="Modal_label">Share Seats</label>
                                <select class="form-select form-select-lg" aria-label="Large select example">
                                    <option selected>2</option>
                                    <option value="1">4</option>
                                    <option value="2">6</option>
                                    <option value="3">8</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 pt-4">
                        <div class="creat-safri">
                            <button class="safari_create">Create <br>Safari</button>
                        </div>
                    </div>
                </div>
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
              <div class="row">
                <div class="col-12">
                            <div class="selects w-100 d-flex align-items-center gap-3">
                                <label for="" class="Modal_label">Reason</label>
                                <select class="form-select form-select-lg" aria-label="Large select example">
                                    <option selected>6</option>
                                    <option value="1">7</option>
                                    <option value="2">8</option>
                                    <option value="3">10</option>
                                </select>
                            </div>
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                <label for="" class="Modal_label">Details</label>
                        <div class="textarea">
                            <textarea name="" id="" class="form-control" placeholder="Write about your plan"></textarea>
                        </div>
                </div>
                <div class="col-12">
                    <div class="btn_report float-end">
                       <div class="btn_report_cance">
                         <button data-bs-dismiss="modal" aria-label="Close" class="close_btns ">Cancel</button>
                         <button type="submit" class="btns_submit ">Report</button>
                       </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>