<?php
$this->title = 'Account Settings';

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a class="btn btn-info bg-blues py-2 rounded-5" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">View Profile</a>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'privacy']); ?>
        </div>
        <div class="col-md-9">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                    <h6 class="fs-5 fw-bold mb-3"> Select who may see your profile details</h6>

                    <?php $form = ActiveForm::begin([
                        'id' => 'privacy-form',
                        'method' => 'POST',
                    ]); ?>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-3 mt-3">
                            Gender
                        </div>
                        <div class="col-md-3 mt-3">
                            <?= $form->field($model, 'gender_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-3 mt-5">
                            Email
                        </div>
                        <div class="col-md-3 mt-5">
                            <?= $form->field($model, 'email_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-md-3 mt-5">
                            Photo
                        </div>
                        <div class="col-md-3 mt-5">
                            <?= $form->field($model, 'photo_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-3 mt-5">
                            Contribution
                        </div>
                        <div class="col-md-3 mt-5">
                            <?= $form->field($model, 'contribution_privacy')->dropDownList(GeneralModel::privacyoptions())->label(false) ?>
                        </div>
                    </div>
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