<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\compliancedocuments\ComplianceDocuments $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Add Title'])->label('Compliance Document Title<span class="necessary">*</span>') ?>
    </div>
    
    <div class="row">
        <?= $form->field($model, 'content', ['labelOptions' => ['class' => 'Modal_label']])->textarea(['rows' => '6', 'placeholder' => 'Add Content Here'])->label('Content <span class="necessary">*</span>') ?>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
<style>
    .ck-editor__editable {
        min-height: 450px;
    }
</style>
<?php
$script = <<< JS
editor('compliancedocumentsform-description');
JS;
$this->registerJs($script);
?>