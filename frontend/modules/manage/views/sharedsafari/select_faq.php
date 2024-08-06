<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>

<div class="row mt-2 p-4">
    <div class="col-md-12">
        <?= $form->field($model, 'faq_id')->dropDownList(GeneralModel::mastersharesafarifaqoption($shared_safari_departure_model->id), ['prompt' => 'Select FAQ'])->label(false) ?>
    </div>
    <div class="col-md-12">
    <div class="creat-safri d-flex justify-content-end ">
                    <?= Html::submitButton('Create ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                </div>
            </div>
</div>


<?php ActiveForm::end(); ?>