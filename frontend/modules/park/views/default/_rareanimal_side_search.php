<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */

?>


<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper d-lg-block d-none sticky-sidebar">
        <div class="title_top pb-4">
            <h4>Select </h4>
        </div>
        <div class="title_filter mb-4">
            <h6>Accommodation</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'accomodation_id')->checkboxList(
                    GeneralModel::accomodationoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="title_filter mb-4">
            <h6>Bonus Experience</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'bonus_experience_id')->checkboxList(
                    GeneralModel::bonusexperienceoption(),
                    [
                        'required' => true,
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- <div class="advertisment pt-5 d-lg-block d-none">
    <p class="text-center">ADVERTISMENT</p>
    <div class="advertisment_box-2">

    </div>
</div> -->

<?php if ($device == 'mobile') { ?>
    <div class="filterPhone d-lg-none">
        <div class="top_filterwrap d-flex align-items-center justify-content-between">
            <div class="title_top ">
                <h4 class="mb-0">Select Filters</h4>
            </div>
            <div class="apply-btn">
                <button class="btn_apply">Apply</button>
            </div>
        </div>
        <div class="searchwrap mb-3 mt-5 pt-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6 class="mb-0">Sort By</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="input_check pb-0">
                        <?= $form->field($model, 'custom_sort_by')->dropDownList(['is_most_demanding' => 'Most Demanding', 2 => 'Sort by: A to Z', 3 => 'Sort by: Z to A'])->label(false) ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Accommodation</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="title_filter">
                        <div class="input_check d-flex gap-3 align-items-center">
                            <?= $form->field($model, 'accomodation_id')->checkboxList(
                                GeneralModel::accomodationoption(),
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
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Bonus Experience</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="title_filter">
                        <div class="input_check d-flex gap-3 align-items-center">
                            <?= $form->field($model, 'bonus_experience_id')->checkboxList(
                                GeneralModel::bonusexperienceoption(),
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
    </div>
<?php } ?>

<?php
$script = <<< JS
    $('form').on('change', function(){
        $("#sideSearchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    });
    $('#safariparksearch-custom_sort_by').on('change', function(){
        $("#sideSearchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    });


JS;
$this->registerJs($script);
?>