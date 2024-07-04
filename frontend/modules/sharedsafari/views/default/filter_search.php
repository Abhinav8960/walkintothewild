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



<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper d-lg-block d-none">
        <div class="title_top pb-4">
            <h4>Select</h4>
        </div>
        <div class="title_filter ">
            <h6>Park</h6>
            <div class="input_check ">
                <?= $form->field($searchModel, 'park_id')->dropDownlist(GeneralModel::safariparkoption(), ['prompt' => 'Select Park'])->label(false) ?>
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
<?php } else { ?>

    <div class="filterPhone  custoM-inputs d-lg-none">
        <div class="top_filterwrap d-flex align-items-center justify-content-between">
            <div class="title_top ">
                <h4 class="mb-0">Select Filters</h4>
            </div>
            <div class="apply-btn">
                <button class="btn_apply">Apply</button>
            </div>
        </div>
        <div class="searchwrap mb-2" style="margin-top: 55px;">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6 class="mb-0">Sort By</h6>
                    </div>
                </div>
                <div class="col-7">                
                <?= $this->render('sort_by_month', ['searchModel' => $searchModel]) ?>
                </div>
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Park</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="title_filter">
              
                    <div class="input_check ">
                <?= $form->field($searchModel, 'park_id')->dropDownlist(GeneralModel::safariparkoption(), ['prompt' => 'Select Park'])->label(false) ?>
            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Month</h6>
                    </div>
                </div>
                <div class="col-7">
                <div class="input_check ">
                <?= $form->field($searchModel, 'month_id')->dropDownlist(
                    GeneralModel::monthoption(),
                    ['prompt' => 'Select Month']

                )->label(false); ?>
            </div>

                </div>
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Estimate Price Per Person</h6>
                    </div>
                </div>
                <div class="col-7">
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
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>No. Of Safaris</h6>
                    </div>
                </div>
                <div class="col-7">
            
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
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Agenda</h6>
                    </div>
                </div>
                <div class="col-7">
            
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
            </div>
        </div>
        <div class="searchwrap mb-2">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Host</h6>
                    </div>
                </div>
                <div class="col-7">
            
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
            </div>
        </div>
        <div class="searchwrap mb-2">
         <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                    <h6>Budget</h6>
                    </div>
                </div>
                <div class="col-7">
              
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
       </div>
   </div>
       
<?php } ?>

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