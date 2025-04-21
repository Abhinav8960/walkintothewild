<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>


<?php $form = ActiveForm::begin([
    'id' => 'inclusion-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>


<div class="card ">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 Modal_form">
                <div class="form-group">
                    <?php foreach (GeneralModel::packageincludeoption() as $optionValue => $optionLabel) : ?>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="control-label"><?= $optionLabel ?></label>
                            </div>
                            <div class="col-sm-9">
                                <?= $form->field($model, 'share_safari_included[' . $optionValue . ']')->radioList(
                                    [
                                        '1' => 'Included',
                                        '2' => 'Not Included',
                                        // '3' => 'Optional',
                                    ],
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) {
                                            return '<div class="form-check form-check-inline">' .
                                                '<input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>' .
                                                '<label class="form-check-label">' . $label . '</label>' .
                                                '</div>';
                                        },
                                        'itemOptions' => ['class' => 'form-check-input'], // Additional item options if needed
                                    ]
                                )->label(false) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Meals :
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'breakfast_included')->checkbox(['value' => "1", 'id' => "breakfast_included"])->label('Breakfast') ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'lunch_included')->checkbox(['value' => "1", 'id' => "lunch_included"])->label('Lunch') ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'dinner_included')->checkbox(['value' => "1", 'id' => "dinner_included"])->label('Dinner') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'meal_not_included')->checkbox(['value' => "1", 'id' => "meal_not_included"])->label('Meal Not Included') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'share_safari_inclusion')->textarea(['rows' => '2', 'placeholder' => 'List everything included'])->label('Share Safari Inclusion', ['class' => 'Modal_label']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'share_safari_exclusion')->textarea(['rows' => '2', 'placeholder' => 'List what is not included'])->label('Share Safari Exclusion', ['class' => 'Modal_label']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="creat-safri d-flex justify-content-end ">
                    <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
bulleteditor('createdepartureform-share_safari_inclusion');
bulleteditor('createdepartureform-share_safari_exclusion');
JS;
$this->registerJs($script);
?>
<style>
    .form-check-input[type="radio"] {
        width: 20px;
        height: 20px;
        border-radius: 50% !important;
        /* Additional styles as needed */
    }

    .form-check-label {
        /* Additional label styles if necessary */
        margin-left: 5px;
        /* Example: Adds a margin to the left of the label */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the checkboxes
        var breakfastCheckbox = document.getElementById('breakfast_included');
        var lunchCheckbox = document.getElementById('lunch_included');
        var dinnerCheckbox = document.getElementById('dinner_included');
        var mealNotIncludedCheckbox = document.getElementById('meal_not_included');

        // Function to handle the state of meal_not_included checkbox
        function updateMealNotIncludedState() {
            if (breakfastCheckbox.checked || lunchCheckbox.checked || dinnerCheckbox.checked) {
                mealNotIncludedCheckbox.checked = false;
                mealNotIncludedCheckbox.disabled = true;
            } else {
                mealNotIncludedCheckbox.disabled = false;
            }
        }

        // Function to handle the state when meal_not_included is clicked
        function handleMealNotIncludedClick() {
            if (mealNotIncludedCheckbox.checked) {
                // Uncheck and disable other checkboxes
                breakfastCheckbox.checked = false;
                lunchCheckbox.checked = false;
                dinnerCheckbox.checked = false;
                breakfastCheckbox.disabled = true;
                lunchCheckbox.disabled = true;
                dinnerCheckbox.disabled = true;
            } else {
                // Re-enable other checkboxes if meal_not_included is unchecked
                breakfastCheckbox.disabled = false;
                lunchCheckbox.disabled = false;
                dinnerCheckbox.disabled = false;
                updateMealNotIncludedState();
            }
        }

        // Attach change event listeners to the checkboxes
        breakfastCheckbox.addEventListener('change', updateMealNotIncludedState);
        lunchCheckbox.addEventListener('change', updateMealNotIncludedState);
        dinnerCheckbox.addEventListener('change', updateMealNotIncludedState);
        mealNotIncludedCheckbox.addEventListener('change', handleMealNotIncludedClick);

        // Initial state update
        updateMealNotIncludedState();
    });
</script>