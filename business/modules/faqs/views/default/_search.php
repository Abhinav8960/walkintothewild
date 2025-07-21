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
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-12">
        <div class="filterBar">
            <div class="filters">


                <!-- <div class="filterItem position-relative">
                    <label>Status:</label>
                    <?= $form->field($model, 'status')->dropDownList(
                        GeneralModel::newstatusoption(),
                        [
                            'prompt' => 'Select Status',
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div> -->
                <div class="filterItem position-relative">
                    <label>Park:</label>
                    <?= $form->field($model, 'park_id')->dropDownList(
                        GeneralModel::operatorpark($safari_operator->id),
                        [
                            'prompt' => 'Select Park',
                            'class' => 'search-border'

                        ],
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