<?php

use common\models\GeneralModel;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform',

    ],
    'action' => ['reviewlist', 'slug' => $operator->slug],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<div class="col-12 form_review">
    <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($operator_id),  ['prompt' => 'Search by Park', 'class' => 'form-select'])->label(false) ?>
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