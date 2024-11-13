<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimal $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'is_filter')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select']) ?>
    </div>

    <div class="col-md-3 is_filter_sequence" style="<?= $model->is_filter == 1 ? 'display:block;' : 'display:none;' ?>">
        <?= $form->field($model, 'is_filter_sequence')->textInput(['maxlength' => true, 'placeholder' => 'Filter Sequence']) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'is_searchable')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select']) ?>
    </div>

    <?php if ($model->animal_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>

    <div class="col-md-12">
        <?= $form->field($model, 'short_description')->textarea() ?>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>




<?php
$script = <<< JS
    $('#masteranimalform-is_filter').on('change', function(){
        if($(this).val()==1){
            $('.is_filter_sequence').css('display','block');
        }else{
            $('.is_filter_sequence').css('display','none');
        }
    });
JS;
$this->registerJs($script);
?>