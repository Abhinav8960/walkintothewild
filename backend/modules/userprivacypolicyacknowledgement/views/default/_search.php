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
        'id' => 'Searchform'
    ],
    'method' => 'post',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">

    <div class="col-md-2">
        <?= $form->field($model, 'user_id')->widget(Select2::class, [
            'initValueText' => $model->user_id ? GeneralModel::name_with_email($model->user_id) : '',
            'options' => ['placeholder' => 'Select User', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => \yii\helpers\Url::toRoute(['user-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            ],
        ]); ?>
    </div>

    <?php if(false){ ?>
    <div class="col-md-2">
        <?= $form->field($model, 'created_at')->input('date', [
            'placeholder' => 'Search by Acknowledge DateTime',
            'class' => 'form-control'
        ])->label('Acknowledge Date') ?>
    </div>
    <?php } ?>

    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>