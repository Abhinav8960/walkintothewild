<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Search by Login ID'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Search by Email'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(['10' => 'Active', '9' => 'Inactive'], ['placeholder' => 'Search by Status'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>