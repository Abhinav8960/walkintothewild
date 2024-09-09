<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Article';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '#'];
$this->params['breadcrumbs'][] = "User Article View";
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($approval_model, 'status')->dropDownList(GeneralModel::articleuserstatusoption(), ['prompt' => 'Select Status Option'])->label('User Status') ?>
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

<style>
    .text-box p span {
        color: brown !important;
    }
</style>