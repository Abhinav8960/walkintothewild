<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;

?>

<?php if ($device == 'desktop') { ?>
    <div class="filter-wrapper custoM-inputs d-lg-block d-none mb-2">
        <div class="title_top pb-4">
            <h4>Select Operator</h4>
        </div>
        <div class="title_filter mb-3">
            <h6>Budget Segment</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'budget_segment')->checkboxList(
                    GeneralModel::packageoption(),
                    [
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="title_filter mb-3">
            <h6>Operator Credibility</h6>
            <div class="input_check d-flex gap-3 align-items-center">
                <?= $form->field($model, 'credibility')->checkboxList(
                    GeneralModel::operatorcredibility(),
                    [
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                )->label(false); ?>
            </div>
        </div>
        <!-- <div class="title_filter mb-2">
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

        </div> -->

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
        <div class="searchwrap mb-3 mt-5 pt-3">
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="title_filter">
                        <h6 class="mb-0">Sort By</h6>
                    </div>
                </div>
                <div class="col-7">
                    <div class="input_check pb-0">
                        <?php
                        $sort_option = [1 => 'Rating High', 2 => 'Rating Low', 3 => 'Name A-Z', 4 => 'Name Z-A'];
                        ?>
                        <div class="form-group field-safarioperatorsearch-custom_sort_by">
                            <select id="safarioperatorsearch-custom_sort_by" class="form-select mb-2 custom_sort_by_input" name="SafariOperatorSearch[custom_sort_by]">
                                <option style="display:none;" selected value="">Sort by : <?= isset($sort_option[$model->custom_sort_by]) ? $sort_option[$model->custom_sort_by] : 'Rating High' ?></option>
                                <option value="1" class="<?= $model->custom_sort_by == 1 ? 'selected' : '' ?>">Rating High</option>
                                <option value="2" class="<?= $model->custom_sort_by == 2 ? 'selected' : '' ?>">Rating Low</option>
                                <option value="3" class="<?= $model->custom_sort_by == 3 ? 'selected' : '' ?>">Name A-Z</option>
                                <option value="4" class="<?= $model->custom_sort_by == 4 ? 'selected' : '' ?>">Name Z-A</option>
                            </select>
                        </div>
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
        <!-- <div class="searchwrap mb-3">
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
        </div> -->
    </div>
<?php } ?>

<?php
$script = <<< JS
    $('form').on('change', function(){
        $('#safarioperatorsearch').submit();
    });
JS;
$this->registerJs($script);
?>