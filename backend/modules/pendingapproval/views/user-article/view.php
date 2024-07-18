<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Safari Park';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '#'];
$this->params['breadcrumbs'][] = "User Article View";
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-2">
                <img src="<?= isset($model->banner_image) ? $model->bannerimagepath : "" ?>">
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Title:</span><?= $model->title ?>
                    </p>
                    <p>
                        <span>Author: </span><?= $model->author_name ?>
                    </p>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <div class="text-box">
                <p>
                    <span>Description: </span><?= $model->description ?>
                </p>
            </div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($approval_model, 'is_approved')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select Approval Option']) ?>
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