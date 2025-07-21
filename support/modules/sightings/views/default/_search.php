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
        'id' => 'sighting-search-form'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-12 mb-3">
        <div class="filterBar">
            <div class="filters">
                <div class="filterItem position-relative">
                    <label>Partner:</label>
                    <?= $form->field($model, 'safari_operator_id')->dropDownList(
                        GeneralModel::operatorslist(),
                        [
                            'prompt' => 'Select Partner Name',
                            'class' => 'search-border'
                        ]
                    ) ?>
                </div>

                <!-- <div class="filterItem position-relative">
                    <label>Date:</label>
                    <?= $form->field($model, 'date_range', [
                        // 'addon' => ['prepend' => ['content' => '<i class="fas fa-calendar-alt"></i>']],
                        'options' => ['class'=>'search-border']
                    ])->widget(DateRangePicker::classname(), [
                        'options' => ['placeholder' => 'Select Sighting Date'],
                    ]);
                    ?>
                </div> -->

                <div class="filterItem position-relative">
                    <label>Animal:</label>
                    <?= $form->field($model, 'master_animal_id')->dropDownList(
                        GeneralModel::animalfilteroption(),
                        [
                            'prompt' => 'Select Animal',
                            'class' => 'search-border'
                        ]
                    ) ?>
                </div>

                <div class="filterItem position-relative">
                    <label>Park:</label>
                    <?= $form->field($model, 'location')->dropDownList(
                        \yii\helpers\ArrayHelper::map(SafariPark::find()->orderby(['safari_park.title' => SORT_ASC])->all(), 'id', 'title'),
                        [
                            'prompt' => 'Select Park',
                            'class' => 'search-border'
                        ]
                    ) ?>
                </div>

                <div class="filterItem position-relative">
                    <label>Session:</label>
                    <?= $form->field($model, 'safari_session_id')->dropDownList(
                        GeneralModel::safarisessionoption(),
                        [
                            'prompt' => 'Select Session',
                            'class' => 'search-border'
                        ]
                    ) ?>
                </div>

                <div class="filterItem position-relative">
                    <label>Status:</label>
                    <?= $form->field($model, 'status')->dropDownList(
                        GeneralModel::newstatusoption(),
                        [
                            'prompt' => 'Select Status',
                            'class' => 'search-border'
                        ]
                    ) ?>
                </div>
            </div>
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