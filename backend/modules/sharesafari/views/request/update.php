<?php

use common\interfaces\StatusInterface;
use common\models\master\sharesafarireason\MasterShareSafariReason;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'approval-form']); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'is_approved')->dropDownList(['1' => 'Approve', '0' => 'Reject'], ['prompt' => 'Select Status']) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'reason_id')->dropDownList(ArrayHelper::map(MasterShareSafariReason::find()->where(['status' => 1])->all(), 'id', 'reason'), ['prompt' => 'Select Reject Reason'])->label(false) ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<<Js
    $( document ).ready(function() {
      
       $('#sharesafariapprovalform-is_approved').on('change',function()
       {
          var selectedVal = $(this).val();
          if(selectedVal == 0)
          {
            $('#sharesafariapprovalform-reason_id').show();
          }else
          {
            $('#sharesafariapprovalform-reason_id').hide();
          }
       })
    });
Js;
$this->registerJs($script);
?>