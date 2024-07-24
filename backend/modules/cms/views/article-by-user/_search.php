<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;

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
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Article Title'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'article_author_id')->dropDownList(
            GeneralModel::userauthoroption(),
            [
                'prompt' => 'Select Author',
            ]
        )->label(false) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'article_date')->input('date', ['class' => 'form-control'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'article_tags')->dropDownList(
            GeneralModel::tagoption(),
            [
                'prompt' => 'Select Tags',
            ]
        )->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'article_topics')->dropDownList(
            GeneralModel::topicoption(),
            [
                'prompt' => 'Select Topics',
            ]
        )->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::statusoption(),
            [
                'prompt' => 'Select Status',
            ]
        )->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>