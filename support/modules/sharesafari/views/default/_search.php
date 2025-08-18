<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'safari-searchform'
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
                    <label>User:</label>
                    <?= $form->field($model, 'host_user_id')->widget(Select2::class, [
                        'initValueText' => $model->user ? $model->user->name . '(' . $model->user->email . ')' : '',
                        'options' => ['placeholder' => 'Select User', 'multiple' => false,'class' => 'search-border'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'ajax' => [
                                'url' => \yii\helpers\Url::to(['default/user-list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        ],
                    ]); ?>
                </div>


                <div class="filterItem position-relative">
                    <label>Status:</label>
                    <?= $form->field($model, 'custom_status')->dropDownList(GeneralModel::sharesafarioptionswithdelete(), ['prompt' => 'Select Status', 'class' => 'search-border'])->label(false) ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<<JS
    $('safari-searchform') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>