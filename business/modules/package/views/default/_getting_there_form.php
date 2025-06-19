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


<div class="tab-pane" id="getting" role="tabpanel" aria-labelledby="getting_there">
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <div class="form_boxes mb-3">
                    <label for="">How to reach</label>
                    <?= $form->field($model, 'getting_there')->textarea(['rows' => '2', 'placeholder' => 'How to reach','class'=>'form-control rounded-0'])->label(false) ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'button-created create']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
    .ck-editor__editable {
        min-height: 200px;
    }
</style>
<?php
$script = <<< JS
bulleteditor('PackageVersionForm-getting_there');
JS;
$this->registerJs($script);
?>