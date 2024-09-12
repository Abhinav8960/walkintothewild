<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row mt-2 p-3">
    <div class="col-md-12">
        <?= $form->field($model, 'question')->textarea(['rows' => '2', 'placeholder' => 'Question',])->label('Question')->label('Question',['class' => 'Modal_label']) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'answer')->textarea(['rows' => '2', 'placeholder' => 'Answer'])->label('Answer')->label('Answer',['class' => 'Modal_label']) ?>
    </div>
    <?php
    if (!empty($model->package_faq_model->id)) { ?>
        <div class="col-md-12 pt-2">
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => '--Select Status--'])->label(false) ?>
        </div>
    <?php } ?>
</div>

<div class="row px-3">
    <div class="col-md-12">
        <div class="creat-safri float-end w-auto pb-2">
            <?= Html::submitButton('Save ', ['class' => 'safari_create font_set w-auto']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>