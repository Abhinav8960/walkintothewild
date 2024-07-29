<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\GeneralModel;
use common\models\park\SafariPark;

/** @var yii\web\View $this */
/** @var common\models\sharesafari\ShareSafari $model */
/** @var yii\widgets\ActiveForm $form */
?>
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



<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper d-lg-block d-none">
        <div class="title_top pb-4">
            <h4>Select</h4>
        </div>
        <div class="title_filter ">
            <h6>Safari Park</h6>
            <div class="input_check ">
                <?= $form->field($searchModel, 'park_id')->dropDownlist($searchModel->parkoption, ['prompt' => 'Select Safari Park'])->label(false) ?>
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
            <h6>Budget Price Per Person</h6>
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
            <h6>Total Safaris</h6>
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
            <h6>Theme</h6>
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
            <h6>Organizer</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($searchModel, 'host_type')->checkboxList(
                    GeneralModel::hostoption(),
                    [
                        'required' => true,
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $id = $name . '_' . $index; // Generate a unique ID for each checkbox
                            return '<div class="checkbox-item d-flex gap-2 align-items-center">' .
                                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'checkbox_design', 'id' => $id]) .
                                Html::label($label, $id, ['class' => 'checkbox-label']) .
                                '</div>';
                        },
                    ]
                )->label(false); ?>
            </div>
<!-- 
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($searchModel, 'host_type')->checkboxList(
                    GeneralModel::hostoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div> -->

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
                            <?= $form->field($searchModel, 'park_id')->dropDownlist($searchModel->parkoption, ['prompt' => 'Select Park'])->label(false) ?>
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
          
    // $('form').on('change', function(){
    //     $("#side-search-form").attr("data-pjax", "true");    
    //     $(this).closest('form').submit();
       
    // });
    

    $('.remove_dropdown_filter').click(function(){
        data_attribute = $(this).attr('data-attribute');
        $("#sharesafarisearch-"+data_attribute+" option:selected").remove();
        // $("#side-search-form").attr("data-pjax", "true");    
        // $('#side-search-form').submit();
        $("#sharesafarisearch-"+data_attribute+"").trigger('change');

    });

    $('.remove_checkbox_filter').click(function(){
        data_id = $(this).attr('data-id');
        data_attribute = $(this).attr('data-attribute');
        $.each($('input[name="ShareSafariSearch['+data_attribute+'][]"]:checked'), function(){ 
            if($(this).val()===data_id){
                $(this).prop('checked', false);
                $("#sharesafarisearch-"+data_attribute+"").trigger('change');

                // $("#side-search-form").attr("data-pjax", "true");    
                // $('#side-search-form').submit();
            }
        });
    });
    
JS;
$this->registerJs($script);
?>


<?php
$script = <<< JS
    $('form').on('change', function(){
        // $("#Searchform").attr("data-pjax", "true");    
        // $(this).closest('form').submit();
        reloadpage();
    });


    $('#sharesafarisearch-custom_sort_by').on('change', function(){
        // $("#Searchform").attr("data-pjax", "true");    
        // $(this).closest('form').submit();
        reloadpage();
    });

    function reloadpage(){
        $.ajax({
            type: 'POST',
            url: '/sharedsafari/default/geturl',
            data:$("#side-search-form,#search-form, #custom_sort_by_form").serialize(),
            success:function(data){
                console.log(data);
                window.location.href = data;
            },
            dataType:'html'
        });
    }
JS;
$this->registerJs($script);
?>