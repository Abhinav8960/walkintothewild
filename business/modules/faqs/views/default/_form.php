<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">

                    <div class="col-lg-12">
                        <div style="background-color: #f5f7fb; padding: 20px">
                            <div class="col-md-12">
                                <div class="form_boxes mb-3">
                                    <label for="">Park</label>
                                    <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($safari_operator->id), ['prompt' => 'Select Park'])->label(false) ?>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form_boxes mb-3">
                                    <label for="">Question</label>
                                    <?= $form->field($model, 'question')->textarea(['rows' => '2', 'placeholder' => 'Question', 'class' => 'form-control'])->label(false) ?>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form_boxes mb-3">
                                    <label for="">Answer <span>*</span></label>
                                    <?= $form->field($model, 'answer')->textarea(['rows' => '2', 'placeholder' => 'Answer', 'class' => 'form-control'])->label(false) ?>

                                </div>
                            </div>

                            <?php
                            if (!empty($model->faqs_model->id)) { ?>
                                <div class="col-lg-6">
                                    <div class="form_boxes mb-3">
                                        <label for="">Status</label>
                                        <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => '--Select Status--'])->label(false) ?>
                                    </div>
                                </div>
                            <?php } ?>


                            <div class="col-12">
                                <div
                                    class="d-flex gap-3 justify-content-end align-items-center">
                                    <?php if(!empty($model->faqs_model->id)){?>
                                        <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
                                        <?php } else { ?>
                                    <?= Html::submitButton('Create', ['class' => 'button-created create']) ?>
                                    <?php  } ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>