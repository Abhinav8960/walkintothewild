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
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6 class="mb-0">Sort By</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="input_check pb-0">
                        <form id="custom_sort_by_form">
                            <select class="form-select mb-2" aria-label="Default select example" id="custom_sort_by">
                                <option value="name_az" <?= $model->custom_sort_by == 'name_az' || $model->custom_sort_by == '' ? 'selected' : '' ?>>Name A-Z</option>
                                <option value="name_za" <?= $model->custom_sort_by == 'name_za' ? 'selected' : '' ?>>Name Z-A</option>
                                <option value="rating_high" <?= $model->custom_sort_by == 'rating_high' ? 'selected' : '' ?>>Rating High</option>
                                <option value="rating_low" <?= $model->custom_sort_by == 'rating_low' ? 'selected' : '' ?>>Rating Low</option>
                            </select>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Budget</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="title_filter">
                        <div class="input_check d-flex gap-3 align-items-center">
                            <?= $form->field($model, 'budget_segment')->checkboxList(
                                GeneralModel::packageoption(),
                                [
                                    'itemOptions' => ['class' => 'checkbox_design'],
                                ]
                            ); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Operator Credibility</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="input_check d-flex gap-3 align-items-center">
                        <?= $form->field($model, 'credibility')->checkboxList(
                            GeneralModel::operatorcredibility(),
                            [
                                'itemOptions' => ['class' => 'checkbox_design'],
                            ]
                        ); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="searchwrap mb-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6>Operator Rating</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="title_filter">
                        <?php
                        $ratings = GeneralModel::rating();
                        $selectedRatings = $model->google_rating; // Assuming $model is your model instance
                        if ($ratings) {
                            foreach ($ratings as $ratingValue => $ratingLabel) {
                                // Generate a unique ID for each checkbox
                                $checkbox_id = 'rating_' . $ratingValue;
                                // Check if the current rating value is selected
                                if ($model->google_rating) {
                                    $isChecked = in_array($ratingValue, $selectedRatings);
                                } else {
                                    $isChecked = false;
                                }
                        ?>
                                <div class="input_check d-flex gap-3 align-items-center">
                                    <input type="checkbox" name="SafariOperatorSearch[google_rating][]" id="<?= $checkbox_id ?>" class="checkbox_design" value="<?= $ratingValue ?>" <?= $isChecked ? 'checked' : '' ?>>
                                    <label for="<?= $checkbox_id ?>" class="star_label">
                                        <div class="stars d-flex gap-2">
                                            <?php for ($i = 1; $i <= $ratingValue; $i++) { ?>
                                                <i class="fa-solid fa-star"></i>
                                            <?php } ?>
                                        </div>
                                    </label>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <?= $form->field($model, 'custom_sort_by')->hiddenInput(); ?>
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