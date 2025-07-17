<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'post',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Search by Email'])->label(false) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'created_at')->input('date', [
            'placeholder' => 'Search by Request DateTime',
            'class' => 'form-control'
        ])->label('Date') ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(['10' => 'Active', '9' => 'Inactive'], ['placeholder' => 'Search by Status'])->label(false) ?>
    </div>

    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>