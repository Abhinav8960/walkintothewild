<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'email-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row g-3">

    <div class="col-md-12">
        <div class="form_boxes mb-3">
            <label for="">Lead Category</label>
            <?= $form->field($model, 'lead_category')->dropDownList(GeneralModel::leadcategoryoption(), ['prompt' => 'Select Lead Category'])->label(false) ?>
        </div>
    <hr>
    <div class="col-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success text-white px-4']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>