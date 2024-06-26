<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->params['active_link'] = 'contact';
$this->title = 'Contact';
?>
<section class="contact-wrappers mb-5 ">
    <div class="container-lg padding_bottom">
        <div class="contact-head">
            <h3 class="mb-3">Have A Query! Please Leave Your Contact Details.</h3>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="row gy-4">
                    <div class="col-md-6 col-lg-4 ">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center bg-white rounded p-3 icon-wrap">
                                <div class="icon me-3">
                                    <i class="fa fa-map-marker-alt "></i>
                                </div>
                                <span>New Delhi , India</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 ">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center bg-white rounded p-3 icon-wrap">
                                <div class="icon me-3">
                                    <i class="fa fa-envelope-open "></i>
                                </div>
                                <span><a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 ">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center bg-white rounded p-3 icon-wrap">
                                <div class="icon me-3">
                                    <i class="fa fa-phone-alt "></i>
                                </div>
                                <span><a href="tel:212 386 5575">212 386 5575</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 Up" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
            <iframe class="position-relative rounded w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112173.19063594783!2d77.12658453167289!3d28.52732733787663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1719403449236!5m2!1sen!2sin"    style="min-height: 500px; border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 form-bg">
                <div class="Up">
                    <h5 >get in touch</h5>
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                            <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Name*'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                            <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'type' => 'text', 'onkeypress' => 'return /[0-9]/i.test(event.key)', 'placeholder' => 'Phone*'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                            <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'Email*'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                            <?= $form->field($model, 'message')->textarea(['class' => 'form-control', 'rows' => 8, 'placeholder' => 'Message*'])->label(false)  ?>
                            </div>
                        </div>
                        <div class="col-12 btn-bg">
                            <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                            <?= Html::submitButton('Submit', ['class' => 'btn w-100 py-3 ', 'name' => 'register-button']) ?>
                            <!-- <button class="btn w-100 py-3" type="submit" fdprocessedid="0fdl2">Send Message</button> -->
                        </div>
                    </div>
                    </form>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</section>
