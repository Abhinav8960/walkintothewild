<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\RenderedContentSearch $model */
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

    <div class="col-md-3">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Page Title'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'url')->textInput(['placeholder' => 'Search by Page Url'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'action_url')->textInput(['placeholder' => 'Search by Page Action Url'])->label(false) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>