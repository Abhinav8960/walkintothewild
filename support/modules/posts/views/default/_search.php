<?php

use common\models\GeneralModel;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$names = ArrayHelper::getColumn(
    User::find()->select('name')->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
    'name'
);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'post-search-form'
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
                
                <!-- <div class="filterItem position-relative">
                    <label>User:</label>
                    <?php echo $form->field($model, 'user_name')->widget(Typeahead::classname(), [
                        'options' => [
                            'placeholder' => 'Search By User Name',
                            'class' => 'search-border'
                        ],
                        'pluginOptions' => ['highlight' => true],
                        'dataset' => [
                            [
                                'local' => $names,
                                'limit' => 10
                            ]
                        ]
                    ]); ?>
                </div> -->

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
        \$('form') . on('change', function() {
            \$(this) . closest('form') . submit();
        });  
    JS;
$this->registerJs($js);
?>