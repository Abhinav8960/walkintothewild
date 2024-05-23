<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

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
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="registration-form">
                    <div id="form1" class="form active">
                        <div class="form_title text-center pb-3">
                            <h6>OPERATOR DETAILS</h6>
                        </div>
                        <div class="row pt-4">
                            <div class="col-lg-3 col-md-3">

                                <div class="browslogow3" id="browslogow3">
                                    <div class="text" id="uploadText">Browse Logo</div>
                                    <?= $form->field($model, 'logo')->fileInput(['class' => 'fileupload', 'id' => 'fileupload'])->label(false) ?>

                                    <!-- <input id="fileupload" type="file" class="fileupload" /> -->
                                </div>


                            </div>
                            <div class="col-lg-9 col-md-9">
                                <div class="formInput pt-lg-0 pt-2">
                                    <label for="">Business Name </label>
                                    <?= $form->field($model, 'business_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name'])->label(false) ?>
                                </div>
                                <div class="formInput mt-3">
                                    <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                        <label for="">Registered Name <span>*</span></label>
                                        <p class="mb-0 pb-lg-0 pb-2">A registered company will get better ranking in search
                                            result</p>
                                    </div>

                                    <?= $form->field($model, 'register_comapany_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Registered Company Name'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-lg-7 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <label for="">Category <span>*</span></label>
                                            <?= $form->field($model, 'category_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Category'])->label(false) ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <label for="">Address <span>*</span></label>
                                            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Enter Address'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <div class="formInput">
                                            <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                                <label for="">Operates in Parks <span>*</span></label>
                                                <p class="mb-0 pb-xl-0 pb-2">In case of multiple parks, select the parks you operate in.</p>
                                            </div>

                                            <?= $form->field($model, 'park_id')->widget(Select2::classname(), [
                                                'data' => GeneralModel::parkoption(),
                                                // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                                'options' => ['placeholder' => 'Safari Tour Operator, Wildlife Photographer...', 'multiple' => true],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label(false) ?>

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
                                    <?= $form->field($model, 'about_business')->textarea()->label(false) ?>
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
                                    <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'This website will be visible to clients'])->label(false) ?>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="mobile_width div_remove">
                                            <label for="">Phone Number <span>*</span></label>
                                            <?= $form->field($model, 'phone_no')->textInput(['maxlength' => true, 'placeholder' => '+91 00000 00000'])->label(false) ?>
                                        </div>
                                        <div class="mobile_width div_remove">
                                            <p class="mb-0 pt-xxl-0 pt-3 pb-2">This phone number will be visible to clients</p>
                                            <input type="text" class="form-control w-100" placeholder="+91 00000 00000">
                                        </div>
                                    </div>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="mobile_width div_remove">
                                            <label for="">Email Adress <span>*</span></label>
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com'])->label(false) ?>
                                        </div>
                                        <div class="mobile_width div_remove">
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
                                    <div class="d-flex gap-2 socil-links div_remove align-items-center">
                                        <a href=""><i class="fa-brands fa-instagram"></i></a>
                                        <?= $form->field($model, 'instagram_url')->textInput(['maxlength' => true, 'placeholder' => 'Instagram Profile Link'])->label(false) ?>
                                    </div>
                                </div>
                                <div class="formInput mb-5">
                                    <div class="d-flex gap-2 socil-links div_remove align-items-center">
                                        <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                                        <?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true, 'placeholder' => 'Facebook Profile Link'])->label(false) ?>
                                    </div>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex gap-2 socil-links div_remove align-items-center">
                                        <a href=""><i class="fa-brands fa-youtube"></i></a>
                                        <?= $form->field($model, 'youtube_link')->textInput(['maxlength' => true, 'placeholder' => 'Youtube Profile Link'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mt-3">
                                <div class="formInput budgetSeg mb-3">
                                    <div class="d-flex align-items-center justify-content-between  div_remove slect_remove gap-3">
                                        <label for="">Budget Segment <span>*</span></label>

                                        <?= $form->field($model, 'budget_segment')->widget(Select2::classname(), [
                                            'data' => GeneralModel::packageoption(),
                                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                            'options' => ['placeholder' => 'Select', 'multiple' => true],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false) ?>
                                    </div>

                                </div>
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between  div_remove slect_remove gap-3">
                                        <label for="">Cancellation Policy</label>
                                        <?= $form->field($model, 'has_cancellation_policy')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"])->label(false) ?>


                                    </div>

                                </div>
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between div_remove slect_remove gap-3">
                                        <label for="">Google Rating</label>
                                        <?= $form->field($model, 'google_rating')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'class' => 'text-center form-control'])->label(false) ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 mt-3">
                                <div class="formInput mb-3">
                                    <div class="d-md-flex  gap-3">
                                        <label for="">Offers Other Wildlife Activities</label>
                                        <div class="checkbb mt-md-0 mt-3">
                                            <div class="input_check d-flex gap-3 align-items-center">
                                                <?= $form->field($model, 'offers_other_wildlifeactivities')->checkboxList(
                                                    GeneralModel::wildlifeactivities(),
                                                    [
                                                        'required' => true,
                                                        // 'separator' => '<br>',
                                                        'itemOptions' => ['class' => 'checkbox_design'],
                                                    ]
                                                )->label(false); ?>
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
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success text-black', 'style' => 'background-color:#F7BF39 !important;border: 0;padding: 10px 70px;border-radius: 4px;margin-top: 10px;font-size: var(--fs-18);font-weight: 600;']) ?>

                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
</section>