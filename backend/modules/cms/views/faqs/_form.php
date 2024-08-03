<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<h5>FAQ</h5>

<div class="col-md-6">
    <?= $form->field($model, 'category_id', ['inputOptions' => ['id' => 'title']])->dropDownList(
        GeneralModel::faqcategoryoption(),
        [
            'prompt' => 'Select Category',
        ]
    ); ?>
</div>

<div class="col-md-12">
    <?= $form->field($model, 'question')->widget(CKEditor::className(), [
        'options' => ['rows' => 4],
        'preset' => 'full',

    ]) ?>
</div>

<div class="col-md-12">
    <?= $form->field($model, 'answer')->widget(CKEditor::className(), [
        'options' => ['rows' => 4],
        'preset' => 'full',

    ]) ?>
</div>


<?php if ($model->faqs_model->id) { ?>
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