<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\compliancedocuments\ComplianceDocuments $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'enableClientValidation' => false
]); ?>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList(GeneralModel::compliancedropdown(), ['prompt' => 'Select'])->label('Compliance Document Title<span class="necessary">*</span>') ?>
    </div>

    <!-- <div class="col-md-6 mb-3">
        <div class="d-flex align-items-start gap-3">
            <div class="flex-grow-1">
                <?= $form->field($model, 'banner_image')->fileInput(['class' => 'form-control', 'id' => 'bannerImageInput', 'accept' => 'image/*'])->label('Banner Image <span class="necessary">*</span>', ['encode' => false]) ?>
            </div>

            <div class="external-preview border rounded p-2 bg-light text-center" style="width: 220px;">
                <?php if (!empty($model->cdocument_model->imagebannerpath)) { ?>
                    <img src="<?= $model->cdocument_model->imagebannerpath ?>" alt="Current Banner" id="existingBanner" class="img-fluid rounded" style="max-height: 180px; object-fit: cover;">
                <?php } else { ?>
                    <div id="noImageText" class="text-muted small py-5">No image<br>uploaded</div>
                <?php } ?>

                <img id="imagePreviewBottom" src="#" alt="Image Preview" class="img-fluid rounded mt-2" style="display:none; max-height: 180px; object-fit: cover; border: 1px solid #ccc;">
            </div>
        </div>
    </div> -->



    <div class="row">
        <?= $form->field($model, 'content', ['labelOptions' => ['class' => 'Modal_label']])->textarea(['id' => 'compliancedocumentsform-content', 'rows' => '6', 'placeholder' => 'Add Content Here'])->label('Content <span class="necessary">*</span>') ?>
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
        min-height: 400px;
    }
</style>
<?php
$script = <<< JS

editor('compliancedocumentsform-content');

$('#bannerImageInput').on('change', function (e) {
    const file = e.target.files[0];
    const preview = $('#imagePreviewBottom');
    const existing = $('#existingBanner');
    const noImageText = $('#noImageText');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            preview.attr('src', event.target.result).show();
            existing.hide();
            noImageText.hide();
        };
        reader.readAsDataURL(file);
    } else {
        preview.hide();
        existing.show();
        noImageText.show();
    }
});

JS;
$this->registerJs($script);
?>