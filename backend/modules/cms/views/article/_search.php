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
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Title'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'user_name')->textInput(['placeholder' => 'Search by User'])->label(false) ?>
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
        <?= $form->field($model, 'is_approved')->dropDownList(
            ['1' => 'Published', '0' => 'UnPublished'],
            [
                'prompt' => 'Main Portal Status',
            ]
        )->label(false) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            ['1' => 'Published', '0' => 'UnPublished'],
            [
                'prompt' => 'User Status',
            ]
        )->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>