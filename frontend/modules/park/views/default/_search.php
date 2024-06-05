<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
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
]); ?>
<div class="row gx-0">
    <div class="col-lg-10 col-xl-11">
        <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-1 w-100">
            <div class="select_boxes position-relative">
                <?= $form->field($model, 'master_location_id')->dropDownList(GeneralModel::locationoption(), ['prompt' => 'North india, South...', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
                <div class="placeholder_select">
                    <p>Location</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <?= $form->field($model, 'month_id')->dropDownList(GeneralModel::monthoption(), ['prompt' => 'May,june,July..', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
                <div class="placeholder_select">
                    <p>Month</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <?= $form->field($model, 'master_animal_id')->dropDownList(GeneralModel::animaloption(), ['prompt' => 'Tiger Elephent..', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
                <div class="placeholder_select">
                    <p>Animal</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                </div>
            </div>
            <div class="select_boxes position-relative">
                <select class="form-select form-select-lg " aria-label="Large select example">
                    <option selected>Gypsy,Bus...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <div class="placeholder_select">
                    <p>Vehicel</p>
                </div>
                <div class="icons_select">
                    <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                </div>
            </div>
            <div class="advanceSearch " id="advanceSearchBox">
                <div class="d-md-flex gap-1">
                    <div class="select_boxes position-relative">
                        <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Tiger Elephent..</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <div class="placeholder_select">
                            <p>Accommodation</p>
                        </div>
                        <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="">
                        </div>
                    </div>
                    <div class="select_boxes position-relative">
                        <select class="form-select form-select-lg " aria-label="Large select example">
                            <option selected>Gypsy,Bus...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <div class="placeholder_select">
                            <p>Safari seasion</p>
                        </div>
                        <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/day-night_8776508.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-xl-1">
        <div class="search">
            <div class="serch_btn">
                <button>Search</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php

$script = <<< JS


    $('form select').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    }); 
    $('form input[type=text]').on('keyup', function(){
        setTimeout(() => {
            $("#Searchform").attr("data-pjax", "true");    
            $(this).closest('form').submit();
        }, 1000);
       
    }); 
JS;
$this->registerJs($script);
?>