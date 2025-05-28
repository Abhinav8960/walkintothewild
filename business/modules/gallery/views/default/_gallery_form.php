<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>



<?php $form = ActiveForm::begin(['options' => ['id' => 'add-gallery', 'enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Add Gallery Title']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'caption')->textInput(['placeholder' => 'Add Gallery Caption']) ?>
    </div>

    <?php if (!empty($model->partner_gallery_image_model->filepath)) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>
        <div class="col-md-6">
            <img src="<?= $model->partner_gallery_image_model->gallery_image ?>" alt="Gallery Image" width="100px" height="100px">
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>
    <?php } ?>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>