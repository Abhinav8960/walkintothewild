<?php

use common\models\GeneralModel;
use common\models\partnerregistration\PartnerRegistration;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Stay Category';
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $operator_model,'stay_category_model'=>$stay_category_model, 'active_navbar' => 'stay-category']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <?php $form = ActiveForm::begin(['options' => ['id' => 'stay-category', 'enctype' => 'multipart/form-data']]); ?>

                            <h5>Safari Operator Stay Category</h5>
                            <hr>
                            <div class="row">

                                <div class="col-md-6">
                                    <?= $form->field($model, 'meta_stay_category')->widget(\kartik\select2\Select2::classname(), [
                                        'data' => GeneralModel::staycategoryoption(),
                                        'options' => ['placeholder' => 'Select', 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('Select Stay Category') ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= Html::a('Cancel', ['view', 'id' => $operator_model->id], ['class' => 'btn btn-danger text-white']) ?>
                                        <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                                    </div>
                                </div>

                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .text-box p span {
        color: brown !important;
    }
</style>