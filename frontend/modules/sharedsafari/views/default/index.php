<?php


/* @var $this yii\web\View */

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use frontend\models\ArticleSearch;

$this->title = 'Share Safari';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();

?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/banner-share.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/banner-share.png" class="d-block w-100 " alt="banner">
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
<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-4 col-xl-3 col-xxl-2  mb-4">
                <div class="filter-wrapper ">
                    <div class="title_top pb-4">
                        <h4>Select Filters</h4>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Month</h6>
                        <div class="input_check ">

                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>October</option>
                                <option value="1">January</option>
                                <option value="2">Febraury</option>
                                <option value="3">March</option>
                            </select>
                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>No. Of Safaris</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">2</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">4</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">6+</label>

                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Agenda</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Photography</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Vlogging</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Safari Experience</label>

                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Host</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Individual</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Wildlife Photographer</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Wildlife Influencer</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Safari Tour Operator</label>

                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Budget</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Premium</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Standard</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Economical</label>

                        </div>

                    </div>
                </div>
                <div class="advertisment pt-5 ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box-2">

                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 col-xxl-10">
                <div class="row ">
                    <div class="col-12  mb-xl-5 mb-3">
                        <div class="row justify-content-between">
                            <div class="col-md-5">
                                <div class="left_search position-relative">
                                    <input type="text" class="form-control" placeholder="Search by name, date...">
                                    <div class="icons-serch">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3">
                                <div class="right_button float-md-end">
                                    <button class="btn_newsafari" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Organize a New
                                        Safari</button>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-12">
                        <div class="topfilter d-flex justify-content-between align-items-center flex-wrap w-100">
                            <div class="left_text">
                                <p>There are currently <strong>121</strong> active shared safaris created by individuals</p>
                            </div>
                            <div class="right-select">
                                <div class="input_check pb-0">

                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected>Sort By: Created Recently</option>
                                        <option value="1">January</option>
                                        <option value="2">Febraury</option>
                                        <option value="3">March</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">15</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
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
                                    <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
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
                                                <a href="share-safari.html">Join Safari</a>
                                            </div>
                                        </div>
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

<section class="safariduring_sesons innerpage">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
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
                        <label for="" class="Modal_label">Estimate Price</label>
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