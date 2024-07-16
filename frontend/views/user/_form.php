<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'User';
$this->params['breadcrumbs'][] = "Create";
if (isset($model->user_model->id)) {
    $this->params['breadcrumbs'][] = "Update";
}
$this->params['title'] = $this->title;
?>

<div class="container">
    <div class="card m-5">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'tag-form',
                'method' => 'POST',
                'fieldConfig' => [
                    'template' => '<div class="form-group">{label}{input}{error}</div>',
                ],
            ]); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h1>Account Setting</h1>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true, 'placeholder' => 'Mobile Number']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'profile_image')->fileInput() ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'cover_image')->fileInput() ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'user_handle')->textInput(['maxlength' => true, 'placeholder' => 'User Name']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6"><?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true, 'placeholder' => 'Facebook Link']) ?></div>
                        <div class="col-6"><?= $form->field($model, 'whatsapp_url')->textInput(['maxlength' => true, 'placeholder' => 'Whatsapp Link']) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-6"><?= $form->field($model, 'x_url')->textInput(['maxlength' => true, 'placeholder' => 'X Link']) ?></div>
                        <div class="col-6"><?= $form->field($model, 'insta_url')->textInput(['maxlength' => true, 'placeholder' => 'Instagram Link']) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'about')->textarea(['rows' => 6, 'placeholder' => 'About']) ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>