<?php

use common\models\GeneralModel;
use kartik\field\FieldRange;
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
    <div class="col-12 mb-3">
        <div class="filterBar">
            <div class="filters">
                <div class="filterItem">
                    <label>Package Name:</label>
                    <?= $form->field($model, 'package_name')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
                </div>
                <div class="filterItem position-relative">
                    <label>Stay Category:</label>
                    <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'All Stay Category', 'class' => 'search-border'])->label(false) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
                <div class="filterItem">
                    <div class="d-flex align-items-center gap-2">
                        <label>Price:</label>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cost_per_person_min')->textInput([
                                'placeholder' => 'Enter Minimum Price'
                            ])->label(false) ?>
                        </div>
                        <label>to</label>
                        <div class="col-md-4">
                            <?= $form->field($model, 'cost_per_person_max')->textInput([
                                'placeholder' => 'Enter Maximum Price'
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <!-- <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => 'Select Status'])->label(false) ?> -->
                </div>

            </div>
        </div>
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