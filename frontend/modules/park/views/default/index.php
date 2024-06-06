<?php


/* @var $this yii\web\View */

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>


<section class="banner_section position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/bannerhome.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/bannerhome.png" class="d-block w-100" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner pb-4">
                        <h1>All Wildlife Safari Info, Multiple Operators, One Convenient Spot!</h1>
                    </div>
                </div>
                <div class="col-12 pt-4">
                    <div class="tab-block" id="tab-block">
                        <ul class="tab-mnu">
                            <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="26" class="me-2">Safari</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2">Birding</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2"> Resort</li>
                        </ul>

                        <div class="tab-cont">
                            <div class="tab-pane">
                                <?= $this->render('_advance_search', [
                                    'model' => $searchModel,
                                ]) ?>
                            </div>
                            <!-- <div class="tab-pane">
                  <div class="row gx-0">
                    <div class="col-lg-10 col-xl-11">
                      <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-2 w-100">
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>North india, South...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Location</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>May,june,July..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Month</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Tiger Elephent..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Animal</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Gypsy,Bus...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Vehicel</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                          </div>
                        </div>
                        <div class="advanceSearch " id="advanceSearchBox">
                          <div class="d-md-flex gap-2">
                            <div class="select_boxes position-relative">
                              <select class="form-select form-select-lg " aria-label="Large select example">
                                <option selected>Tiger Elephent..</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                              <div class="placeholder_select">
                                <p>Accommodation</p>
                              </div>
                              <div class="icons_select">
                                <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="">
                              </div>
                            </div>
                            <div class="select_boxes position-relative">
                              <select class="form-select form-select-lg " aria-label="Large select example">
                                <option selected>Gypsy,Bus...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                              </select>
                              <div class="placeholder_select">
                                <p>Safari seasion</p>
                              </div>
                              <div class="icons_select">
                                <img src="<?= $this->params['baseurl'] ?>/img/day-night_8776508.png" alt="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-xl-1">
                      <div class="search">
                        <div class="serch_btn">
                          <button>Search</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="toogle_icon mt-2">
                    <button id="toggleButton"><i class="fa-solid fa-chevron-down"></i> Advance Search</button>
                  </div>
                </div>
                <div class="tab-pane">
                  <div class="row gx-0">
                    <div class="col-lg-10 col-xl-11">
                      <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-2 w-100">
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg" aria-label="Large select example">
                            <option selected>North india, South...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Location</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>May,june,July..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Month</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Tiger Elephent..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Animal</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                          </div>
                        </div>
                        <div class="select_boxes position-relative">
                          <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Gypsy,Bus...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                          <div class="placeholder_select">
                            <p>Vehicel</p>
                          </div>
                          <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                          </div>
                        </div>
                      
                      </div>
                    </div>
                    <div class="col-lg-2 col-xl-1">
                      <div class="search">
                        <div class="serch_btn">
                          <button>Search</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

<section class="sharesafri">
    <div class="container-lg sharesafribg home">
        <div class="safarishareBox py-3">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-12 col-xl-8">
                    <div class="title_safari text-center pt-3">
                        <h4>Discover and Join 100+ Safaris Hosted by Individuals</h4>
                        <!-- <div class="joinshare">
                  <a href="" class="btn_share">JOIN SHARED SAFARI</a>
                </div> -->
                    </div>
                </div>

            </div>
            <div class="row pt-4 justify-content-center ">
                <div class="col-lg-4  col-xxl-3 col-md-6 mb-4">
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
                <div class="col-lg-4  col-xxl-3 col-md-6 mb-4">
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


            </div>
        </div>


    </div>
</section>
<section class="safariduring_sesons">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
</section>
<section class="animal-wrapper pb-4">
    <?= $this->render('rare_exotic', [
        'rare_exotics' => $rare_exotics,
    ]) ?>
</section>
<section class="bg_sky">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Safari Tour Operator</h6>

                        <div class="btn_r">
                            <a href="safaritour-resgistration.html" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img  position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Birding Tour Operator</h6>

                        <div class="btn_r">
                            <a href="birding-form.html" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="articals_wrapper  pb-5 mb-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2>ARTICLES AND TIPS</h2>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4  gx-xxl-5 gx-lg-4">
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article1.jpg" alt=""></a>
                        </figure>
                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">how Interaction with Animal can Release </a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article2.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Donec eget condimentum sapien</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article3.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Etiam vel porttitor mi convallis</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article4.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Etiam vel porttitor mi convallis</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article5.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Etiam vel porttitor mi convallis</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article6.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Etiam vel porttitor mi convallis</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article1.jpg" alt=""></a>
                        </figure>
                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">how Interaction with Animal can Release </a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
            <div class="col mb-5">
                <div class="artical_cards h-100">
                    <div class="image-box">
                        <figure class="image"><a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article2.jpg" alt=""></a>
                        </figure>

                    </div>
                    <div class="lower-content">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="">Admin</a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="">2 Comments</a></li>
                        </ul>
                        <h3><a href="">Donec eget condimentum sapien</a></h3>

                    </div>
                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>