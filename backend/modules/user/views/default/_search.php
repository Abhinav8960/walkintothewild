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
    <?php if (false) { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Search by Login ID'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Search by Email'])->label(false) ?>
        </div>
    <?php } ?>

    <div class="col-md-2">
        <?= $form->field($model, 'id')->widget(Select2::class, [
            'initValueText' => $model->id ? GeneralModel::name_with_email($model->id) : '',
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

    <div class="col-md-2">
        <?= $form->field($model, 'is_mobile_no_verified')->dropDownList(
            GeneralModel::mobileVerfied(),
            [
                'prompt' => 'Select by Verified Mobile',
            ]
        ) ?>

    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(['10' => 'Active', '9' => 'Inactive'], ['placeholder' => 'Search by Status'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>