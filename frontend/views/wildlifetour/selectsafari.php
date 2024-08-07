<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Select Safrai';
$this->params['title'] = $this->title;
?>


<div class="fixedbanner">
  <section class="banner_section-inner  position-relative">
    <picture class="position-relative">
      <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
      <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="headingBnner_inner">
              <h1>3 Nights jim corbett tiger safari</h1>
              <p class="text-center text-white">Organized by Eagle Safaris</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>



<section class="safari_wrapper margin-setposi py-3 py-3 mb-5">
  <div class="container-lg">
    <div class="row my-4 packageSfari">
      <div class="col-12">
        <div class="imagesSafari">
        <img src="<?= $this->params['baseurl'] ?>/img/FESHwr.jpg" alt="" class="w-100">
        </div>
        <div class="wrapper-skybgsafri">
          <div class="row border_bottom2 pb-4">
            <div class="col-lg-7 col-md-8 border-right">
              <div class="row">
                <div class="col-lg-4">
                  <div class="images_tour select_safrai">
                    <img src="https://staging.walkintothewild.in/storage/safarioperator/1/safarioperator1719995939.jpg" alt="">
                  </div>
                </div>
                <div class="col-lg-8 pt-sm-0 pt-3">
                  <div class="safrititles">
                    <h5 class="fs-4"><a href="/park/satpura-tiger-reserve">Satpura Tiger Reserve </a></h5>
                    <div class="date_bx">
                      <h6>11 Jul 24 - 13 Jul 24</h6>
                    </div>
                    <p class="mb-0 pt-2">Organized by <a href="https:/adasdsad.asdp" target="_blank"><strong>Vikas Chaudhary (Individual)</strong></a></p>

                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-4 d-lg-none mobile_didplay_none">
              <div class="btn_wrap d-flex flex-column ">

                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=vikas-chaudhary-8eb1ec-251720186292-shared-safari">Join Safari</a>

              </div>
            </div>
            <div class="col-lg-5 pt-lg-0 pt-4">
              <div class="row px-sm-4 px-0">
                <div class="col-12 col-sm-6  mb-3">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/hotel_forest_location.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">1 Safaris</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6  mb-3">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/gypsycanter.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">Available Seats - 4/2</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6  mb-3">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">Vlogging</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6  mb-3">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">Premium</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 ">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">4- 6 Estimate Per Person Cost</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 ">
                  <div class="safridetails_form d-flex gap-3 ">
                    <div class="iconImg">
                      <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                    </div>
                    <div class="text-form">
                      <p class="mb-0">4- 6 Estimate Per Person Cost</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row pt-md-4 align-items-center gx-4">

            <div class="col-lg-7">
              <div class="social-share d-flex gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                <p>Share this event with your friends:</p>
                <div class="sociel_icons ps-3">
                  <ul>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                    </li>
                    <li><a href="https://wa.me/?text=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                    </li>
                    <li><a href="https://twitter.com/intent/tweet?url=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                    </li>
                    <li><a href="https://www.instagram.com/?url=http%253A%252F%252Fstaging.walkintothewild.in%252Fsharedsafari%252Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-5 d-lg-block  mobile_didplay_block">
              <div class="d-flex justify-content-between align-items-center">
                <div class="pakageCost">
                  <h6 class="fs-4 mb-0">25,000 +GST</h6>
                </div>
                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                  <a class="join_btn  mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=vikas-chaudhary-8eb1ec-251720186292-shared-safari">Book Now</a>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4 mt-5 justify-content-center mt-4 itenary_tabs">
      <div class="col-lg-12 col-xl-11 safartabs position-relative">
        <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ITINERARY</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">AINCLUSIONS</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">EXCLUSIONS</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#howto-reach-pan" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">TERMS & CONDITIONS</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-pane" type="button" role="tab" aria-controls="map-tab-pane" aria-selected="false" tabindex="-1">FAQ</button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-pane" type="button" role="tab" aria-controls="map-tab-pane" aria-selected="false" tabindex="-1">ACCOMODATION</button>
          </li>
        </ul>
        <div class="tab-content accordion" id="myTabContent">
          <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <h2 class="accordion-header d-lg-none" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Overview</button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
              <div class="accordion-body p-3">
                <div class="row">
                  <div class="col-lg-6 mb-3">
                    <div class="itenary-title">
                      <h6 class="fs-5 pb-2">ABOUT TRIP / OVERVIEW</h6>
                    </div>
                    <div class="itenary_text">

                      <p>Five Tiger Reserve Tour covers all the tiger reserves of Madhya Pradesh and is ideal for a wildlife enthusiast not wanting to miss out anything. This tour covers Panna - Bandhavgarh - Kanha - Pench – Satpura national parks spreading across the complete length & breadth of the state. This is a holistic wildlife experience offering the very best of Central India. Trip not only offers high chance of Royal Bengal Tiger but also provides with an opportunity to explore the diverse flora & fauna of Central India with each park offering a unique habitat.</p>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-3">
                    <div class="itenary-title">
                      <h6 class="fs-5 pb-2">LOCATION</h6>
                    </div>
                    <div class="itenary_text">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.627337221733!2d77.36012777632219!3d28.61095457567664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d054809ac1cc3%3A0xf081c1e27610b8f2!2sTriline%20Infotech%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1720531973102!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                  </div>
                </div>
                <div class="row pt-4">
                  <div class="col-12 inner_accordion">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            DAY 1 - Check-in and relax
                          </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="wrap_days">
                              <div class="row">
                                <div class="col-12">
                                  <div class="days_title">
                                    <h4 class="fs-5">Nights jim corbett tiger</h4>
                                  </div>
                                  <div class="text_wrapperite">
                                    <p>You will be picked up from the airport by a Lion King representative and conveyed to your accommodation in Arusha where you will overnight, relax, and prepare in anticipation of the adventures to come. Our partner lodge, Outpost Lodge, is an oasis of calm and aesthetic pleasure.</p>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 mb-3">
                                  <div class="titles_locations">
                                    <h6 class="fs-5">Start Location</h6>
                                    <p>407, C-51, Sector 62, BSI Business Park, Noida, Uttar Pradesh 201309</p>
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                  <div class="titles_locations">
                                    <h6 class="fs-5">End Location</h6>
                                    <p>407, C-51, Sector 62, BSI Business Park, Noida, Uttar Pradesh 201309</p>
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                  <div class="titles_locations">
                                    <h6 class="fs-5">Hotel Stay Home</h6>
                                    <p>Grand Plaza Hotel</p>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="titles_locations">
                                    <h6 class="fs-5">Meal</h6>
                                    <div class="mealchecks d-flex gap-4 align-items-center">
                                      <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                        <input type="checkbox" id="check">
                                        <label for="check">Breackfast</label>
                                      </div>
                                      <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                        <input type="checkbox" id="check2">
                                        <label for="check2">Lunch</label>
                                      </div>
                                      <div class="inputsCheck mb-2 d-flex  align-items-center gap-2 ">
                                        <input type="checkbox" id="check3">
                                        <label for="check3">Dinner</label>
                                      </div>
                                      <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                        <input type="checkbox" id="check4">
                                        <label for="check4">All</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="titles_locations pt-4">
                                <h6 class="fs-5">Images</h6>
                              </div>

                              <div class="row pt-2">
                                <div class="col-lg-4 mb-2">
                                  <div class="hotelImages">
                                    <img src="<?= $this->params['baseurl'] ?>/img/FESHwr.jpg" alt="" class="w-100">
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                  <div class="hotelImages">
                                    <img src="<?= $this->params['baseurl'] ?>/img/FESHwr.jpg" alt="" class="w-100">
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                  <div class="hotelImages">
                                    <img src="<?= $this->params['baseurl'] ?>/img/FESHwr.jpg" alt="" class="w-100">
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            DAY 2 - Morning and Evening Safari
                          </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            DAY 3 - Morning Safari and Sight Seeing
                          </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Rendered on 2024-07-09 13:16:37 -->
          </div>
          <div class="tab-pane fade accordion-item" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <h2 class="accordion-header d-lg-none" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                About Park
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
              <div class="accordion-body height_set">

              </div>
            </div>
            <!-- Rendered on 2024-07-09 13:16:37 -->
          </div>
          <div class="tab-pane fade accordion-item" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <h2 class="accordion-header d-lg-none" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                FLORA &amp; FAUNA
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
              <div class="accordion-body height_set">

              </div>
            </div>
            <!-- Rendered on 2024-07-09 13:16:37 -->
          </div>
          <div class="tab-pane fade accordion-item" id="howto-reach-pan" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
            <h2 class="accordion-header d-lg-none" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                HOW TO REACH
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
              <div class="accordion-body height_set">

              </div>
            </div>
            <!-- Rendered on 2024-07-09 13:16:37 -->
          </div>
          <div class="tab-pane fade accordion-item" id="map-tab-pane" role="tabpanel" aria-labelledby="map-tab" tabindex="0">
            <h2 class="accordion-header d-lg-none" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" >
                MAP
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
              <div class="accordion-body height_set">

                <iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps?q=23.721942,81.019378&amp;hl=es&amp;z=13&amp;output=embed" allowfullscreen="">
                </iframe>

              </div>
            </div>
            <!-- Rendered on 2024-07-09 13:16:37 -->
          </div>
        </div>
      </div>
    </div>
  </div>


</section>

<?php
$script = <<< JS

       
JS;
$this->registerJs($script);
?>