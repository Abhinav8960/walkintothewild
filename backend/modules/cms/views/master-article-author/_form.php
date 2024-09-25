<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?php $form = ActiveForm::begin(['id' => 'author-form',]); ?>

<div class="col-md-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Author Name']) ?>
</div>

<?php if ($model->master_article_author_model->id) { ?>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
    </div>
<?php } ?>



<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>