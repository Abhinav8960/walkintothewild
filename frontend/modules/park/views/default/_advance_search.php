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
                <?= $form->field($model, 'master_vehicle_id')->dropDownList(GeneralModel::vehicleoption(), ['prompt' => 'Gypsy,Bus...', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
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
                        <?= $form->field($model, 'accomodation_id')->dropDownList(GeneralModel::accomodationoption(), ['prompt' => 'Forest Rest House..', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
                        <div class="placeholder_select">
                            <p>Accommodation</p>
                        </div>
                        <div class="icons_select">
                            <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="">
                        </div>
                    </div>
                    <div class="select_boxes position-relative">
                        <?= $form->field($model, 'session_id')->dropDownList(GeneralModel::safarisessionoption(), ['prompt' => 'evening,morning..', 'class' => "form-select form-select-lg", 'aria-label' => "Large select example"]) ?>
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
                <?= Html::submitButton('Search') ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="toogle_icon mt-2">
    <button id="toggleButton"><i class="fa-solid fa-chevron-down"></i> Advance Search</button>
</div>