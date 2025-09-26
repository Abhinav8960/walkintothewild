<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
$this->title = 'Compliance Documents';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/compliancedocuments'];
$this->params['breadcrumbs'][] = 'Update';
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="card-body">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
<h5><?=$model->cdocument_model->labeltype?></h5>

    <div class="row">
        <?= $form->field($model, 'content', ['labelOptions' => ['class' => 'Modal_label']])->textarea(['rows' => '6', 'placeholder' => 'Add Content Here'])->label('Content <span class="necessary">*</span>') ?>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    .ck-editor__editable {
        min-height: 450px;
    }
</style>
<?php
$script = <<<JS
    editor('compliancedocumentsform-description');
    JS;
$this->registerJs($script);
?>