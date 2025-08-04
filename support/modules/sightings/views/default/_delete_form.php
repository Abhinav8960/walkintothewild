<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Delete';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'delete-form']); ?>

        <div class="row">
        
            <div class="col-md-12">
                <?= $form->field($model, 'delete_reason')->textInput(['placeholder' => 'Enter Reason Details'])->label('Reason') ?>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger text-white']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>


        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
