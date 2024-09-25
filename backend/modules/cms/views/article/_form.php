<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>


<div class="col-md-12">
    <div class="card card_bodyPadding">
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin([
                'id' => 'article-form',
                'method' => 'POST',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'enableClientScript' => true,
                'action' => $model->action_url,
                'validationUrl' => $model->action_validate_url,
            ]); ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'title', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Enter Article Title',
                    ])->label('Title <span class="necessary">*</span>') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'article_tags', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->widget(\kartik\select2\Select2::classname(), [
                        'data' => GeneralModel::tagoption(),
                        'options' => ['placeholder' => 'Select', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Article Tag <span class="necessary">*</span>') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'article_topics', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->widget(\kartik\select2\Select2::classname(), [
                        'data' => GeneralModel::topicoption(),
                        'options' => ['placeholder' => 'Select', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Article Topics <span class="necessary">*</span>') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'article_author_id')->dropDownList(GeneralModel::authoroption(), ['prompt' => 'Select Author'])->label('Article Author <span class="necessary">*</span>') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'meta_title', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Enter Meta Title',
                    ])->label('Meta Title <span class="necessary">*</span>') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'article_date', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->input('date', [
                        'max' => date('Y-m-d')
                    ])->label('Article Date <span class="necessary">*</span>') ?>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'banner_image', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->fileInput()->label('Article Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                </div>
                <?php
                if ($model->article_model->banner_image) { ?>
                    <div class="col-md-6">
                        <?php echo '<img src="' . $model->article_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <?= $form->field($model, 'description', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textarea(['rows' => '6', 'placeholder' => 'Description Detail '])->label('Description <span class="necessary">*</span>') ?>
            </div>

            <div class="row">


                <!-- <?php if ($model->article_model->id) { ?>
                    <div class="col-md-3">
                        <?= $form->field($model, 'status', [
                                'labelOptions' => ['class' => 'Modal_label']
                            ])->radioList(GeneralModel::statusoption(), ['prompt' => '--Select --'])->label('Article Status <span class="necessary">*</span>') ?>

                    </div>
                <?php } ?> -->

                <div class="col-md-3">
                    <?= $form->field($model, 'status', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->radioList(GeneralModel::userstatusoption(), ['prompt' => '--Select --'])->label('Article Status <span class="necessary">*</span>') ?>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="creat-safri float-end w-auto">
                        <?= Html::submitButton('Save', ['class' => 'safari_create font_set px-5']) ?>
                    </div>
                </div>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('articleform-description');
JS;
$this->registerJs($script);
?>