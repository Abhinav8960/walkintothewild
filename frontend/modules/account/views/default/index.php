<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;


$this->title = 'Account Settings';

?>
<?php $form = ActiveForm::begin([
    'id' => 'user-form',
    'method' => 'POST',
]); ?>
<div class="container-lg mt-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <div class="unsaved_changes text-danger"></div>
            <div class="justify-content-between">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save Changes', ['class' => 'post-comment']) ?>
                <a class="post-comment newbg rounded-2 padding_btn" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">View Profile</a>
            </div>
        </div>
        <div class=" col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card account-settingside safartabs ">
                <div class="card-body p-4">
                    <?= $this->render('_tablist', ['general' => 'active']) ?>

                    <div class="tab-content  form-inputssetting" id="pills-tabContent">

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
                            </div>

                            <div class="col-md-6 typeaccount">
                                <?php
                                $account_type = [1 => 'Individual/Personal', 2 => 'Wildlife Influencer', 3 => 'Safari Operator'];
                                echo 'Account Type <br> <b>' . (isset($account_type[$model->account_type]) ? $account_type[$model->account_type] : '') . '</b>';
                                ?>

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

                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
    $('form').on('change', function(){
        $(".unsaved_changes").html("Unsaved Changes!"); 
    });
JS;
$this->registerJs($script);
?>