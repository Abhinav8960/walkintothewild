<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;

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
        <?= $form->field($model, 'article_title')->textInput(['placeholder' => 'Search by Article Title'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'source')->dropDownList(GeneralModel::sourceoption(), ['prompt' => 'Search Article Source'])->label('Article Source') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'writer')->textInput(['placeholder' => 'Search by Article Writer'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'post_date')->widget(\kartik\datetime\DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter Published Date'],
            'pluginOptions' => [

                'type' => DateTimePicker::TYPE_BUTTON,
                'format' => 'yyyy-mm-dd',
                'startDate' => 'today',
                'minView' => 'month',
                'maxView' => 'decade',
                'autoclose' => true,
            ]
        ]); ?>
    </div>
    <div class="col-md-2 select_width">
        <?= $form->field($model, 'tag_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::articletagoption(),
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Article Tag') ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::statusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

$script = <<< JS

    $('form').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();    
    }); 
JS;
$this->registerJs($script);
?>