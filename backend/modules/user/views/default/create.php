<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'User: Register New User';
$this->params['breadcrumbs_home_url'] = '/user/default/index';
$this->params['breadcrumbs'][] =  ['label' => 'User', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'add-form',
                    'options' => ["autocomplete" => "off"]
                ]);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="font-weight-bold">User Detail</h6>
                    </div>
                    <div class="col-md-6 col-xl-4 col-lg-4 col-sm-6">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Name']) ?>
                    </div>

                    <div class="col-md-6 col-xl-4 col-lg-4 col-sm-6">
                        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email Address']) ?>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <h6 class="font-weight-bold">Login Details</h6>
                    </div>

                    <div class="col-md-6 col-xl-4 col-lg-4 col-sm-6">
                        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Enter Login ID']) ?>
                    </div>

                    <div class="col-md-6 col-xl-4 col-lg-4 col-sm-6">

                        <div style="display:flex; align-items:center;">
                            <div style="flex: 1;">
                                <?= $form->field($model, 'password')
                                    ->passwordInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Password',
                                    ]) ?>
                            </div>
                            <span class="btn btn-info p-2 toggle-password" title="View Password" data-bs-toggle="tooltip"><i class="fa fa-eye"></i></span>
                        </div>

                    </div>

                    <div class="col-md-4 select_width">
                        <?= $form->field($model, 'role_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => GeneralModel::roles(),
                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'options' => ['placeholder' => 'Select User Role', 'multiple' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="col-md-12 mt-2">
                    <?= Html::submitButton('Register User', ['class' => 'btn p-2 btn-info']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS

    $('.toggle-password').click(function () {
        $(this).children().toggleClass('mdi-eye-outline mdi-eye-off-outline');
        $('#userregistrationform-password').attr('type', $('#userregistrationform-password').attr('type') === 'password' ? 'text' : 'password');
    });
JS;
$this->registerJs($js);
?>

<style>
    .field-userregistrationform-password {
        width: 100%;
    }

    .select_width .select2.select2-container {

        width: 100% !important;
        display: block !important;
    }
</style>