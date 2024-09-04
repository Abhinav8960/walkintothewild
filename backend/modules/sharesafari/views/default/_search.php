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

        <?php echo $form->field($model, 'report_days')->dropDownList($model->report_days_option, ['prompt' => 'Select Duration'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'safari_plan')->textInput(['placeholder' => 'Search by Safari Plan'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'type')->dropDownList(GeneralModel::sharedsafaritype(), ['prompt' => 'Select Type'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoption(), ['prompt' => 'Select Status'])->label(false) ?>
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