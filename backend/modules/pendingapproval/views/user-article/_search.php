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
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::userstatusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'is_approved')->dropDownList(
            ['0' => 'Not Approved', '1' => 'Approved'],
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
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