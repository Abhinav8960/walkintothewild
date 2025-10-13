<?php

use common\models\GeneralModel;
use common\models\partnerregistration\PartnerRegistration;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Update Details';
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $safari_operator_update_model, 'active_navbar' => 'update-details']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <?php $form = ActiveForm::begin(['options' => ['id' => 'update_detail', 'enctype' => 'multipart/form-data']]); ?>

                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($model, 'operator_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Operator Name',
                                    ]) ?>
                                </div>


                                <div class="col-md-3">
                                    <?= $form->field($model, 'business_name')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Business Name/ Brand Name',
                                    ]) ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'address')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter Address',
                                    ]) ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'about_business')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'About Business',
                                    ]) ?>
                                </div>

                                <div class="col-md-3">
                                    <?= $form->field($model, 'logo_file')->fileInput() ?>
                                </div>

                                <?php if ($safari_operator_update_model->Imagepath) { ?>
                                    <div class="col-md-3">
                                        <img src="<?= $safari_operator_update_model->Imagepath ?>">
                                    </div>
                                <?php } ?>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= Html::a('Cancel', ['view', 'id' => $safari_operator_update_model->id], ['class' => 'btn btn-danger text-white']) ?>
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