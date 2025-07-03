<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Create Gallery';
// $this->params['title'] = $this->title;
?>


<?php $form = ActiveForm::begin(['options' => ['id' => 'create-gallery']]); ?>


<div class="col-12 mb-4">
    <div class="form_boxes mb-3">
        <label for="">Gallery Title <span>*</span></label>
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Enter Gallery Title'])->label(false) ?>
    </div>
</div>
<div class="col-12">
    <div class="modalCrateButton">
        <?= Html::submitButton('Save', ['class' => 'btn w-100']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>