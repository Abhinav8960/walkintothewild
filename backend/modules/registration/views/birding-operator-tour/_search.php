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
        <?= $form->field($model, 'business_name')->textInput(['placeholder' => 'Search by Business Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'register_comapany_name')->textInput(['placeholder' => 'Search by Business Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'category_id')->dropDownList(
            GeneralModel::birdingoperatorcategory(),
            [
                'prompt' => 'Select Category',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'budget_segment')->dropDownList(
            GeneralModel::packageoption(),
            [
                'prompt' => 'Select Budget Segment',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::statusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>