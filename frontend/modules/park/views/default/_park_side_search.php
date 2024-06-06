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
<div class="filter-wrapper">
    <div class="title_top pb-4">
        <h4>Select Filters</h4>
    </div>
    <div class="title_filter mb-4">
        <h6>Accommodation</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($model, 'accomodation_id')->checkboxList(
                GeneralModel::accomodationoption(),
                [
                    'required' => true,
                    'separator' => '<br>',
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Safari Session</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($model, 'session_id')->checkboxList(
                GeneralModel::safarisessionoption(),
                [
                    'required' => true,
                    'separator' => '<br>',
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
    <div class="title_filter mb-4">
        <h6>Bonus Experience</h6>
        <div class="input_check d-flex gap-3 align-items-center">
            <?= $form->field($model, 'bonus_experience_id')->checkboxList(
                GeneralModel::bonusexperienceoption(),
                [
                    'required' => true,
                    'separator' => '<br>',
                    'itemOptions' => ['class' => 'checkbox_design'],
                ]
            )->label(false); ?>
        </div>
    </div>
</div>
<div class="advertisment pt-5">
    <p class="text-center">ADVERTISMENT</p>
    <div class="advertisment_box-2">

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