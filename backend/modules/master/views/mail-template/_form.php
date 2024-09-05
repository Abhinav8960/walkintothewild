<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\email\MasterEmail $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Template Name']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Enter Template Code']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'path')->textInput(['maxlength' => true, 'placeholder' => 'Enter Path']) ?>
    </div>

    <?php if ($model->mail_template_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>




    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>
<?php
$directoryPath = Yii::$app->params['datapath'];
$partToRemove = '-data';

// Remove the part from the directory path
$result = str_replace($partToRemove, '', $directoryPath);

// Remove any trailing slashes that might be left
$result = rtrim($result, '/');
$filePath = '' . $result . '/common/mail/' . $model->path . '.php';

if (file_exists($filePath)) {
    header('Content-Type: text/html; charset=UTF-8');
    readfile($filePath);
} else {
    http_response_code(404);
    echo 'File not found.';
} ?>