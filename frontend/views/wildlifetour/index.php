<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package';
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
              <h1>Wildlife Safari tour packages</h1>
              <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                Their Adventures</p> -->
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<section class="articals_wrapper margin-setposi py-3">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-xl-11 col-lg-12">
        <div class="row my-4 justify-content-center">
          <div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4">
            <div class="filter-wrapper ">
              <div class="title_top pb-4">
                <h4>Select Filters</h4>
              </div>
              <div class="title_filter mb-3">
                <h6>Park</h6>
                <div class="input_check ">

                  <select class="form-select " aria-label="Default select example">
                    <option selected>All Parks</option>
                    <option value="1">January</option>
                    <option value="2">Febraury</option>
                    <option value="3">March</option>
                  </select>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6>Month</h6>
                <div class="input_check ">

                  <select class="form-select " aria-label="Default select example">
                    <option selected>October</option>
                    <option value="1">January</option>
                    <option value="2">Febraury</option>
                    <option value="3">March</option>
                  </select>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6>Stay Category</h6>
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
              <div class="title_filter mb-3">
                <h6 class="pb-0">Tour Duration</h6>
                <div class="rangetours range">
                  <input type="range" min="0" max="50" value="0" class="range-slider" data-display-text="Nights" />
                  <div class="range_values d-flex align-items-center justify-content-between">
                    <div class="value">0 Nights</div>
                    <div>10+ Nights</div>
                  </div>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6 class="pb-0">Total Safaris</h6>
                <div class="rangetours range">
                  <input type="range" min="0" max="50" value="0" class="range-slider" data-display-text="" />
                  <div class="range_values d-flex align-items-center justify-content-between">
                    <div class="value">0</div>
                    <div>10+ </div>
                  </div>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6 class="pb-0">Cost (Per Person)</h6>
                <div class="rangetours range">
                  <input type="range" min="1000" max="50000" value="0" class="range-slider" data-display-text="" />
                  <div class="range_values d-flex align-items-center justify-content-between">
                    <div class="value">1000</div>
                    <div>50000+ </div>
                  </div>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6>Features</h6>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Multiple Parks</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Customizable</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Private Room</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Shared Room</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Private Safari</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Shared Safari</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Photography Special</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Forest Rest House Stay</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Other Activites</label>

                </div>
              </div>
              <div class="title_filter mb-3">
                <h6>Included</h6>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Accommodation</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">All Meals</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">WAll Meals</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Camera Fee</label>
                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Permit</label>
                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Guide Fee</label>
                </div>
              </div>
              <div class="title_filter mb-3">
                <h6>Organizer</h6>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Safari Tour Operator</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Wildlife Photographer</label>

                </div>
                <div class="input_check d-flex gap-3 align-items-center">
                  <input type="checkbox" name="" id="text" class="checkbox_design">
                  <label for="text" class=" text_check">Wildlife Influencer</label>

                </div>

              </div>
            </div>
          </div>
          <div class="col-lg-9 col-xl-9 col-xxl-10 pe-lg-0">
            <div class="row ">
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
            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">
              <div class="col mb-4">
                <div class="col mb-4 padding_righ">
                  <div class="sharesafri-card tourpackage">
                    <div class="flotingdate">
                      <div class="icons text-center">
                        <p class="mb-0">Jul</p>
                        <p class="mb-0">06</p>
                      </div>
                    </div>
                    <div class="shareimg">
                      <a href="/sharedsafari/gufran-ahmad-b82588-191720175893-shared-safari">
                        <img src="http://app.walkintothewild.io/storage/safaripark/1/logo1718179650.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                      <div class="top_seats">
                        <div class="safari d-flex justify-content-between ">
                          <div class="safarinum d-flex gap-2 align-items-center ">
                            <p class="text_safari">NIGHTS</p>
                            <h6 class="number-safari">3</h6>
                          </div>
                          <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                            <p class="text_safari">SAFARIES</p>
                            <h6 class="number-safari">1</h6>
                          </div>
                        </div>
                      </div>
                      <div class="titleDate">
                        <h6 class="pt-1"><a href="">Bandhavgarh Tiger Reserve + 2 Parks </a></h6>
                        <div class="orgnizer_tour d-flex gap-3 pt-2">
                          <div class="icons_restro">
                            <i class="fa-solid fa-building"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-car"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-utensils"></i>
                          </div>
                        </div>
                      </div>
                      <div class="footer_card row pb-2 px-2 align-items-center">
                        <div class="col-6">
                          <div class="safaritourlogo">
                            <img src="http://app.walkintothewild.io/assets/5a869828/img/Pugdundee.jpg" alt="" class="w-100">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="safari text-center">
                            <div class="joinsafari package">
                              <h6 class=" titlePrice">25,000 + GST </h6>
                              <a href="">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col mb-4">
                <div class="col mb-4 padding_righ">
                  <div class="sharesafri-card tourpackage">
                    <div class="flotingdate">
                      <div class="icons text-center">
                        <p class="mb-0">Jul</p>
                        <p class="mb-0">06</p>
                      </div>
                    </div>
                    <div class="shareimg">
                      <a href="/sharedsafari/gufran-ahmad-b82588-191720175893-shared-safari">
                        <img src="http://app.walkintothewild.io/storage/safaripark/1/logo1718179650.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                      <div class="top_seats">
                        <div class="safari d-flex justify-content-between ">
                          <div class="safarinum d-flex gap-2 align-items-center ">
                            <p class="text_safari">NIGHTS</p>
                            <h6 class="number-safari">3</h6>
                          </div>
                          <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                            <p class="text_safari">SAFARIES</p>
                            <h6 class="number-safari">1</h6>
                          </div>
                        </div>
                      </div>
                      <div class="titleDate">
                        <h6 class="pt-1"><a href="">Bandhavgarh Tiger Reserve + 2 Parks </a></h6>
                        <div class="orgnizer_tour d-flex gap-3 pt-2">
                          <div class="icons_restro">
                            <i class="fa-solid fa-building"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-car"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-utensils"></i>
                          </div>
                        </div>
                      </div>
                      <div class="footer_card row pb-2 px-2 align-items-center">
                        <div class="col-6">
                          <div class="safaritourlogo">
                            <img src="http://app.walkintothewild.io/assets/5a869828/img/Pugdundee.jpg" alt="" class="w-100">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="safari text-center">
                            <div class="joinsafari package">
                              <h6 class=" titlePrice">25,000 + GST </h6>
                              <a href="">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col mb-4">
                <div class="col mb-4 padding_righ">
                  <div class="sharesafri-card tourpackage">
                    <div class="flotingdate">
                      <div class="icons text-center">
                        <p class="mb-0">Jul</p>
                        <p class="mb-0">06</p>
                      </div>
                    </div>
                    <div class="shareimg">
                      <a href="/sharedsafari/gufran-ahmad-b82588-191720175893-shared-safari">
                        <img src="http://app.walkintothewild.io/storage/safaripark/1/logo1718179650.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                      <div class="top_seats">
                        <div class="safari d-flex justify-content-between ">
                          <div class="safarinum d-flex gap-2 align-items-center ">
                            <p class="text_safari">NIGHTS</p>
                            <h6 class="number-safari">3</h6>
                          </div>
                          <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                            <p class="text_safari">SAFARIES</p>
                            <h6 class="number-safari">1</h6>
                          </div>
                        </div>
                      </div>
                      <div class="titleDate">
                        <h6 class="pt-1"><a href="">Bandhavgarh Tiger Reserve + 2 Parks </a></h6>
                        <div class="orgnizer_tour d-flex gap-3 pt-2">
                          <div class="icons_restro">
                            <i class="fa-solid fa-building"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-car"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-utensils"></i>
                          </div>
                        </div>
                      </div>
                      <div class="footer_card row pb-2 px-2 align-items-center">
                        <div class="col-6">
                          <div class="safaritourlogo">
                            <img src="http://app.walkintothewild.io/assets/5a869828/img/Pugdundee.jpg" alt="" class="w-100">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="safari text-center">
                            <div class="joinsafari package">
                              <h6 class=" titlePrice">25,000 + GST </h6>
                              <a href="">View Details</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col mb-4">
                <div class="col mb-4 padding_righ">
                  <div class="sharesafri-card tourpackage">
                    <div class="flotingdate">
                      <div class="icons text-center">
                        <p class="mb-0">Jul</p>
                        <p class="mb-0">06</p>
                      </div>
                    </div>
                    <div class="shareimg">
                      <a href="/sharedsafari/gufran-ahmad-b82588-191720175893-shared-safari">
                        <img src="http://app.walkintothewild.io/storage/safaripark/1/logo1718179650.jpg" alt=""></a>
                    </div>
                    <div class="card_body">
                      <div class="top_seats">
                        <div class="safari d-flex justify-content-between ">
                          <div class="safarinum d-flex gap-2 align-items-center ">
                            <p class="text_safari">NIGHTS</p>
                            <h6 class="number-safari">3</h6>
                          </div>
                          <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                            <p class="text_safari">SAFARIES</p>
                            <h6 class="number-safari">1</h6>
                          </div>
                        </div>
                      </div>
                      <div class="titleDate">
                        <h6 class="pt-1"><a href="">Bandhavgarh Tiger Reserve + 2 Parks </a></h6>
                        <div class="orgnizer_tour d-flex gap-3 pt-2">
                          <div class="icons_restro">
                            <i class="fa-solid fa-building"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-car"></i>
                          </div>
                          <div class="icons_restro">
                            <i class="fa-solid fa-utensils"></i>
                          </div>
                        </div>
                      </div>
                      <div class="footer_card row pb-2 px-2 align-items-center">
                        <div class="col-6">
                          <div class="safaritourlogo">
                            <img src="http://app.walkintothewild.io/assets/5a869828/img/Pugdundee.jpg" alt="" class="w-100">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="safari text-center">
                            <div class="joinsafari package">
                              <h6 class=" titlePrice">25,000 + GST </h6>
                              <a href="">View Details</a>
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
      </div>

    </div>

  </div>

