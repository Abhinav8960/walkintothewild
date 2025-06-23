<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php
$form = ActiveForm::begin([
    'id' => 'faq-form-' . $question_no,
    'method' => 'POST',
    'action' => isset($url) ? $url : Yii::$app->request->url,
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<h2 class="accordion-header" id="heading_<?= $question_no ?>">
    <button class="accordion-button" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse_<?= $question_no ?>"
        aria-expanded="true" aria-controls="collapse_<?= $question_no ?>">
        Question <?= $question_no ?>
    </button>
</h2>
<div id="collapse_<?= $question_no ?>" class="accordion-collapse collapse show"
    aria-labelledby="heading_<?= $question_no ?>" data-bs-parent="#accordionExample">
    <div class="accordion-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form_boxes mb-3">
                    <label for="">Question</label>
                    <?= $form->field($model, 'question')->textarea(['rows' => '2', 'placeholder' => 'Question', 'class' => 'form-control'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form_boxes mb-3">
                    <label for="">Overview <span>*</span></label>
                    <?= $form->field($model, 'answer')->textarea(['rows' => '2', 'placeholder' => 'Answer', 'class' => 'form-control'])->label(false) ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div
                    class="d-flex gap-3 justify-content-end align-items-center">
                    <?php if (isset($faq_model) && $faq_model->id) { ?>
                        <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
                    <?php } else { ?>
                        <?= Html::submitButton('Create', ['class' => 'button-created create']) ?>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>