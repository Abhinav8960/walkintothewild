<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['/park/' . $safari_model->slug . ''],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="filter-wrapper custoM-inputs">
    <div class="title_top pb-4">
        <h4>Select Filters</h4>
    </div>
    <div class="title_filter mb-4">
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
    <div class="title_filter mb-4">
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
    <div class="title_filter mb-4">
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

</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $('form input[type=checkbox]').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    });
JS;
$this->registerJs($script);
?>