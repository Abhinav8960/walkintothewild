<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Account Settings';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-3">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <ul class="nav nav-pills mb-3 m-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-general-information-tab" data-bs-toggle="pill" data-bs-target="#pills-general-information" type="button" role="tab" aria-controls="pills-general-information" aria-selected="true">General Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-profile-photo" type="button" role="tab" aria-controls="pills-profile-photo" aria-selected="false">Profile Photo</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-cover-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-cover-photo" type="button" role="tab" aria-controls="pills-cover-photo" aria-selected="false">Cover Photo</button>
                    </li>
                </ul>
                <?php $form = ActiveForm::begin([
                    'id' => 'user-form',
                    'method' => 'POST',
                ]); ?>
                <div class="tab-content m-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-general-information" role="tabpanel" aria-labelledby="pills-general-information-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'account_type')->radioList([1 => 'Individual/Personal', 2 => 'Wildlife Influencer', 3 => 'Safari Operator']) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'user_handle')->textInput(['maxlength' => true, 'placeholder' => 'User Name']) ?>
                            </div>

                            <div class="col-md-12">
                                <?= $form->field($model, 'about')->textarea(['rows' => 6, 'placeholder' => 'About']) ?>
                            </div>

                            <div class="col-md-12">
                                <?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true, 'placeholder' => 'Facebook Link']) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'whatsapp_url')->textInput(['maxlength' => true, 'placeholder' => 'Whatsapp Link']) ?>
                            </div>

                            <div class="col-md-12">
                                <?= $form->field($model, 'x_url')->textInput(['maxlength' => true, 'placeholder' => 'X Link']) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'insta_url')->textInput(['maxlength' => true, 'placeholder' => 'Instagram Link']) ?>
                            </div>

                            <div class="col-md-12">
                                <?= Html::submitButton('Save Chnages', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile-photo" role="tabpanel" aria-labelledby="pills-profile-photo-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'profile_image')->fileInput() ?>
                            </div>

                            <div class="col-md-12">
                                <?= Html::submitButton('Save Chnages', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-cover-photo" role="tabpanel" aria-labelledby="pills-cover-photo-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'cover_image')->fileInput() ?>
                            </div>

                            <div class="col-md-12">
                                <?= Html::submitButton('Save Chnages', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>