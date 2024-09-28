<?php
$this->title = 'Account Settings';

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container-lg mt-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a class="btn btn-info bg-blues py-2 rounded-5" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity ? Yii::$app->user->identity->user_handle : '']) ?>">View Profile</a>
        </div>
        <div class=" col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'privacy']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                    <h6 class="fs-5 fw-bold mb-5"> Select who may see your profile details</h6>

                    <?php $form = ActiveForm::begin([
                        'id' => 'privacy-form',
                        'method' => 'POST',
                    ]); ?>
                    <div class="row align-items-center ">
                        <div class="col-md-3">
                            <label for="" class="Modal_label"> Gender</label>
                        </div>
                        <div class="col-md-9">
                            <?= $form->field($model, 'gender_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-3 ">
                            <label for="" class="Modal_label"> Email</label>
                        </div>
                        <div class="col-md-9 ">
                            <?= $form->field($model, 'email_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>

                    <!-- <div class="row ">
                        <div class="col-md-3 ">
                        <label for="" class="Modal_label">  Photo</label>
                        </div>
                       
                        <div class="col-md-9">
                            <?= $form->field($model, 'photo_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        <label for="" class="Modal_label">   Contribution</label> 
                        </div>
                        <div class="col-md-9 ">
                            <?= $form->field($model, 'contribution_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div> -->
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php

$script = <<< JS
    $('form select').on('change', function(){
        $("#privacy-form").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    }); 
   
    $('form').on('change', function(){
        $("#privacy-form").attr("data-pjax", "true");    
        $(this).closest('form').submit();
       
    }); 
JS;
$this->registerJs($script);
?>