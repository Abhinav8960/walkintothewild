<?php

use common\models\cms\contentmanagement\ContentManagement;
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
        <source srcset="<?= $this->params['baseurl'] ?>/img/safariformbanner.jpg" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/safariformbanner.jpg" class="d-block w-100 " alt="banner">
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
                <?php $form = ActiveForm::begin([
                    'id' => 'safariform',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'enableClientScript' => true,
                    'action' => $model->action_url,
                    'validationUrl' => $model->action_validate_url,
                ]); ?>
                <div class="registration-form">
                    <div id="form1" class="form active">
                        <div class="form_title text-center pb-3">
                            <h6>OPERATOR DETAILS</h6>
                        </div>
                        <div class="row pt-4">
                            <div class="col-lg-3 col-md-3">

                                <div class="browslogow3" id="browslogow3">
                                    <div class="text" id="uploadText">Browse Logo <br><span class="span_title"> (JPEG /JPG or PNG / 250 KB)</span></div>
                                    <?= $form->field($model, 'logo')->fileInput(['class' => 'fileupload', 'id' => 'fileupload'])->label(false) ?>

                                    <!-- <input id="fileupload" type="file" class="fileupload" /> -->
                                </div>


                            </div>
                            <div class="col-lg-9 col-md-9">
                                <div class="formInput pt-lg-0 pt-2">
                                    <label for="">Business Name <span>*</span></label>
                                    <?= $form->field($model, 'business_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name', 'data-label' => 'Business Name'])->label(false) ?>
                                </div>
                                <div class="formInput mt-3">
                                    <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                        <label for="">Registered Name <span>*</span></label>
                                        <p class="mb-0 pb-lg-0 pb-2">A registered company will get better ranking in search
                                            result</p>
                                    </div>

                                    <?= $form->field($model, 'register_comapany_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Registered Company Name', 'data-label' => 'Registered Name'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-lg-7 mt-4">
                                <div class="row">
                                    <!-- <div class="col-lg-12 mb-2">
                                        <div class="formInput">
                                            <label for="">Category <span>*</span></label>
                                            <?= $form->field($model, 'category_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Category', 'data-label' => 'Category'])->label(false) ?>

                                        </div>
                                    </div> -->
                                    <div class="col-lg-12 mb-2">
                                        <div class="formInput">
                                            <label for="">Address <span>*</span></label>
                                            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Enter Address', 'data-label' => 'Address'])->label(false) ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-2">
                                        <div class="formInput position-relative">
                                            <div class="d-sm-flex align-items-center justify-content-between flex-wrap">
                                                <label for="">Operates in Parks <span>*</span></label>
                                                <p class="mb-0 pb-xl-0 pb-2">In case of multiple parks, select the parks you operate in.</p>
                                            </div>

                                            <?= $form->field($model, 'park_id')->widget(Select2::classname(), [
                                                'data' => GeneralModel::safariparkoption(),
                                                // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                                'options' => ['placeholder' => 'Safari Tour Operator, Wildlife Photographer...', 'data-label' => 'Parks', 'multiple' => true],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label(false) ?>
                                            <div class="arrowIcon">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-5  mt-md-4 mt-2">

                                <div class="formInput">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <label for="">About Business</label>
                                        <p class="mb-0">120 words max.</p>
                                    </div>
                                    <?= $form->field($model, 'about_business')->textarea()->label(false) ?>
                                    <p id="wordCount" class="mb-0 text-end">0/120</p>
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
                                            <label for="">Phone Number</label>
                                            <?= $form->field($model, 'phone_no')->widget(\yii\widgets\MaskedInput::class, [
                                                'mask' => '9999999999',
                                                'options' => [
                                                    'placeholder' => '0000000000',
                                                ],
                                            ])->label(false) ?>
                                        </div>
                                        <div class="mobile_width div_remove">
                                            <p class="mb-0 pt-xxl-0 pt-3 pb-2">This phone number will be visible to clients</p>
                                            <?= $form->field($model, 'operator_phone_no')->widget(\yii\widgets\MaskedInput::class, [
                                                'mask' => '9999999999',
                                                'options' => [
                                                    'placeholder' => '0000000000',
                                                ],
                                            ])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="formInput mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="mobile_width div_remove">
                                            <label for="">Email Address <span>*</span></label>
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com'])->label(false) ?>
                                        </div>
                                        <div class="mobile_width div_remove">
                                            <p class="mb-0 pt-xl-2 pt-3 pb-2">This email address will be visible to clients</p>
                                            <?= $form->field($model, 'operator_email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com'])->label(false) ?>
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
                                <div class="formInput budgetSeg mb-3 position-relative">
                                    <div class="d-flex align-items-center justify-content-between  div_remove slect_remove gap-3 ">
                                        <label for="">Budget Segment <span>*</span></label>

                                        <?= $form->field($model, 'budget_segment')->widget(Select2::classname(), [
                                            'data' => GeneralModel::packageoption(),
                                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                            'options' => ['placeholder' => 'Select', 'multiple' => true],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false) ?>
                                        <div class="arrowIcon2">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </div>
                                    </div>

                                </div>
                                <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between  div_remove slect_remove gap-3">
                                        <label for="">Cancellation Policy</label>
                                        <?= $form->field($model, 'has_cancellation_policy')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"])->label(false) ?>


                                    </div>

                                </div>
                                <!-- <div class="formInput  mb-3">
                                    <div class="d-flex align-items-center justify-content-between div_remove slect_remove gap-3">
                                        <label for="">Rating</label>
                                        <?= $form->field($model, 'google_rating')->widget(\yii\widgets\MaskedInput::class, [
                                            'mask' => '9.9',
                                            'options' => [
                                                'class' => 'form-control',
                                                'placeholder' => 'Enter rating (e.g., 4.50)',
                                            ],
                                        ])->label(false) ?>
                                    </div>
                                </div> -->
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
                        <span class="dot active" data-index="0"></span>
                        <span class="dot" data-index="1"></span>
                        <!-- Add more dots for additional steps -->
                    </div>
                </div>
                <div class="row align-items-center pt-3">
                    <div class="col-sm-10">
                        <div class="term-condition text-center">
                            <p class="mb-0 d-flex justify-content-center align-items-center">
                                <?= $form->field($model, 'is_agree')->checkbox(['class' => 'me-2 checkbox_design'])->label('I agree to the <a  class="termBtn" data-bs-toggle="modal" data-bs-target="#modalsafritermsForm">terms and conditions.</a>'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="nextBtn float-end">
                            <button class="next-btn">Next</button>
                            <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                            <?= $form->field($model, 'referrer_url')->hiddenInput()->label(false) ?>
                            <?= Html::submitButton('Submit', ['class' => 'submit-btn submit-button next-btn', 'style' => 'display:none;']) ?>
                            <!-- <button class="submit-btn submit-button next-btn" style="display:none;">Submit</button> -->
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>

</section>
<script>
    const fileUpload = document.getElementById('fileupload');
    const uploadText = document.getElementById('uploadText');
    const browslogow3 = document.getElementById('browslogow3');

    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const file = fileUpload.files[0];

            const img = document.createElement('img');
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Clear any existing images before appending the new one
            const existingImg = browslogow3.querySelector('img');
            if (existingImg) {
                browslogow3.removeChild(existingImg);
            }

            browslogow3.appendChild(img);
            // Hide the uploadText when an image is uploaded
            uploadText.style.display = 'none';
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const textarea = document.getElementById('safaritourregistrationform-about_business');
        const wordCount = document.getElementById('wordCount');
        const maxLength = 120; // Maximum allowed words

        function updateWordCount() {
            // Regular expression to match alphanumeric sequences and common symbols in words
            const wordsArray = textarea.value.match(/[\w'-]+/g) || [];

            const wordsLength = wordsArray.length;
            if (wordsLength > maxLength) {
                wordCount.textContent = `${maxLength}/${maxLength}`;
                wordCount.style.color = 'red'; // Set color to red if words exceed the limit
            } else {
                wordCount.textContent = `${wordsLength}/${maxLength}`;
                wordCount.style.color = ''; // Reset color if words are within the limit
            }
        }

        textarea.addEventListener('input', function(event) {
            updateWordCount();
        });

        updateWordCount(); // Call the function initially to ensure the count is displayed correctly

        // Display initial count
        wordCount.textContent = `0/${maxLength}`;
    });

    function increment(id) {
        let input = document.getElementById(id);
        input.value = parseInt(input.value) + 1;
    }

    function decrement(id) {
        let input = document.getElementById(id);
        if (parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
<script>
    const textarea = document.getElementById('about_business');


    const forms = document.querySelectorAll('.form');
    const dots = document.querySelectorAll('.dot');
    const nextButton = document.querySelector('.next-btn');
    const submitButton = document.querySelector('.submit-btn');
    const termCondition = document.querySelector('.term-condition');

    let currentFormIndex = 0;

    function updateButtonVisibility() {
        if (currentFormIndex === forms.length - 1) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
            termCondition.classList.add('active');
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
            termCondition.classList.remove('active');
        }
    }

    function validateForm1() {
        const form1 = forms[0];
        const requiredDivs = form1.querySelectorAll('.required');
        let isValid = true;

        requiredDivs.forEach(div => {
            const inputs = div.querySelectorAll('input, textarea, select');
            let divValid = false;

            inputs.forEach(input => {
                const feedback = input.nextElementSibling;

                if (input.classList.contains('is-valid')) {
                    divValid = true;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.style.display = 'none';
                    }
                } else {
                    input.classList.add('is-invalid');
                    input.setAttribute('aria-required', 'true');
                    input.setAttribute('aria-invalid', 'true');
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        const label = input.getAttribute('data-label'); // Get attribute label from data-label attribute
                        feedback.textContent = `${label} cannot be blank`; // Update error message with label
                        feedback.style.display = 'block';
                    }
                }
            });

            if (!divValid) {
                isValid = false;
            }
        });

        return isValid;
    }

    nextButton.addEventListener('click', function(event) {
        event.preventDefault();
        // Validate form1
        if (currentFormIndex === 0 && validateForm1()) {
            // If form1 is valid, proceed to the next form
            if (currentFormIndex < forms.length - 1) {
                forms[currentFormIndex].classList.remove('active');
                dots[currentFormIndex].classList.remove('active');
                currentFormIndex++;
                forms[currentFormIndex].classList.add('active');
                dots[currentFormIndex].classList.add('active');
                updateButtonVisibility();
            }
        }
    });

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            if (index <= currentFormIndex) {
                if (index === 0 || validateForm1()) {
                    forms[currentFormIndex].classList.remove('active');
                    dots[currentFormIndex].classList.remove('active');
                    currentFormIndex = index;
                    forms[currentFormIndex].classList.add('active');
                    dots[currentFormIndex].classList.add('active');
                    updateButtonVisibility();
                }
            }
        });
    });

    // Prevent form submission on Enter key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && currentFormIndex < forms.length - 1) {
            event.preventDefault();
        }
    });

    // Validate form1 when any input changes
    forms[0].addEventListener('input', function() {
        validateForm1();
    });
</script>

<?php
// Directly fetch the data from the model
// Fetch the content based on the constant
$content = ContentManagement::findOne(['id' => ContentManagement::CM_SAFARI_TERM_AND_CONDITION]);
?>?>

<div class="modal fade _standard-text" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Terms & conditions</h1>
            </div>
            <div class="modal-body px-3">
                <div class="row">
                    <div class="col-12">
                        <div class="content_terms">
                            <h5>Terms & Conditions</h5>
                            <p><?= htmlspecialchars(strip_tags($content ? $content->content : 'No content available'), ENT_QUOTES, 'UTF-8') ?></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="backtohome">Back to Home</a>
                <button type="button" class="btns_submit">Agree</button>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
function termfunction() {
	$('.termBtn').on('click', function () {
        $('#termsmodal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
termfunction();

JS;
$this->registerJs($script);
?>