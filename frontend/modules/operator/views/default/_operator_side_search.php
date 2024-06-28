<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper custoM-inputs d-lg-block d-none">
        <div class="title_top pb-4">
            <h4>Select Filters</h4>
        </div>
        <div class="title_filter mb-2">
            <h6>Budget</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'budget_segment')->checkboxList(
                    GeneralModel::packageoption(),
                    [
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                ); ?>
            </div>
        </div>
        <div class="title_filter mb-2">
            <h6>Operator Credibility</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'credibility')->checkboxList(
                    GeneralModel::operatorcredibility(),
                    [
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                ); ?>
            </div>
        </div>
        <div class="title_filter mb-2">
            <h6>Operator Rating</h6>
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
        <?= $form->field($model, 'custom_sort_by')->hiddenInput(); ?>
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
    $('form input[type=checkbox]').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $('#Searchform').submit();
    });
JS;
$this->registerJs($script);
?>