<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <div class="col-md-3">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Title'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'policy_for')->dropDownList(['User' => 'User', 'Business' => 'Business'], ['prompt' => 'Search by Policy For'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'version')->textInput(['placeholder' => 'Search by Version'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::statusoptions(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>