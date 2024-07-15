<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="card">
    <div class="card-body">
        <div class="col-xl-12">
            <!-- div -->

            <div class="text-wrap custom_color">
                <div class="example">
                    <div class="d-md-flex">
                        <div class="">
                            <div class="topics_listing">
                                <ul>
                                    <li><a class="active" href="#tab21">
                                            <div class="numparks">Terms Condtition</div><i class="fa-solid fa-chevron-right"></i>
                                        </a></li>

                                    <li><a href="#tab22">
                                            <div class="numparks">Privacy Policy</div><i class="fa-solid fa-chevron-right"></i>
                                        </a></li>
                                    <li><a href="#tab23">
                                            <div class="numparks">Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li><a href="#tab24">
                                            <div class="numparks">What You Must Carry </div><i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li><a href="#tab25">
                                            <div class="numparks">Date Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li><a href="#tab26">
                                            <div class="numparks">Refund Policy </div><i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="tabs-style-4 w-100 ">
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-content_tour active" id="tab21">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'package_terms_condtition')->textarea(['rows' => '2', 'placeholder' => 'Package Terms Condtition'])->label('Package Terms Condtition') ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab22">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'privacy_policy')->textarea(['rows' => '2', 'placeholder' => 'Package Privacy Policy'])->label('Package Privacy Policy') ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab23">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'change_policy')->textarea(['rows' => '2', 'placeholder' => 'Package Change Policy'])->label('Package Change Policy') ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab24">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'what_you_must_carry')->textarea(['rows' => '2', 'placeholder' => 'Package What You Must Carry'])->label('Package What You Must Carry') ?>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab25">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'date_change_policy')->textarea(['rows' => '2', 'placeholder' => 'Package What You Must Carry'])->label('Package What You Must Carry') ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab26">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'refund_policy')->textarea(['rows' => '2', 'placeholder' => 'Package What You Must Carry'])->label('Package What You Must Carry') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'submit-btn submit-button next-btn']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<style>
    .ck-editor__editable {
        min-height: 350px;
        min-width: 350px;
    }
</style>
<?php
$script = <<< JS
bulleteditor('packageform-package_terms_condtition');
bulleteditor('packageform-privacy_policy');
bulleteditor('packageform-change_policy');
bulleteditor('packageform-what_you_must_carry');
bulleteditor('packageform-date_change_policy');
bulleteditor('packageform-refund_policy');
JS;
$this->registerJs($script);
?>