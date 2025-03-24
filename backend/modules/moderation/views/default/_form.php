<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'moderation']); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'type')->dropDownList(
                    [
                        // 1 => 'Text',
                        2 => 'Video',
                        3 => 'Image'
                    ],
                    ['prompt' => 'Select Option', 'id' => 'type-selector']
                ); ?>
            </div>
            <div class="col-md-6 field-text">
                <!-- <?= $form->field($model, 'text')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Text',
                ]) ?> -->
            </div>

            <div class="col-md-6 field-video">
                <?= $form->field($model, 'video')->fileInput()->label('Video') ?>
            </div>

            <div class="col-md-6 field-image">
            <?= $form->field($model, 'image')->fileInput()->label('Image') ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$show_hide_script = <<< JS
    function toggleFields() {
        var type = $("#type-selector").val();
        $('.field-text, .field-video, .field-image').hide();
        
        if (type == 1) {
            $('.field-text').show();
        } else if (type == 2) {
            $('.field-video').show();
        } else if (type == 3) {
            $('.field-image').show();
        }
    }

    $(document).ready(function() {
        toggleFields();
        $("#type-selector").change(function() {
            toggleFields();
        });
    });
JS;
$this->registerJs($show_hide_script);
?>