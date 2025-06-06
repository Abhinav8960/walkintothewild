<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Update Thumbnail';
$this->params['title'] = $this->title;
?>

<div class="card mt-2">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'update-thumbnail', 'enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'high_thumbnail')->fileInput() ?>
            </div>
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
    .text-box p span {
        color: brown !important;
    }
</style>