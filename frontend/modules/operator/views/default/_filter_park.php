<?php

use common\models\GeneralModel;
use frontend\models\SafariOperatorReviewForm;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'search-form'
    ],
    'method' => 'get',
]); ?>

<div class="col-2">
    <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($operator_id),  ['prompt' => 'Search by Park', 'class' => 'form-select'])->label(false) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$script = <<< JS
          
    $('form').on('change', function(){
        $("#side-search-form").attr("data-pjax", "true");    
        $(this).closest('form').submit();
       
    }); 
JS;
$this->registerJs($script);
?>