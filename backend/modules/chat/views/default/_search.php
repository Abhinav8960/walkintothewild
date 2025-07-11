<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$names = ArrayHelper::getColumn(
    User::find()->select('name')->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
    'name'
);

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform',
        'class' => 'd-flex align-items-center flex-wrap gap-2', 
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="mt-3">
<div class="col-md-6">
<?= $form->field($model, 'name')->textInput([
    'placeholder' => 'Search by name',
    'class' => 'form-control',
    'style' => 'width: 200px;',
]) ?>
</div>
</div>
<div class="col-md-3">
<?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
</div>
<?php ActiveForm::end(); ?>



