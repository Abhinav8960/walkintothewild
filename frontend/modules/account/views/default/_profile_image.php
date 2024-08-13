<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;


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
                    <?= $this->render('_tablist', ['profile_photo' => 'active']) ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'user-form',
                        'method' => 'POST',
                    ]); ?>
                    <div class="tab-content  form-inputssetting" id="pills-tabContent">

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
                    <?php ActiveForm::end(); ?>

                </div>

            </div>
        </div>
    </div>
</div>