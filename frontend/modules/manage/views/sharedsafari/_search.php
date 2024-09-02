<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorPark;
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

<div class="col-md-4 mb-2">
    <?= $form->field($searchModel, 'park_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(SafariOperatorPark::find()->joinwith(['park'])->where(['safari_operator_park.status' => 1])->orderby(['safari_park.title' => SORT_ASC])->all(), 'park_id', 'park.title'),
        [
            'prompt' => 'Select Park',
        ]
    ) ?>
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