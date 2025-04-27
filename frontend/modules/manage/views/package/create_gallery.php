<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Package : ' . $package_version_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'image_caption')->textInput(['rows' => '2', 'placeholder' => 'Enter Image Caption'])->label('Image Caption', ['class' => 'Modal_label']) ?>
    </div>
    <?php
    if ($model->package_gallery_model->image) { ?>
        <div class="col-md-10">
            <?= $form->field($model, 'image')->fileInput()->label('Image (JPEG / JPG / PNG / 940px * 430px / 250kb)', ['class' => 'Modal_label']) ?>
        </div>
        <div class="col-md-2">
            <?php echo '<img src="' . $model->package_gallery_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-12">
            <?= $form->field($model, 'image')->fileInput()->label('Image (JPEG / JPG / PNG / 940px * 430px / 250kb)', ['class' => 'Modal_label']) ?>
        </div>
    <?php  } ?>

    <?php
    if (!empty($model->package_gallery_model->id)) { ?>
        <div class="col-md-12">
            <?= $form->field($model, 'status')->dropDownList(
                GeneralModel::newstatusoption(),
                [
                    'prompt' => '--Select Status--',
                ]
            )->label('Status', ['class' => 'Modal_label'])
            ?>
        </div>
    <?php } ?>
</div>

<div class="row pt-3">
    <div class="col-lg-12 ">
        <div class="creat-safri d-flex justify-content-end">
            <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <?= Html::submitButton('Save ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>