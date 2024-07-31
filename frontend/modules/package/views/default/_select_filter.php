<?php

use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4 pt-3">
    <div class="filter-wrapper pb-2">
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
            <div class="multi-range">
                <input type="range" name="PackageSearch[no_of_night_min]" min="1" max="10" value="<?= $searchModel->no_of_night_min ?>" id="packagesearch-no_of_night_min" class="dual_range range_values d-flex align-items-center justify-content-between">
                <input type="range" name="PackageSearch[no_of_night_max]" min="1" max="10" value="<?= $searchModel->no_of_night_max ?>" id="packagesearch-no_of_night_max" class="dual_range range_values d-flex align-items-center justify-content-between">
            </div>
            <div class="range-label">
                <span class="value"><?= $searchModel->no_of_night_min ?> Night</span>
                <span class="float-end"><?= $searchModel->no_of_night_max >= 10 ? '10+' : $searchModel->no_of_night_max ?> Nights</span>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6 class="">Total Safaris</h6>
            <div class="multi-range">
                <input type="range" name="PackageSearch[no_of_safari_min]" min="1" max="10" value="<?= $searchModel->no_of_safari_min ?>" id="packagesearch-no_of_safari_min" class="dual_range range_values d-flex align-items-center justify-content-between">
                <input type="range" name="PackageSearch[no_of_safari_max]" min="1" max="10" value="<?= $searchModel->no_of_safari_max ?>" id="packagesearch-no_of_safari_max" class="dual_range range_values d-flex align-items-center justify-content-between">
            </div>
            <div class="range-label">
                <span class="value"><?= $searchModel->no_of_safari_min ?> </span>
                <span class="float-end"><?= $searchModel->no_of_safari_max >= 10 ? '10+' : $searchModel->no_of_safari_max ?> </span>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6 class="">Cost (Per Person)</h6>
            <div class="multi-range">
                <input type="range" name="PackageSearch[estimated_price_filter_min]" min="1000" max="50000" value="<?= $searchModel->estimated_price_filter_min ?>" id="packagesearch-estimated_price_filter_min" class="dual_range range_values d-flex align-items-center justify-content-between">
                <input type="range" name="PackageSearch[estimated_price_filter_max]" min="1000" max="50000" value="<?= $searchModel->estimated_price_filter_max ?>" id="packagesearch-estimated_price_filter_max" class="dual_range range_values d-flex align-items-center justify-content-between">
            </div>
            <div class="range-label">
                <span class="value"><?= $searchModel->estimated_price_filter_min ?> </span>
                <span class="float-end"><?= $searchModel->estimated_price_filter_max >= 50000 ? '50000+' : $searchModel->estimated_price_filter_max ?> </span>
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
        <div class="title_filter ">
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
          
    // $('form').on('change', function(){
    //     $("#side-search-form").attr("data-pjax", "true");    
    //     $(this).closest('form').submit();
       
    // }); 



    $('.remove_dropdown_filter').click(function(){
        data_attribute = $(this).attr('data-attribute');
        $("#packagesearch-"+data_attribute+" option:selected").remove();
        $("#packagesearch-"+data_attribute+"").trigger('change');
        // $("#side-search-form").attr("data-pjax", "true");    
        // $('#side-search-form').submit();
    });

    $('.remove_checkbox_filter').click(function(){
        data_id = $(this).attr('data-id');
        data_attribute = $(this).attr('data-attribute');
        $.each($('input[name="PackageSearch['+data_attribute+'][]"]:checked'), function(){ 
            if($(this).val()===data_id){
                $(this).prop('checked', false);
                // $("#side-search-form").attr("data-pjax", "true");    
                // $('#side-search-form').submit();
                $("#packagesearch-"+data_attribute+"").trigger('change');
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
            url: '/package/default/geturl',
            data:$("#side-search-form, #custom_sort_by_form").serialize(),
            success:function(data){
                console.log(data);
                window.location.href = data;
            },
            dataType:'html'
        });
    }


    initializeDualrange('packagesearch-no_of_night_min','packagesearch-no_of_night_max');
    initializeDualrange('packagesearch-no_of_safari_min','packagesearch-no_of_safari_max');
    initializeDualrange('packagesearch-estimated_price_filter_min','packagesearch-estimated_price_filter_max');

JS;
$this->registerJs($script);
?>