</section>

<section class="safariduring_sesons innerpage">
  <div class="container-lg">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="title_web">
          <h2>BEST SAFARIS DURING <br>MONSOON SEASON</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="safari-carousel owl-carousel owl-theme">
    <div class="safari-box">
      <figure class="image-box"><img src="assets/img/Jim Corbett.jpg" alt=""></figure>
      <div class="content-box">
        <h3><a href="deer.html">JIM CORBETT</a></h3>
      </div>
      <div class="overlay-content d-flex align-items-center justify-content-between">
        <div class="content_o pe-2">
          <h3><a href="deer.html">JIM CORBETT</a></h3>
          <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
            its natural
            habitat.</p>
        </div>
        <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
      </div>
    </div>
    <div class="safari-box">
      <figure class="image-box"><img src="assets/img/Gir.jpg" alt=""></figure>
      <div class="content-box">
        <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
      </div>
      <div class="overlay-content d-flex align-items-center justify-content-between">
        <div class="content_o pe-2">
          <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
          <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
            its natural
            habitat.</p>
        </div>
        <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
      </div>
    </div>
    <div class="safari-box">
      <figure class="image-box"><img src="assets/img/Kanha.jpg" alt=""></figure>
      <div class="content-box">
        <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
      </div>
      <div class="overlay-content d-flex align-items-center justify-content-between">
        <div class="content_o pe-2">
          <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
          <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
            its natural
            habitat.</p>
        </div>
        <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
      </div>
    </div>
    <div class="safari-box">
      <figure class="image-box"><img src="assets/img/Bandhavgarh.jpg" alt=""></figure>
      <div class="content-box">
        <h3><a href="deer.html">BANDHAVGARH</a></h3>
      </div>
      <div class="overlay-content d-flex align-items-center justify-content-between">
        <div class="content_o pe-2">
          <h3><a href="deer.html">BANDHAVGARH</a></h3>
          <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
            its natural
            habitat.</p>
        </div>
        <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
      </div>
    </div>
    <div class="safari-box">
      <figure class="image-box"><img src="assets/img/Kaziranga.jpg" alt=""></figure>
      <div class="content-box">
        <h3><a href="deer.html">KAZIRANGA</a></h3>
      </div>
      <div class="overlay-content d-flex align-items-center justify-content-between">
        <div class="content_o pe-2">
          <h3><a href="deer.html">KAZIRANGA</a></h3>
          <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
            its natural
            habitat.</p>
        </div>
        <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
      </div>
    </div>
  </div>
</section>


<script>
  document.querySelectorAll('.range-slider').forEach(slider => {
    slider.addEventListener('input', (event) => {
      const sliderEl = event.target;
      const valueEl = sliderEl.nextElementSibling.querySelector('.value');
      const tempSliderValue = sliderEl.value;
      const displayText = sliderEl.getAttribute('data-display-text');

      // Update the slider value text based on the display text attribute
      if (displayText === 'Nights') {
        valueEl.textContent = `${tempSliderValue} Nights`;
      } else {
        valueEl.textContent = tempSliderValue;
      }

      const progress = (tempSliderValue / sliderEl.max) * 100;

      // Update the background color to show the progress
      sliderEl.style.background = `linear-gradient(to right, #09422D ${progress}%, #919191 ${progress}%)`;
    });
  });
</script>

<?php
$script = <<< JS

       
JS;
$this->registerJs($script);
?>