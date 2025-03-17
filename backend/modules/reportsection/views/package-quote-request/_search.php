<?php

use common\models\cms\article\ArticleCommentSearch;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{label}{input}{error}',
    ],
]); ?>
<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Search by Package Name'])->label('Package Name') ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'start_date')->input('date', [
            'placeholder' => 'Search by Start Date',
            'class' => 'form-control'
        ])->label('Date') ?>
    </div>

</div>
<?php ActiveForm::end(); ?>

<?php

$script = <<< JS
               
    $("#Searchform").on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
       
    }); 
    
JS;
$this->registerJs($script);
?>