<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>



<?php $form = ActiveForm::begin(['options' => ['id' => 'add-gallery', 'enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-lg-4">
        <?php if (!empty($model->partner_gallery_image_model->filepath)) { ?>
            <div class="col-lg-12 ">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="form_boxes mb-3">
                            <div class="form-group mt-2">
                                <label for="fileField" class="attachment">
                                    <div class="row btn-file">
                                        <div class="btn-file__actions">
                                            <div
                                                class="btn-file__actions__item col-xs-12 text-center" style="height:200px;">
                                                <div class="btn-file__actions__item--shadow" style="margin-top:40px;">
                                                    <i class="fa fa-plus fa-lg fa-fw"
                                                        aria-hidden="true"></i>
                                                    <div class="visible-xs-block"></div>
                                                    Picture attached
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $form->field($model, 'file')->fileInput(['id' => "fileField"])->label(false) ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="external-preview mt-2">
                        <?php echo '<img src="' . $model->partner_gallery_image_model->gallery_image . '" width="200px" height="200px" id="imagePreviewBottom"></img>'; ?>
                        <img id="imagePreviewBottom" src="#" alt="Image Preview" style="display:none; max-height: 200px; border: 1px solid #ccc;" />
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="form_boxes mb-3">
                            <div class="form-group mt-2">
                                <label for="fileField" class="attachment">
                                    <div class="row btn-file">
                                        <div class="btn-file__actions">
                                            <div class="btn-file__actions__item col-xs-12 text-center" style="height:200px;">
                                                <div class="btn-file__actions__item--shadow" style="margin-top:40px;">
                                                    <i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>
                                                    <div class="visible-xs-block"></div>
                                                    Picture attached
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $form->field($model, 'file')->fileInput(['id' => "fileField"])->label(false) ?>
                                </label>
                            </div>
                        </div>

                        <div class="external-preview mt-2">
                            <img id="imagePreviewBottom" src="#" alt="Image Preview" style="display:none; max-height: 200px; border: 1px solid #ccc;" />
                        </div>
                    </div>
                </div>
            </div>
        <?php  } ?>

    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="form_boxes mb-3">
                    <label for="">Image Title <span>*</span></label>
                    <div class="mb-3 field-packageversionform-start_location">
                        <div class="form-group">
                            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Add Gallery Title', 'class' => 'form-control'])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form_boxes mb-3">
                    <label for="">Caption <span>*</span></label>
                    <div class="mb-3 field-packageversionform-start_location">
                        <div class="form-group">
                            <?= $form->field($model, 'caption')->textInput(['placeholder' => 'Add Gallery Caption', 'class' => 'form-control'])->label(false)  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-12">
        <div class="modalCrateButton">
            <button type="btn" class="w-100">Save</button>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>