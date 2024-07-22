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
    'action' => ['parklist'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]);
$locationoption = GeneralModel::getAllLocation();
$animalfilteroption = GeneralModel::animalfilteroption();
$parkoption = GeneralModel::safariparkoption();
$vehicleoption = GeneralModel::vehicleoption();
?>
<div class="row gx-0 justify-content-center " >
    <div class=" col-xl-9 planSearch_box">
        <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-1 w-100">
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($locationoption[$model->master_location_id]) ? $locationoption[$model->master_location_id] : 'All India' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">All India</div>
                        <?php foreach ($locationoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_location_id')->dropDownList(
                        $locationoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''
                        ]
                    )->label(false) ?>

                    <div class="placeholder_select loc">
                        <p>Location</p>
                    </div>
                    <!-- <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/plans.png" alt="">
                    </div> -->
                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($animalfilteroption[$model->master_animal_id]) ? $animalfilteroption[$model->master_animal_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($animalfilteroption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_animal_id')->dropDownList(
                        $animalfilteroption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''
                        ]
                    )->label(false) ?>

                    <div class="placeholder_select">
                        <p>Animal</p>
                    </div>
                    <!-- <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                    </div> -->
                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($vehicleoption[$model->master_vehicle_id]) ? $vehicleoption[$model->master_vehicle_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($vehicleoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_vehicle_id')->dropDownList(
                        $vehicleoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''
                        ]
                    )->label(false) ?>
                    <div class="placeholder_select">
                        <p>Vehicle</p>
                    </div>
                    <!-- <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                    </div> -->
                </div>
                <div class="OrBox">
                    <p>OR</p>
                </div>
            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($parkoption[$model->safari_park_id]) ? $parkoption[$model->safari_park_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($parkoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'safari_park_id')->dropDownList(
                        $parkoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''

                        ]
                    )->label(false) ?>
                    <div class="placeholder_select">
                        <p>Select Park</p>
                    </div>
                    <!-- <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                    </div> -->
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
        url: '/park/default/geturl',
        data:$("#Searchform,#sideSearchform,#custom_sort_by_form").serialize(),
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