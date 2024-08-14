<?php

use common\interfaces\StatusInterface;
use common\models\GeneralModel;
use common\models\master\bonusexperience\MasterBonusExperience;
use common\models\meta\MetaAccommodation;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'sideSearchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper d-lg-block d-none sticky-sidebar">
        <div class="title_top pb-4">
            <h4>Select Filters</h4>
        </div>
        <div class="title_filter mb-4">
            <h6>Accommodation</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'accomodation_id')->checkboxList(
                    ArrayHelper::map(MetaAccommodation::find()->where(['status' => StatusInterface::STATUS_ACTIVE])->andWhere(['not in', 'id', 2])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
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
                    ArrayHelper::map(MasterBonusExperience::find()->where(['status' => StatusInterface::STATUS_ACTIVE])->andWhere(['not in', 'id', 4])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
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
        <div class="searchwrap mb-3 mt-5 ">
            <div class="row align-items-center mt-2">
                <div class="col-5">
                    <div class="title_filter">
                        <h6 class="mb-0">Sort By</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="input_check pb-0">

                        <?php
                        $sort_option = [1 => 'Most Demanding', 2 => 'A to Z', 3 => 'Z to A'];
                        ?>

                        <div class="form-group field-safariparksearch-custom_sort_by">
                            <select id="safariparksearch-custom_sort_by" class="form-select custom_sort_by_input" name="SafariParkSearch[custom_sort_by]">
                                <option value="" style="display:none;" <?= $model->custom_sort_by == '' ? 'selected' : '' ?>>Sort by : <?= isset($sort_option[$model->custom_sort_by]) ? $sort_option[$model->custom_sort_by] : 'Most Demanding' ?></option>
                                <option value="1" class="<?= $model->custom_sort_by == '1' ? 'selected' : '' ?>">Most Demanding</option>
                                <option value="2" class="<?= $model->custom_sort_by == '2' ? 'selected' : '' ?>">A to Z</option>
                                <option value="3" class="<?= $model->custom_sort_by == '3' ? 'selected' : '' ?>">Z to A</option>
                            </select>
                            <div class="help-block"></div>
                        </div>
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

<?php if ($model->master_rare_animal_id <> '') { ?>
    <?= $form->field($model, 'master_rare_animal_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'master_location_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'session_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'master_animal_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'master_vehicle_id')->hiddenInput()->label(false) ?>
<?php } ?>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $('form input[type=checkbox]').on('change', function(){
        // $("#Searchform").attr("data-pjax", "true");    
        // $(this).closest('form').submit();
        $.ajax({
            type: 'POST',
            url: '/park/default/geturl',
            data:$("#Searchform,#sideSearchform, #custom_sort_by_form").serialize(),
            success:function(data){
                console.log(data);
                window.location.href = data;
            },
            dataType:'html'
        });
    });


    $('#safariparksearch-custom_sort_by').on('change', function(){
        // $("#Searchform").attr("data-pjax", "true");    
        // $(this).closest('form').submit();
        $.ajax({
            type: 'POST',
            url: '/park/default/geturl',
            data:$("#Searchform,#sideSearchform, #custom_sort_by_form").serialize(),
            success:function(data){
                console.log(data);
                window.location.href = data;
            },
            dataType:'html'
        });
    });
JS;
$this->registerJs($script);
?>