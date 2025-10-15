<?php

use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;
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
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">

    <?php if ($model->type == ShareSafari::TYPE_SAFARI) { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'host_user_id')->widget(Select2::class, [
                'initValueText' => $model->hostUser ? $model->hostUser->name . '(' . $model->hostUser->email . ')' : '',
                'options' => ['placeholder' => 'Select User', 'multiple' => false],
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
    <?php } ?>

    <div class="col-md-2">
        <?= $form->field($model, 'share_safari_title')->textInput(['placeholder' => 'Search by Title'])->label(false) ?>
    </div>

    <?php if ($model->type == ShareSafari::TYPE_SAFARI) { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'custom_status')->dropDownList(GeneralModel::sharesafarioptionswithdelete(), ['prompt' => 'Select Status'])->label(false) ?>
        </div>
    <?php } else { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'custom_status')->dropDownList(GeneralModel::fdoptionswithdelete(), ['prompt' => 'Select Status'])->label(false) ?>
        </div>
    <?php } ?>


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