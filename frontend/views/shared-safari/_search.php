<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\GeneralModel;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['sharedsafari'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]);
$parkoption = GeneralModel::safariparkoption();
$monthoption = GeneralModel::monthoption();
$estimatedpriceoption = GeneralModel::estimatedpriceoption();
?>
<div class="row gx-0 justify-content-center ">
    <div class=" col-xl-10">
        <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-1 w-100">
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($parkoption[$model->park_id]) ? $parkoption[$model->park_id] : 'All Park' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">All Park</div>
                        <?php foreach ($parkoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'park_id')->dropDownList(
                        $parkoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''
                        ]
                    )->label(false) ?>

                    <div class="placeholder_select">
                        <p>Park</p>
                    </div>

                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($monthoption[$model->month_id]) ? $monthoption[$model->month_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($monthoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'month_id')->dropDownList(
                        $monthoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''

                        ]
                    )->label(false) ?>
                    <div class="placeholder_select">
                        <p>Month</p>
                    </div>
                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($estimatedpriceoption[$model->estimated_price_filter]) ? $estimatedpriceoption[$model->estimated_price_filter] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($estimatedpriceoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'estimated_price_filter')->dropDownList(
                        $estimatedpriceoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''
                        ]
                    )->label(false) ?>

                    <div class="placeholder_select">
                        <p>Budget</p>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class=" col-xl-1">
        <div class="search">
            <div class="serch_btn">
                <?= Html::Button('Search', ['id' => 'search_submit_btn']) ?>
            </div>
        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS

$(document).ready(function(){
    function toggleDropdown(container) {
        var \$dropdown = container.find('.dropdown');
        
        // Close all dropdowns
        $('.dropdown').not(\$dropdown).hide();
        $('.dropdown-toggle').not(container.find('.dropdown-toggle')).removeClass('open');
        
        // Toggle the current dropdown
        container.find('.dropdown-toggle').toggleClass('open');
        \$dropdown.toggle();
    }

    // Bind click events to .dropdown-toggle, .placeholder_select, and .icons_select
    $(document).on('click', '.dropdown-toggle, .placeholder_select, .icons_select', function(e) {
        e.stopPropagation();
        var \$container = $(this).closest('.dropdown-container');
        toggleDropdown(\$container);
    });

    // Bind click event to .dropdown-item
    $(document).on('click', '.dropdown-item', function() {
        var value = $(this).data('value');
        var label = $(this).text();
        var \$container = $(this).closest('.dropdown-container');
        
        // Set the text of the dropdown toggle and update the hidden select
        \$container.find('.dropdown-toggle').text(label);
        \$container.find('.hidden-select').val(value);
        
        // Hide the dropdown
        \$container.find('.dropdown').hide();
        \$container.find('.dropdown-toggle').removeClass('open');
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown-container').length) {
            $('.dropdown').hide();
            $('.dropdown-toggle').removeClass('open');
        }
    });
});

$('#search_submit_btn').click(function(){
    $.ajax({
        type: 'POST',
        url: '/shared-safari/geturl',
        data:$("#Searchform").serialize(),
        success:function(data){
            // console.log(data);
            window.location.href = data;
        },
        dataType:'html'
    });
});

JS;
$this->registerJs($script);
?>