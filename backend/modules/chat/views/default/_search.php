<?php

use common\models\GeneralModel;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$names = ArrayHelper::getColumn(
    User::find()->select('name')->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
    'name'
);

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform',
        'class' => 'd-flex align-items-center flex-wrap gap-2',
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput([
                'placeholder' => 'Search by name',
                'class' => 'form-control',
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'source')->dropDownList(
                GeneralModel::leadSource(),
                [
                    'prompt' => 'Select Source',
                ]
            ) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'operator_id')->dropDownList(
                GeneralModel::operatorslist(),
                [
                    'prompt' => 'Select Operator',
                ]
            ) ?>
        </div>

        <div class="col-md-3">
            <?=
            $form->field($model, 'quotation_count')->textInput([
                'placeholder' => 'Enter Quotation Count',
                'class' => 'form-control',
                'type' => 'number'
            ])
            ?>
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