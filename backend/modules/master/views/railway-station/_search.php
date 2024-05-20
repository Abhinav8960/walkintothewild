<?php

use common\models\GeneralModel;
use yii\helpers\Html;
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

    <div class="col-md-3">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search by Title'])->label(false) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::statusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $('form').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    }); 
    $('form input[type=text]').on('keyup', function(){
        setTimeout(() => {
            $("#Searchform").attr("data-pjax", "true");    
            $(this).closest('form').submit();
        }, 500);
       
    }); 
                  
JS;
$this->registerJs($script);
?>