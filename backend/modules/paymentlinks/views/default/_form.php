<?php


use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>

<?php $form = ActiveForm::begin([
    'id' => 'payment-link-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>


<div class="card">
    <div class="card-body">

        <div class="row">
            
            

            
            <div class="col-md-4">
                <?= $form->field($model, 'customer_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Customer Name',
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Email',
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'phone_no')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Phone No',
                ]) ?>
            </div>
            
            
            
            <div class="col-md-4">
                <?= $form->field($model, 'link_expiry_datetime')->widget(\kartik\datetime\DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Link Expiry Date'],
                    'pluginOptions' => [

                        'type' => DateTimePicker::TYPE_BUTTON,
                        'format' => 'yyyy-mm-dd',
                        'startDate' => date('Y-m-d H:i:s'),
                        'minView' => 'month',
                        'maxView' => 'decade',
                        'autoclose' => true,
                    ]
                ]); ?>
            </div>
            
            <div class="col-md-4">
                <?= $form->field($model, 'gross_amount')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Amount',
                ]) ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'purpose')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Purpose (if any)',
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
    </div>
</div>



<?php ActiveForm::end(); ?>


