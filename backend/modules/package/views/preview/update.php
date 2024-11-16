<?php

use common\models\GeneralModel;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = ' Update Package : ' . $package_model->package_name;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="panel panel-primary tabs-style-2">
    <div class="card mg-b-20">
        <div class="card-body">

        </div>

    </div>
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
                                <h1><?= $package_model->package_name ?></h1>
                            </div>
                            <?php
                            if (!empty($model->package_model->id)) { ?>
                                <div class="col-md-2 mt-4">
                                    <?= $form->field($model, 'popular_package')->checkbox() ?>
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