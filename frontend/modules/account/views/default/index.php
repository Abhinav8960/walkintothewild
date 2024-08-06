<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use function PHPSTORM_META\type;

$this->title = 'Account Settings';

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
                    <ul class="nav nav-tabs mb-4  border-bottom " id="pills-tab" role="tablist">
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
                    <div class="tab-content  form-inputssetting" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-general-information" role="tabpanel" aria-labelledby="pills-general-information-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
                                </div>

                                <div class="col-md-6 typeaccount">
                                    <?php
                                    $account_type = [1 => 'Individual/Personal', 2 => 'Wildlife Influencer/Photographer', 3 => 'Safari Operator'];
                                    if (Yii::$app->user->identity->is_safari_operator == 1 && !in_array($model->account_type, [1])) {
                                        echo 'Account Type <br> <b>' . (isset($account_type[$model->account_type]) ? $account_type[$model->account_type] : $model->account_type) . '</b>';
                                    } else { ?>
                                        <?= $form->field($model, 'account_type')->radioList($account_type) ?>
                                    <?php  } ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $form->field($model, 'user_handle')->textInput(['maxlength' => true, 'placeholder' => 'User Name'])->hint('<i>Allowed Character: az09_</i>') ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'date_of_birth')->textInput(['type' => 'date', 'max' => date("Y-m-d", strtotime("-18 year", time())), 'placeholder' => 'Select D.O.B']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female', '3' => 'Others'], ['prompt' => 'Select Gender']) ?>
                                </div>

                                <div class="col-md-12">
                                    <?= $form->field($model, 'user_bio')->textarea(['rows' => 2, 'maxlength' => true, 'placeholder' => 'Profile Description eg: Wildlife | Nature']) ?>
                                </div>


                                <div class="col-md-12">
                                    <?= $form->field($model, 'about')->textarea(['rows' => 6, 'placeholder' => 'About']) ?>
                                </div>

                                <div class="col-md-12">
                                    <?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true, 'placeholder' => 'Facebook Link']) ?>
                                </div>

                                <div class="col-md-12">
                                    <?= $form->field($model, 'x_url')->textInput(['maxlength' => true, 'placeholder' => 'X Link']) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($model, 'insta_url')->textInput(['maxlength' => true, 'placeholder' => 'Instagram Link']) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($model, 'website_url')->textInput(['maxlength' => true, 'placeholder' => 'Website Link']) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($model, 'youtube_url')->textInput(['maxlength' => true, 'placeholder' => 'Youtube Link']) ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="float-end">
                                        <?= Html::submitButton('Save Changes', ['class' => 'post-comment']) ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile-photo" role="tabpanel" aria-labelledby="pills-profile-photo-tab" style="min-height:500px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'profile_image')->fileInput() ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="float-end">
                                        <?= Html::submitButton('Save Changes', ['class' => 'post-comment']) ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="pills-cover-photo" role="tabpanel" aria-labelledby="pills-cover-photo-tab" style="min-height:500px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'cover_image')->fileInput() ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="float-end">
                                        <?= Html::submitButton('Save Changes', ['class' => 'post-comment']) ?>
                                    </div>

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