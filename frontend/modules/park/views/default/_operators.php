<?php


/* @var $this yii\web\View */
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="col-lg-4 col-xl-3 col-xxl-2 mb-4">
    <div class="filter-wrapper">
        <div class="title_top pb-4">
            <h4>Select Filters</h4>
        </div>
        <div class="title_filter mb-4">
            <h6>Operator Rating</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <div class="start d-flex gap-2">
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                </div>

            </div>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <div class="start d-flex gap-2">
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>

                </div>

            </div>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <div class="start d-flex gap-2">
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                    <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>

                </div>

            </div>
        </div>
        <div class="title_filter mb-4">
            <h6>Operator Credibility</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <label for="text" class=" text_check">Registered Company</label>

            </div>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <label for="text" class=" text_check">Has a Website</label>

            </div>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <label for="text" class=" text_check">Offers Other Wildlife Activities</label>

            </div>
            <div class="input_check d-flex gap-3 align-items-center">
                <input type="checkbox" name="" id="text" class="checkbox_design">
                <label for="text" class=" text_check">Has Cancellation Policy</label>

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
    <div class="advertisment pt-5">
        <p class="text-center">ADVERTISMENT</p>
        <div class="advertisment_box-2">

        </div>
    </div>
</div>
<div class="col-lg-8 col-xl-9 col-xxl-10">
    <div class="col-12">
        <div class="topfilter d-md-flex justify-content-between align-items-center w-100">
            <div class="left_text">
                <p class="">There are currently <strong>121</strong> active shared safaris created by individuals</p>
            </div>
            <div class="right-select d-flex gap-2 align-items-center">
                <div class="input_check pb-0">

                    <select class="form-select mb-2" aria-label="Default select example">
                        <option selected>Sort By: Created Recently</option>
                        <option value="1">January</option>
                        <option value="2">Febraury</option>
                        <option value="3">March</option>
                    </select>
                </div>
                <!-- <div class="gridListview">
                  <a href="#" id="toggleViewBtn"><i class="fas fa-list"></i></a>
                </div> -->
            </div>
        </div>
        <div class="gridview mt-4">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-5 g-xl-4 gx-lg-4">
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="higlighted">
                            <p>Highlighted</p>
                        </div>
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 mb-3">
                    <div class="listingSafari ">
                        <div class="card-body px-2">
                            <div class="logo_provide2  p-3 border_bottom2">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                            </div>
                            <div class="provider_details">
                                <h6 class="pname py-3">Pugdundee Safaris</h6>
                                <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                    <div class="ratings">
                                        <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0">54 Google Reviews</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="footer_provider ">
                            <div class="slect_safricound d-flex justify-content-around">
                                <div class="parks_text text-center">
                                    <p>6</p>
                                    <p>Parks</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>7</p>
                                    <p>Resorts</p>
                                </div>
                                <div class="parks_text text-center">
                                    <p>15</p>
                                    <p>Shared Safari</p>
                                </div>
                            </div>
                            <div class="get_quote text-center">
                                <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>