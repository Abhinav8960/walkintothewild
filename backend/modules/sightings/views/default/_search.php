<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use kartik\daterange\DateRangePicker;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
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

    <div class="col-md-2">
        <?= $form->field($model, 'safari_operator_id')->dropDownList(
            GeneralModel::operatorslist(),
            [
                'prompt' => 'Select Partner Name',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'date_range', [
            // 'addon' => ['prepend' => ['content' => '<i class="fas fa-calendar-alt"></i>']],
            'options' => ['class' => 'drp-container mb-2']
        ])->widget(DateRangePicker::classname(), [
            'options' => ['placeholder' => 'Select Sighting Date'],
        ]);
        ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'master_animal_id')->dropDownList(
            GeneralModel::animalfilteroption(),
            [
                'prompt' => 'Select Animal',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'location')->dropDownList(
            \yii\helpers\ArrayHelper::map(SafariPark::find()->orderby(['safari_park.title' => SORT_ASC])->all(), 'id', 'title'),
            [
                'prompt' => 'Select Park',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'safari_session_id')->dropDownList(
            GeneralModel::safarisessionoption(),
            [
                'prompt' => 'Select Session',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::newstatusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
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