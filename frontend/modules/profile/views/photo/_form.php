<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-md-12">

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'article-form',
                'method' => 'POST',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'enableClientScript' => true,
                'action' => $model->action_url,
                'validationUrl' => $model->action_validate_url,
            ]); ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="browslogow3" id="browslogow3">
                        <div class="text" id="uploadText">Browse Logo <br><span class="span_title"> (JPEG /JPG or PNG / 250 KB)</span></div>
                        <?= $form->field($model, 'file')->fileInput(['class' => 'fileupload', 'id' => 'fileupload'])->label(false) ?>

                        <!-- <input id="fileupload" type="file" class="fileupload" /> -->
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'caption')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Enter Photo Caption',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    const fileUpload = document.getElementById('fileupload');
    const uploadText = document.getElementById('uploadText');
    const browslogow3 = document.getElementById('browslogow3');

    fileUpload.addEventListener('change', function() {
        if (fileUpload.files.length > 0) {
            const file = fileUpload.files[0];

            const img = document.createElement('img');
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Clear any existing images before appending the new one
            const existingImg = browslogow3.querySelector('img');
            if (existingImg) {
                browslogow3.removeChild(existingImg);
            }

            browslogow3.appendChild(img);
            // Hide the uploadText when an image is uploaded
            uploadText.style.display = 'none';
        }
    });
</script>