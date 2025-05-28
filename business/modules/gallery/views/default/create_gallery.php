<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Add Gallery Image';
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <div class="card">
        <div class="card-body">

            <div class="card mt-2">

                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['id' => 'add-gallery', 'enctype' => 'multipart/form-data']]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Add Gallery Title']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'caption')->textInput(['placeholder' => 'Add Gallery Caption']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'file')->fileInput() ?>
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
        </div>
    </div>
</div>