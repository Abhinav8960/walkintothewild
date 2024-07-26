<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'action' => Url::toRoute(['/chat/default/message', 'user_handle' => $login_user->user_handle]),
]); ?>

<?= $form->field($searchModel, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Search', 'autocomplete' => 'off'])->label(false) ?>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
  $('form').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    }); 
    $('form input[type=text]').on('keyup', function(){
        setTimeout(() => {
            $("#Searchform").attr("data-pjax", "true");    
            $(this).closest('form').submit();
        }, 100);
       
    }); 

JS;
$this->registerJs($js);

?>