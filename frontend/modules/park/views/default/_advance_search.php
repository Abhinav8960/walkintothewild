<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\helpers\ArrayHelper;

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

$parkoption = GeneralModel::safariparklist('slug');
$vehicleoption = GeneralModel::vehicleoption();
?>

<div class="row gx-0 justify-content-center d-md-flex d-none desktop_search" id="desktop_search">
    <div class="close_button" id="desktop_close_button"><i class="fa-solid fa-xmark"></i></div>
    <div class=" col-xl-10 col-xxl-9 planSearch_box">
        <div class="select_searcjBox d-sm-flex flex-wrap align-items-center gap-1 w-100 justify-content-center">
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($parkoption[$model->safari_park_id]) ? $parkoption[$model->safari_park_id] : 'Select Safari Park' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php foreach ($parkoption as $value => $label) : ?>
                            <div class="dropdown-item park_dropdown_item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    //  $form->field($model, 'safari_park_id')->dropDownList(
                    //     $parkoption,
                    //     [
                    //         'class' => "form-select form-select-lg hidden-select",
                    //         'aria-label' => "Large select example",
                    //         'prompt' => ''

                    //     ]
                    // )->label(false);
                    ?>
                    <div class="placeholder_select ">
                        <p>Select Park</p>
                    </div>
                    <div class="OrBox">
                        <p>OR</p>
                    </div>
                    <!-- <div class="icons_select">
                        <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                    </div> -->
                </div>

            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($locationoption[$model->master_location_id]) ? $locationoption[$model->master_location_id] : 'Any / All' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php if ($model->master_location_id) { ?>
                            <div class="dropdown-item" data-value="">Any / All</div>
                        <?php } ?>
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
                        <?= isset($animalfilteroption[$model->master_animal_id]) ? $animalfilteroption[$model->master_animal_id] : 'Select Animal' ?>
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
                        <?= isset($vehicleoption[$model->master_vehicle_id]) ? $vehicleoption[$model->master_vehicle_id] : 'Select Safari Mode' ?>
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

            </div>

        </div>
    </div>
    <div class=" col-xl-1">
        <div class="search px_serach">
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
                    <i class="fa-solid fa-magnifying-glass pe-4"></i>
                </div>
            </div>
            <div class="select_boxes">
                <h6 class="fs-5"> <?= isset($parkoption[$model->safari_park_id]) ? $parkoption[$model->safari_park_id] : 'Select Safari Park' ?></h6>
            </div>
            <i class="fa-solid fa-chevron-right px-2"></i>
            <div class="select_boxes">
                <h6 class="fs-5"><?= isset($locationoption[$model->master_location_id]) ? $locationoption[$model->master_location_id] : 'Select Region' ?></h6>
            </div>
            <i class="fa-solid fa-chevron-right px-2"></i>
            <div class="select_boxes">
                <h6 class="fs-5"> <?= isset($animalfilteroption[$model->master_animal_id]) ? $animalfilteroption[$model->master_animal_id] : 'Select Animal' ?></h6>
            </div>
            <i class="fa-solid fa-chevron-right px-2"></i>
            <div class="select_boxes">
                <h6 class="fs-5"> <?= isset($vehicleoption[$model->master_vehicle_id]) ? $vehicleoption[$model->master_vehicle_id] : 'Select Safari Mode' ?></h6>
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

document.getElementById('desktop_close_button').addEventListener('click', function() {
    document.getElementById('desktop_search').style.setProperty('display', 'none', 'important');
    document.getElementById('mobile_search').style.setProperty('display', 'block', 'important');
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

$('.park_dropdown_item').click(function(){
    var value = $(this).data('value');
    setTimeout(function () {
        window.location.href = `/park/`+value+``;
    }, 200);
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