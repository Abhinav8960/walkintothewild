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
<h5>Basic Detail</h5>
<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList(
            ['p' => 'Page', 'b' => 'Block'],
            ['prompt' => 'Select Type']
        ) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
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