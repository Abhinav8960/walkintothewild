<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorPark;
use common\models\registration\SafariOperatorRequestPark;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'safari-operator-searchform'
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
                    <label>Source:</label>
                    <?= $form->field($model, 'park_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(SafariOperatorPark::find()->joinwith(['park'])->where(['safari_operator_park.status' => 1])->orderby(['safari_park.title' => SORT_ASC])->all(), 'park_id', 'park.title'),
                        [
                            'prompt' => 'Select Park',
                            'class' => 'search-border'
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Source:</label>
                    <?= $form->field($model, 'status')->dropDownList(
                        GeneralModel::newstatusoption(),
                        [
                            'prompt' => 'Select Status',
                            'class' => 'search-border'
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
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