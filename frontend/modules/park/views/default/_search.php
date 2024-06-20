<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
$monthoption = GeneralModel::monthoption();
$animalfilteroption = GeneralModel::animalfilteroption();
$vehicleoption = GeneralModel::vehicleoption();
?>
<div class="row gx-0 justify-content-center">
    <div class="col-lg-10 col-xl-10">
        <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-1 w-100">
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">

                        <?= isset($locationoption[$model->master_location_id]) ? $locationoption[$model->master_location_id] : 'North india, South...' ?>

                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php foreach ($locationoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_location_id')->dropDownList(
                        $locationoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example",
                            'prompt' => "Large select example",
                        ]
                    )->label(false) ?>
                </div>
                <div class="placeholder_select">
                    <p>Location</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($monthoption[$model->month_id]) ? $monthoption[$model->month_id] : 'May,june,July..' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php foreach ($monthoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'month_id')->dropDownList(
                        $monthoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example"
                        ]
                    )->label(false) ?>
                </div>
                <div class="placeholder_select">
                    <p>Month</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($animalfilteroption[$model->master_animal_id]) ? $animalfilteroption[$model->master_animal_id] : 'Tiger Elephent..' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php foreach ($animalfilteroption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_animal_id')->dropDownList(
                        $animalfilteroption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example"
                        ]
                    )->label(false) ?>

                </div>

                <div class="placeholder_select">
                    <p>Animal</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <div class="dropdown-container">
                    <div class="dropdown-toggle">
                        <?= isset($vehicleoption[$model->master_vehicle_id]) ? $vehicleoption[$model->master_vehicle_id] : 'Cantar/Bus..' ?>
                    </div>
                    <div class="dropdown custom_dropdown">
                        <?php foreach ($vehicleoption as $value => $label) : ?>
                            <div class="dropdown-item" data-value="<?= $value ?>"><?= $label ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'master_vehicle_id')->dropDownList(
                        $vehicleoption,
                        [
                            'class' => "form-select form-select-lg hidden-select",
                            'aria-label' => "Large select example"
                        ]
                    )->label(false) ?>
                </div>
                <div class="placeholder_select">
                    <p>Vehicel</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                </div>
            </div>



        </div>
    </div>
    <div class="col-lg-2 col-xl-1">
        <div class="search">
            <div class="serch_btn">
                <?= Html::submitButton('Search') ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
$(document).ready(function(){
    $('.dropdown-toggle').on('click', function(e) {
        e.stopPropagation();
        var \$dropdown = $(this).siblings('.dropdown');
        
        // Close all dropdowns
        $('.dropdown').not(\$dropdown).hide();
        $('.dropdown-toggle').not($(this)).removeClass('open');
        
        // Toggle the current dropdown
        $(this).toggleClass('open');
        \$dropdown.toggle();
    });

    $('.dropdown-item').on('click', function() {
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

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown-container').length) {
            $('.dropdown').hide();
            $('.dropdown-toggle').removeClass('open');
        }
    });
});
JS;
$this->registerJs($script);
?>