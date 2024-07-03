<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\sharesafari\ShareSafari $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'side-search-form'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<div class="filter-wrapper ">
    <div class="title_top pb-4">
        <h4>Select Filters</h4>
    </div>
    <div class="title_filter ">
        <h6>Park</h6>
        <div class="input_check ">
            <?= $form->field($searchModel, 'park_id')->dropDownlist(GeneralModel::safariparkoption())->label(false) ?>
        </div>
    </div>
    <div class="title_filter mb-3">
        <h6>Month</h6>
        <div class="input_check ">
            <?= $form->field($searchModel, 'month_filter')->dropDownlist(
                GeneralModel::monthoption()
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Estimate Price Per Person</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($searchModel, 'estimated_price_filter')->checkboxList(
                GeneralModel::estimatedpriceoption(),
                [
                    'required' => true,
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>No. Of Safaris</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($searchModel, 'no_of_safari')->checkboxList(
                GeneralModel::noofsafarioption(),
                [
                    'required' => true,
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Agenda</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($searchModel, 'share_safari_agenda_id')->checkboxList(
                GeneralModel::agendaoption(),
                [
                    'required' => true,
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Host</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($searchModel, 'host_type')->checkboxList(
                GeneralModel::hostoption(),
                [
                    'required' => true,
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Budget</h6>
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
</div>

<?php ActiveForm::end(); ?>

<?php

$script = <<< JS
          
    $('form').on('change', function(){
        $("#side-search-form").attr("data-pjax", "true");    
        $(this).closest('form').submit();
       
    }); 
JS;
$this->registerJs($script);
?>