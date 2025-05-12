<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;

$names = ArrayHelper::getColumn(
    User::find()->select('name')->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
    'name'
);

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
        <?php echo $form->field($model, 'user_name')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Search By User Name'],
            'pluginOptions' => ['highlight' => true],
            'dataset' => [
                [
                    'local' => $names,
                    'limit' => 10
                ]
            ]
        ]); ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'safari_operator_id')->dropDownList(
            GeneralModel::operatorslist(),
            [
                'prompt' => 'Select Partner Name',
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