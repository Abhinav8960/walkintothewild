<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/safari.jpg" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/safari.jpg" class="d-block w-100 " alt="banner">
    </picture>

</section>
<section class="safari-registration ">
    <div class="container-lg pb-5">
        <div class="row justify-content-center py-5">
            <div class="col-12 py-4 text-center ">
                <div class="headings">
                    <h3>Safari Tour Operator Registration Form</h3>
                </div>
            </div>
            <div class="col-xl-10 col-lg-11 mb-4">
                <div class="registration-form">
                    <div id="form1" class="form active">
                        <div class="form_title text-center pb-3">
                            <h6>OPERATOR DETAILS</h6>
                        </div>
                        <div class="row pt-4">
                            <div class="col-lg-3 col-md-3">

                                <div class="browslogow3">
                                    <div class="text" id="uploadText">Browse Logo</div>
                                    <input id="fileupload" type="file" class="fileupload" />
                                </div>

                            </div>
                            <div class="col-lg-9 col-md-9">
                                <div class="formInput pt-lg-0 pt-2">
                                    <label for="">Business Name </label>
                                    <input type="text" class="form-control" placeholder="XYZ Safaris">
                                </div>
                                <div class="formInput mt-3">
                                    <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                        <label for="">Registered Name <span>*</span></label>
                                        <p class="mb-0 pb-lg-0 pb-2">A registered company will get better ranking in search
                                            result</p>
                                    </div>

                                    <input type="text" class="form-control" placeholder="xyz travel agency pvt. ltd.">
                                </div>
                            </div>
                            <div class="col-lg-7 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <label for="">Category <span>*</span></label>
                                            <select class="form-select form-select-lg " aria-label="Large select example">
                                                <option selected>Safari Tour Operator, Wildlife Photographer...
                                                </option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <label for="">Address <span>*</span></label>
                                            <input type="text" class="form-control" placeholder="XYZ Safaris">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                                <label for="">Operates in Parks <span>*</span></label>
                                                <p class="mb-0 pb-xl-0 pb-2">In case of multiple parks, select the parks you operate in.</p>
                                            </div>
                                            <select class="form-select form-select-lg " aria-label="Large select example">
                                                <option selected>Safari Tour Operator, Wildlife Photographer...
                                                </option>
                                                <option value="1"> One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-5  mt-md-4 mt-2">
                                <div class="formInput">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label for="">About Business</label>
                                        <p class="mb-0">500 words max.</p>
                                    </div>
                                    <textarea name="" id="" class="form-control "></textarea>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="form2" class="form ">
                        <div class="form_title text-center pb-3">
                            <h6>CONTACT AND SEGMENT DETAILS</h6>
                        </div>
                        <div class="row pt-4 ">
                            <div class="col-xl-6">
                                <div class="formInput  mb-3">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <label for="">Website</label>
                                        <p class="mb-0 pt-lg-0 pb-2">This website will be visible to clients</p>
                                    </div>
                                    <input type="text" class="form-control" placeholder="XYZ Safaris">
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="mobile_width">
                                            <label for="">Phone Number <span>*</span></label>
                                            <input type="text" class="form-control w-100" placeholder="+91 00000 00000">
                                        </div>
                                        <div class="mobile_width">
                                            <p class="mb-0 pt-xxl-0 pt-3 pb-2">This phone number will be visible to clients</p>
                                            <input type="text" class="form-control w-100" placeholder="+91 00000 00000">
                                        </div>
                                    </div>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="mobile_width">
                                            <label for="">Email Adress <span>*</span></label>
                                            <input type="text" class="form-control w-100" placeholder="yourbusiness@domain.com">
                                        </div>
                                        <div class="mobile_width">
                                            <p class="mb-0 pt-xl-2 pt-3 pb-2">This email address will be visible to clients</p>
                                            <input type="text" class="form-control w-100" placeholder="yourbusiness@domain.com">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 ">
                                <div class="formInput mb-5">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <label for="">Social Media</label>
                                        <p class="mb-0 pt-lg-0 pb-2">These social media profiles will be visible to clients</p>
                                    </div>
                                    <div class="d-flex gap-2 socil-links align-items-center">
                                        <a href=""><i class="fa-brands fa-instagram"></i></a>
                                        <input type="text" class="form-control" placeholder="Instagram Profile Link">
                                    </div>
                                </div>
                                <div class="formInput mb-5">
                                    <div class="d-flex gap-2 socil-links align-items-center">
                                        <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                                        <input type="text" class="form-control" placeholder="Facebook Profile Link">
                                    </div>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex gap-2 socil-links align-items-center">
                                        <a href=""><i class="fa-brands fa-youtube"></i></a>
                                        <input type="text" class="form-control" placeholder="Youtube Profile Link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-3">
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <label for="">Budget Segment <span>*</span></label>
                                        <select class="form-select form-select-lg mb-3 w-50" aria-label="Large select example">
                                            <option selected>Premium</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between  gap-3">
                                        <label for="">Cancellation Policy</label>
                                        <select class="form-select form-select-lg mb-3 w-50" aria-label="Large select example">
                                            <option selected>yes</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between  gap-3">
                                        <label for="">Google Rating</label>
                                        <input type="text" class="form-control w-50 text-center" placeholder="4.5">
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 mt-3">
                                <div class="formInput mb-3">
                                    <div class="d-md-flex  gap-3">
                                        <label for="">Offers Other Wildlife Activities</label>
                                        <div class="checkbb mt-md-0 mt-3">
                                            <div class="input_check d-flex gap-3 align-items-center">
                                                <input type="checkbox" name="" id="text" class="checkbox_design">
                                                <label for="text" class=" text_check">Wildlife Trekking /
                                                    Hiking</label>
                                            </div>
                                            <div class="input_check d-flex gap-3 align-items-center">
                                                <input type="checkbox" name="" id="text" class="checkbox_design">
                                                <label for="text" class=" text_check">Wildlife Non-safari
                                                    Drive</label>
                                            </div>
                                            <div class="input_check d-flex gap-3 align-items-center">
                                                <input type="checkbox" name="" id="text" class="checkbox_design">
                                                <label for="text" class=" text_check">Birding / Bird
                                                    Watching</label>
                                            </div>
                                            <div class="input_check d-flex gap-3 align-items-center">
                                                <input type="checkbox" name="" id="text" class="checkbox_design">
                                                <label for="text" class=" text_check">Camping</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="dots-container">
                        <span class="dot active"></span>
                        <span class="dot "></span>
                        <!-- Add more dots for additional steps -->
                    </div>
                </div>
                <div class="row align-items-center pt-3">
                    <div class="col-sm-10">
                        <div class="term-condition text-center">
                            <p class="mb-0 d-flex justify-content-center align-items-center"> <input type="checkbox" class="me-2 checkbox_design"> I agree to the <a href=""> terms and conditions.</a></p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="nextBtn float-end">
                            <button class="next-btn">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>