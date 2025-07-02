<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use kartik\daterange\DateRangePicker;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-xxl-3 col-xl-6 col-sm-6 col-12 mb-xxl-0 mb-3">
        <div class="filter-one d-flex gap-2">
            <span>Animal:</span>
            <details>
                <summary>Tiger</summary>
                <div class="dropdown">
                    <p>Giraffe</p>
                    <p>Panda</p>
                    <p>Kangaroo</p>
                    <p>Tiger</p>
                </div>
            </details>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-sm-6 col-12 mb-xxl-0 mb-3">

        <div class="filter-one d-flex gap-2">
            <span>Session:</span>
            <details>
                <summary>Morning</summary>
                <div class="dropdown">
                    <p>Morning</p>
                    <p>Evening</p>
                    <p>Night</p>
                </div>
            </details>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-sm-6 col-12 mb-xxl-0 mb-3">
        <div class="filter-one d-flex gap-2">
            <span>Park:</span>
            <details>
                <summary>Park Name</summary>
                <div class="dropdown parkName">
                    <p>All</p>
                    <p>Pench Tiger Reserve</p>
                    <p>Kanha National Park</p>
                    <p>Sundarbans National Park</p>
                    <p>Bandhavgarh National Park</p>
                    <p>Periyar Wildlife Sanctuary</p>
                    <p>Ranthambore National Park</p>
                </div>
            </details>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-6 col-sm-6 col-12 mb-xxl-0 mb-3">
        <div class="filter-one d-flex gap-2">
            <span>Status:</span>
            <details>
                <summary>Active</summary>
                <div class="dropdown">
                    <p>Active</p>
                    <p>Inactive</p>
                </div>
            </details>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
    $('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>

<style>
    .filterItem input {
        border: none;
        outline: none;
        background: transparent;
        font-weight: 600;
        color: #44444F !important;
        cursor: pointer;
        padding: 4px 50px 4px 8px;
        font-size: 16px;
    }
</style>