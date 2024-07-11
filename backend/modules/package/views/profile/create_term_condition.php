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
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'term_condition_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $form = ActiveForm::begin([
                    'id' => 'author-form',
                    'method' => 'POST',
                    'fieldConfig' => [
                        'template' => '<div class="form-group">{label}{input}{error}</div>',
                    ],

                ]); ?>
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'title')->textInput(['rows' => '2', 'placeholder' => 'Enter Title'])->label('Title') ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'description')->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>
                            </div>

                            <?php
                            if (!empty($model->package_termcondition_model->id)) { ?>
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
            </div>
        </div>
    </div>
</div>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('packagetermconditionform-description');
JS;
$this->registerJs($script);
?>