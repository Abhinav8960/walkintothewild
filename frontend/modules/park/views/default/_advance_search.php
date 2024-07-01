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
$safarisessionoption = GeneralModel::safarisessionoption();
$animalfilteroption = GeneralModel::animalfilteroption();
$vehicleoption = GeneralModel::vehicleoption();
?>
<div class="row gx-0 justify-content-center d-md-flex d-none desktop_search" id="desktop_search">
    <div class="col-lg-10 col-xl-10">
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

                    <div class="placeholder_select">
                        <p>Location</p>
                    </div>
                    <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                    </div>
                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($safarisessionoption[$model->session_id]) ? $safarisessionoption[$model->session_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <div class="dropdown-item" data-value="">Any / All</div>
                        <?php foreach ($safarisessionoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'session_id')->dropDownList(
                        $safarisessionoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => ''

                        ]
                    )->label(false) ?>
                    <div class="placeholder_select">
                        <p>Safari seasion</p>
                    </div>
                    <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                    </div>
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
                    <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                    </div>
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
                    <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-xl-1">
        <div class="search">
            <div class="serch_btn">
                <?= Html::Button('Search', ['id' => 'search_submit_btn']) ?>
            </div>
        </div>
    </div>

</div>
<div class="row gx-0 justify-content-center d-md-none  d-block mobile_search" id="mobile_search">
    <div class="col-lg-10 col-xl-12">
        <div class="mobile_searchBox d-flex justify-content-between align-items-center">
            <div class="select_boxes">
                <div class="icomns">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

                <div class="select_boxes">
                    <h6 class="fs-5" >Morning</h6>
                </div>


            <i class="fa-solid fa-chevron-right"></i>
            <div class="select_boxes">
                <h6 class="fs-5">Morning</h6>
            </div>
            <i class="fa-solid fa-chevron-right"></i>
            <div class="select_boxes">
                <h6 class="fs-5">Tiger</h6>
            </div>
            <i class="fa-solid fa-chevron-right"></i>
            <div class="select_boxes">
                <h6 class="fs-5">Gypsy / jeep</h6>
            </div>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
document.getElementById('mobile_search').addEventListener('click', function() {
    document.getElementById('desktop_search').style.setProperty('display', 'block', 'important');
        document.getElementById('mobile_search').style.setProperty('display', 'none', 'important');
});
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