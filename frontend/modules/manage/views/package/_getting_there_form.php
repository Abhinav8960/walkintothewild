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
            <div class="col-md-12">
                <?= $form->field($model, 'getting_there')->textarea(['rows' => '2', 'placeholder' => 'Package Getting There'])->label('Package Getting There') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="creat-safri float-end w-auto">
                    <?= Html::submitButton('Create ', ['class' => 'safari_create font_set ']) ?>
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
bulleteditor('packageform-getting_there');
JS;
$this->registerJs($script);
?>