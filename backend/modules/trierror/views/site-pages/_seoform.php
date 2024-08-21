<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\state\MasterState $model */
/** @var yii\widgets\ActiveForm $form */

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'placeholder' => 'Enter Keywords']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => '5', 'placeholder' => 'Enter Description']) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'image')->fileInput()->label('Image (JPEG / JPG / PNG)') ?>
    </div>
    <?php if ($model->site_pages_seo->image) { ?>
        <div class="col-md-1">
            <?php echo '<img src="' . Yii::$app->params['frontend_url'] . "/" . $model->site_pages_seo->image . '" width="100" ></img>'; ?>
        </div>
    <?php } ?>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>