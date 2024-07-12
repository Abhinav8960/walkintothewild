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
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'package_terms_condtition')->textarea(['rows' => '2', 'placeholder' => 'Package Terms Condtition'])->label('Package Terms Condtition') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'privacy_policy')->textarea(['rows' => '2', 'placeholder' => 'Package Privacy Policy'])->label('Package Privacy Policy') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'change_policy')->textarea(['rows' => '2', 'placeholder' => 'Package Change Policy'])->label('Package Change Policy') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'what_you_must_carry')->textarea(['rows' => '2', 'placeholder' => 'Package What You Must Carry'])->label('Package What You Must Carry') ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('packageform-package_terms_condtition');
editor('packageform-privacy_policy');
editor('packageform-change_policy');
editor('packageform-what_you_must_carry');
JS;
$this->registerJs($script);
?>