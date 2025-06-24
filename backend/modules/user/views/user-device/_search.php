<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserSession;
use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
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
    <div class="col-md-4">
        <?= $form->field($model, 'id')->widget(Select2::class, [
            'initValueText' => $model->id ? $model->name . '(' . $model->email . ')' : '',
            'options' => ['placeholder' => 'Select User', 'mulitple' => false],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['login-user/user-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            ],
        ]); ?>

    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>