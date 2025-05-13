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
        <?= $form->field($model, 'package_name')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'business_name')->textInput(['placeholder' => 'Search by Partner Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'Select Stay Category'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => 'Select Status'])->label(false) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
    $('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>