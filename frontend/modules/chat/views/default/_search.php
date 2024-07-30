<?php

use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
]); ?>

<?= $form->field($searchModel, 'name')->textInput(['class' => 'form-control searchChat position-relative', 'placeholder' => 'Search', 'autocomplete' => 'off', 'autofocus' => $autofocus])->label(false) ?>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
  $('#Searchform').on('change', function(){
        $("#Searchform").attr("data-pjax", "true");    
        $(this).closest('form').submit();
    }); 
    $('#chatsearch-name').on('keyup', function(){
        setTimeout(() => {
            $("#Searchform").attr("data-pjax", "true");    
            $(this).closest('form').submit();
        }, 200);
       
    }); 

    var fieldInput = $('#chatsearch-name');
    var fldLength= fieldInput.val().length;
    if(fldLength>=1){
        fieldInput[0].setSelectionRange(fldLength, fldLength);
    }

JS;
$this->registerJs($js);

?>