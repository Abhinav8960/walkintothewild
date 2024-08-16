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
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php foreach (GeneralModel::packageincludeoption() as $optionValue => $optionLabel) : ?>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="control-label"><?= $optionLabel ?></label>
                            </div>
                            <div class="col-sm-9">
                                <?= $form->field($model, 'package_included[' . $optionValue . ']')->radioList(
                                    [
                                        '1' => 'Included',
                                        '2' => 'Not Included',
                                        // '3' => 'Optional',
                                    ],
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="form-check form-check-inline">' .
                                                '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>' .
                                                '<label class="form-check-label">' . $label . '</label>' .
                                                '</div>';
                                        },
                                        'itemOptions' => ['class' => 'form-check-input'], // Additional item options if needed
                                    ]
                                )->label(false) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'package_inclusion')->textarea(['rows' => '2', 'placeholder' => 'List everything included'])->label('Package Inclusion') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'package_exclusion')->textarea(['rows' => '2', 'placeholder' => 'List what is not included'])->label('Package Exclusion') ?>
            </div>
        </div>
        <hr>
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
bulleteditor('packageform-package_inclusion');
bulleteditor('packageform-package_exclusion');
JS;
$this->registerJs($script);
?>
<style>
    .form-check-input[type="radio"] {
        width: 20px;
        height: 20px;
        border-radius: 50% !important;
        /* Additional styles as needed */
    }

    .form-check-label {
        /* Additional label styles if necessary */
        margin-left: 5px;
        /* Example: Adds a margin to the left of the label */
    }
</style>