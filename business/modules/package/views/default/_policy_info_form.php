<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php $form = ActiveForm::begin([
    'id' => 'policy-info-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="col-xl-12">

    <div class="text-wrap custom_color">
        <div class="example">
            <div class="d-md-flex">
                <div class="">
                    <div class="panel panel-primary tabs-style-4">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs me-3">
                                    <li class=""><a href="#tab21" class="active" data-bs-toggle="tab"> Terms Condtition</a></li>
                                    <li><a href="#tab25" data-bs-toggle="tab"> Date Change Policy</a></li>
                                    <li><a href="#tab26" data-bs-toggle="tab"> Refund Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs-style-4 w-100 ">
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab21">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'package_terms_condtition')->textarea(['rows' => '2', 'placeholder' => 'Mention Terms & Condtitions'])->label('Package Terms Condtition') ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab25">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'date_change_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Date Change Policy'])->label('Date Change Policy') ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab26">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'refund_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Refund Policy'])->label('Refund Policy') ?>
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
                <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
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
bulleteditor('packageform-date_change_policy');
bulleteditor('packageform-refund_policy');
JS;
$this->registerJs($script);
?>