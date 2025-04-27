<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Package : ' . $package_version_model->package_name . '';
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

<div class="row mt-2">
    <div class="col-md-12">
        <?= $form->field($model, 'faq_id')->dropDownList(GeneralModel::masterfaqoption($package_version_model->id), ['prompt' => 'Select FAQ'])->label(false) ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group float-end">
            <?= Html::submitButton('Create ', ['class' => 'btn_newsafari font_set w-auto ms-2']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>