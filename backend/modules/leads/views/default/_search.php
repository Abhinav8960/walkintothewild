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
        <?= $form->field($model, 'source')->dropDownList(
            GeneralModel::leadSource(),
            [
                'prompt' => 'Select Source',
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