<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'gallery-search-form'
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
$searchjs = <<<JS
    \$('#gallery-search-form').on('change', function() {
        \$(this).submit();
    });
    JS;
$this->registerJs($searchjs);
?>