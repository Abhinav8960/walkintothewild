<?php

use common\models\GeneralModel;
use common\models\partnerregistration\PartnerRegistration;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Update Details';
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $safari_operator_update_model, 'active_navbar' => 'update-details']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <?php $form = ActiveForm::begin(['options' => ['id' => 'update_detail', 'enctype' => 'multipart/form-data']]); ?>

                            <h5>Legal Entity</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($model, 'operator_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Legal Entity Name',
                                    ])->label('Legal Entity Name') ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'legal_entity_type')->dropDownList(PartnerRegistration::entitytypeoption(), [
                                        'class' => 'form-control',
                                        'prompt' => 'Select Entity Type',
                                    ]) ?>
                                </div>


                                <div class="col-md-3">
                                    <?= $form->field($model, 'business_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Brand Name',
                                    ])->label('Brand Name') ?>
                                </div>


                                <div class="col-md-3">
                                    <?= $form->field($model, 'legal_entity_whatsapp')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Legal Entity Whatsapp',
                                    ])->label('Legal Entity Whatsapp') ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'legal_entity_email')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Legal Entity Email',
                                    ])->label('Legal Entity Email') ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'address')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Address',
                                    ]) ?>
                                </div>


                                <div class="col-md-3">
                                    <?= $form->field($model, 'logo_file')->fileInput()->label('Logo File Upload') ?>
                                </div>

                                <?php if ($safari_operator_update_model->Imagepath) { ?>
                                    <div class="col-md-3 w-auto">
                                        <img src="<?= $safari_operator_update_model->Imagepath ?>" height="80px" alt="Logo Image">
                                    </div>
                                <?php } ?>



                                <h5>Registration Proof</h5>
                                <hr>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'registration_number')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Registration Number',
                                    ])->label('Company Registration Number') ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'pan_number')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 10,
                                        'pattern' => '[A-Z]{5}[0-9]{4}[A-Z]',
                                        'title' => 'PAN must be in format AAAAA9999A',
                                        'oninput' => 'this.value = this.value.toUpperCase();',
                                        'placeholder' => 'Enter PAN number',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'registration_copy_upload')->fileInput([
                                        'class' => 'form-control',
                                    ])->label('Registration Copy') ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'pan_upload')->fileInput([
                                        'class' => 'form-control',
                                    ])->label('Pan Card') ?>
                                </div>

                                <h5>Business Details</h5>
                                <hr>

                                <div class="col-md-12">
                                    <?= $form->field($model, 'about_business')->textarea([
                                        'class' => 'form-control',
                                        'rows' => 3,
                                        'placeholder' => 'Enter About Your Business',
                                    ])->label('About Business') ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'billing_phone')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 10,
                                        'placeholder' => 'Enter Billing Phone',
                                        'onkeypress' => 'return /[0-9]/i.test(event.key)',
                                    ]) ?>
                                </div>

                                <h5>Bank Details</h5>
                                <hr>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'bank_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Bank Name',
                                    ]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'account_holder_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Account Holder`s Name',
                                    ]) ?>
                                </div>

                                <div class="col-md-4">
                                    <?= $form->field($model, 'account_number')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 18,
                                        'pattern' => '[0-9]{9,18}',
                                        'title' => 'Enter a valid account number (9–18 digits)',
                                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                                        'placeholder' => 'Enter Account Number',
                                    ]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'ifsc_number')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 11,
                                        'pattern' => '[A-Z]{4}0[A-Z0-9]{6}',
                                        'title' => 'IFSC should be 11 characters: 4 letters, 0, then 6 alphanumeric (e.g., HDFC0001234)',
                                        'oninput' => "this.value = this.value.toUpperCase();",
                                        'placeholder' => 'Enter IFSC',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'cancel_check_upload')->fileInput([
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <h5>User Kyc</h5>
                                <hr>

                                <div class="col-md-4">
                                    <?= $form->field($model, 'owner_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Owner Name',
                                    ]) ?>
                                </div>

                                <div class="col-md-4">
                                    <?= $form->field($model, 'kyc_whatsapp')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Whatsapp Number',
                                        'onkeypress' => 'return /[0-9]/i.test(event.key)',
                                    ]) ?>
                                </div>

                                <div class="col-md-4">
                                    <?= $form->field($model, 'kyc_email')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Email',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'kyc_pan')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 10,
                                        'oninput' => "this.value = this.value.toUpperCase();",
                                        'placeholder' => 'Enter PAN',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'aadhar_number')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 12,
                                        'minlength' => 12,
                                        'pattern' => '[2-9]{1}[0-9]{11}',
                                        'title' => 'Aadhaar number must be 12 digits and start with 2–9',
                                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');",
                                        'placeholder' => 'Enter Aadhaar',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'kyc_pan_upload')->fileInput([
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'aadhar_front_upload')->fileInput([
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'aadhar_back_upload')->fileInput([
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>


                                <h5>System Settings</h5>
                                <hr>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'show_lead_phone_number')->radioList([1 => 'Yes', 0 => 'No']) ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= Html::a('Cancel', ['view', 'id' => $safari_operator_update_model->id], ['class' => 'btn btn-danger text-white']) ?>
                                        <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                                    </div>
                                </div>

                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .text-box p span {
        color: brown !important;
    }
</style>