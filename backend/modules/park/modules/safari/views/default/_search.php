<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
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

    <div class="col-md-3">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Title'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::newrecentstatusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'show_in_filter')->dropDownList(
            ['1' => 'Yes', '2' => 'No'],
            [
                'prompt' => 'Main Filter Search',
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>