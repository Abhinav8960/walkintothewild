<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'faq-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'question')->textarea(['rows' => '2', 'placeholder' => 'Question'])->label('Question') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'answer')->textarea(['rows' => '2', 'placeholder' => 'Answer'])->label('Answer') ?>
            </div>
            <?php
            if (!empty($model->package_faq_model->id)) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoption(), ['prompt' => '--Select Status--']) ?>
                </div>
            <?php } ?>
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