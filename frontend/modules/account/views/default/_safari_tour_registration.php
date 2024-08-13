<?php

use common\models\cms\contentmanagement\ContentManagement;
use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Safari Tour Operator Registration';
$this->params['title'] = $this->title;
?>

<div class="container-lg mt-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a class="btn btn-info bg-blues py-2 rounded-5" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">View Profile</a>
        </div>
        <div class=" col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card account-settingside safartabs ">
                <div class="card-body p-4">
                    <?= $this->render('_tablist', ['accountType' => 'active']) ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'safariform',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'enableClientScript' => true,
                        'action' => $model->action_url,
                        'validationUrl' => $model->action_validate_url,
                    ]); ?>
                    <div class="col-md-6 typeaccount">
                        <?php
                        $account_type = [1 => 'Individual/Personal', 2 => 'Wildlife Influencer/Photographer', 3 => 'Safari Operator'];
                        ?>
                        <?= $form->field($model, 'account_type')->radioList($account_type) ?>
                    </div>
                    <div class="registration-form">
                        <div class="row pt-4">

                            <div class="col-lg-3 col-md-3">

                                <div class="browslogow3" id="browslogow3">
                                    <div class="text" id="uploadText">Browse Logo <br><span class="span_title"> (JPEG /JPG or PNG / 250 KB)</span></div>
                                    <?= $form->field($model, 'logo')->fileInput(['class' => 'fileupload', 'id' => 'fileupload'])->label(false) ?>
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
                                                'options' => ['placeholder' => 'Safari Tour Operator, Wildlife Photographer...',  'multiple' => true],
                                                'pluginOptions' => [
                                                    'initialize' => true,
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
                                                        'itemOptions' => ['class' => 'checkbox_design'],
                                                    ]
                                                )->label(false); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row align-items-center pt-3">
                            <div class="col-sm-10">
                                <div class="term-condition text-center" style="display: block;">
                                    <p class="mb-0 d-flex justify-content-center align-items-center">
                                        <?= $form->field($model, 'is_agree')->checkbox(['class' => 'me-2 checkbox_design'])->label('I agree to the <a  class="termBtn" data-bs-toggle="modal" data-bs-target="#modalsafritermsForm">terms and conditions.</a>'); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="nextBtn float-end">
                                    <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                                    <?= $form->field($model, 'referrer_url')->hiddenInput()->label(false) ?>
                                    <?= Html::submitButton('Submit', ['class' => 'submit-btn submit-button next-btn']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$content = ContentManagement::findOne(['id' => ContentManagement::CM_SAFARI_TERM_AND_CONDITION]);
$showModal = $content && $content->status == \common\interfaces\StatusInterface::STATUS_ACTIVE;
?>
<?php if ($showModal) {  ?>
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
                                <p><?= $content ? Html::decode($content->content) : 'No content available' ?></p>
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
<?php } ?>

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

<?php
$script = <<< JS
$(document).ready(function(){
  $(".registration-form").hide();
  $("#safaritourregistrationform-account_type").change(function(){
    var selectedValue = $('#safaritourregistrationform-account_type input:checked').val()
    if(selectedValue == 2 || selectedValue == 3)
    {
        $(".registration-form").show();
    }else{
        $(".registration-form").hide();
    }
    
  });
});

JS;
$this->registerJs($script);
?>