<?php

use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4">
    <div class="filter-wrapper ">
        <div class="title_top pb-4">
            <h4>Select Filters</h4>
        </div>
        <?php $form = ActiveForm::begin([
            'options' => [
                'data-pjax' => true,
                'id' => 'side-search-form'
            ],
            'action' => ['index'],
            'method' => 'get',
            'fieldConfig' => [
                'template' => '{input}{error}',
            ],
        ]); ?>
        <div class="title_filter mb-3">
            <h6>Safari Park</h6>
            <div class="input_check ">
                <?= $form->field($searchModel, 'park_id')->dropDownlist(ArrayHelper::map(SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'is_shared_safari' => 1])->all(), 'id', 'title'), ['prompt' => 'Select Safari Park'])->label(false) ?>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6>Month</h6>
            <div class="input_check ">
                <?= $form->field($searchModel, 'month_id')->dropDownlist(
                    GeneralModel::monthoption(),
                    ['prompt' => 'Select Month']

                )->label(false); ?>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6>Stay Category</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($searchModel, 'stay_category_id')->checkboxList(
                    GeneralModel::budgetoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6 class="">Tour Duration</h6>
            <div class="rangetours range">
                <?= $form->field($searchModel, 'no_of_night')->textInput([
                    'maxlength' => true,
                    'type' => 'range',
                    'min' => 0,
                    'max' => 20,
                    'value' => isset($searchModel->no_of_night) ? $searchModel->no_of_night : 0,
                    'class' => 'range_values d-flex align-items-center justify-content-between',
                ]) ?>
            </div>
            <div class="range-label">
                <span class="value">0 Night</span>
                <span class="float-end">10+ Nights</span>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6 class="">Total Safaris</h6>
            <div class="rangetours range">
                <?= $form->field($searchModel, 'no_of_safari')->textInput([
                    'maxlength' => true,
                    'type' => 'range',
                    'min' => 0,
                    'max' => 20,
                    'value' => isset($searchModel->no_of_safari) ? $searchModel->no_of_safari : 0,
                    'class' => 'range_values d-flex align-items-center justify-content-between',
                ]) ?>
            </div>
            <div class="range-label">
                <span class="value">0 </span>
                <span class="float-end">10+ </span>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6 class="">Cost (Per Person)</h6>
            <div class="rangetours range">
                <?= $form->field($searchModel, 'estimated_price_filter')->textInput([
                    'maxlength' => true,
                    'type' => 'range',
                    'min' => 1000,
                    'max' => 50000,
                    'value' => isset($searchModel->estimated_price_filter) ? $searchModel->estimated_price_filter : 0,
                    'class' => 'range_values d-flex align-items-center justify-content-between',
                ]) ?>
            </div>
            <div class="range-label">
                <span class="value">1000 </span>
                <span class="float-end">50000+ </span>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6>Features</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($searchModel, 'package_feature')->checkboxList(
                    GeneralModel::packagefeatureoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6>Included</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($searchModel, 'package_include')->checkboxList(
                    GeneralModel::packageincludeoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>


<?php

$script = <<< JS
          
    $('form').on('change', function(){
        $("#side-search-form").attr("data-pjax", "true");    
        $(this).closest('form').submit();
       
    }); 
JS;
$this->registerJs($script);
?>