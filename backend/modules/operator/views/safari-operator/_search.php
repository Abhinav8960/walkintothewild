<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorPark;
use common\models\registration\SafariOperatorRequestPark;

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
        <?= $form->field($model, 'business_name')->textInput(['placeholder' => 'Search by Business Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'register_comapany_name')->textInput(['placeholder' => 'Search by Business Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'category_id')->dropDownList(
            GeneralModel::operatorcategory(),
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
        <?= $form->field($model, 'park_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(SafariOperatorPark::find()->joinwith(['park'])->where(['safari_operator_park.status' => 1])->orderby(['safari_park.title' => SORT_ASC])->all(), 'park_id', 'park.title'),
            [
                'prompt' => 'Select Park',
            ]
        ) ?>
    </div>
    <!-- <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div> -->
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