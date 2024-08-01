<?php

use common\interfaces\StatusInterface;
use common\models\GeneralModel;
use common\models\meta\MetaStayCategory;
use common\models\operator\SafariOperatorPark;
use common\models\park\SafariPark;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Organize a New Safari';
$this->params['title'] = $this->title;
?>


<?php if ($show_banner) { ?>
    <section class="banner_section-inner position-relative">
        <picture class="position-relative">
            <source srcset="<?= $this->params['baseurl'] ?>/img/birdingbnner.jpg" media="(max-width:576px)" type="image/webp">
            <img src="<?= $this->params['baseurl'] ?>/img/birdingbnner.jpg" class="d-block w-100 " alt="banner">
        </picture>

    </section>
<?php } ?>
<section class="">
    <div class="container-lg ">
        <div class="row justify-content-center  <?= $show_banner ? 'py-5' : '' ?>">
            <?php if ($show_banner) { ?>
                <div class="col-12 py-4 text-center">
                    <div class="headings">
                        <h3><?= $model->shared_safari_model->id ? 'Update Safari' : 'Organize a New Safari' ?></h3>
                    </div>
                </div>
            <?php } ?>

            <div class="<?= $show_banner ? 'col-xl-10 col-lg-11 mb-4' : 'col-md-12' ?>">


                <?php $form = ActiveForm::begin([
                    'id' => 'organize-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'enableClientScript' => true,
                    'action' => $model->action_url,
                    'validationUrl' => $model->action_validate_url,
                ]); ?>
                <div class="modal-body modal_form <?= $show_banner ? 'card' : '' ?>">

                    <div class="<?= $show_banner ? 'card-body' : '' ?>">
                        <div class="row">

                            <div class="col-12 mb-2">
                                <label for="" class="Modal_label">Select a Safari Park <span class="necessary">*</span></label>
                                <?= $form->field($model, 'park_id')->dropDownList(
                                    ArrayHelper::map(SafariPark::find()->where(['status' => StatusInterface::STATUS_ACTIVE, 'is_shared_safari' => 1])->all(), 'id', 'title'),
                                    [
                                        'prompt' => 'Select a Safari Park',
                                        'class' => 'form-select form-select-lg mb-3',
                                        'onchange' => '
                                            $.get( "' . Yii::$app->urlManager->createUrl('/sharedsafari/default/getparkimage?id=') . '"+$(this).val(), function( data ) {
                                                $( "#park_image").attr( "src",data );
                                                })'
                                    ]
                                )->label(false) ?>
                            </div>

                            <?php
                            if ($model->shared_safari_model->image) { ?>
                                <div class="col-md-3">
                                    <label for="" class="Modal_label">Current Display Image</label>
                                    <?php echo '<
                                     src="' . $model->shared_safari_model->sharedimagepath . '" width="100px" height="100px" id="park_image"></
                                    >'; ?>
                                </div>

                                <div class="col-6 mb-2">
                                    <label for="" class="Modal_label">Browse Image</label>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'shared_safari_image')->fileInput()->label(false) ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php
                            if ($model->shared_safari_model->image == null) {
                                if ($model->shared_safari_model->park_id) { ?>
                                    <div class="col-sm-3">
                                        <label for="" class="Modal_label">Current Display Image</label>
                                        <?php echo '<img src="' . $model->shared_safari_model->sharedimagepath . '" width="100px" height="100px" id="park_image"></img>'; ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-3 mb-2">
                                        <label for="" class="Modal_label">Current Display Image</label>
                                        <img src="" id="park_image" alt="" width="100%" height="100px">
                                    </div>
                                <?php } ?>
                                <div class="col-sm-9 mb-2">
                                    <label for="" class="Modal_label">Browse Image</label>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'shared_safari_image')->fileInput()->label(false) ?>
                                    </div>
                                </div>
                            <?php }

                            ?>

                            <div class="col-md-6 mb-1">
                                <label for="" class="Modal_label">Theme <span class="necessary">*</span></label>
                                <?= $form->field($model, 'share_safari_agenda_id')->dropDownList(['1' => 'Photography', '2' => 'Vlogging', '3' => 'Safari Experience'], ['prompt' => 'Select Theme', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>

                            </div>

                            <div class="col-md-6 mb-1">
                                <label for="" class="Modal_label">Number of Safaris (1-10)</label>
                                <?= $form->field($model, 'no_of_safari')->textInput(['type' => 'range', 'min' => 1, 'max' => 10, 'class' => 'slider', 'value' => ($model->no_of_safari) ? $model->no_of_safari : 1])->label(false)->hint('No of Safaris : <span id="safariseat">' . $model->no_of_safari . '</span>') ?>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex  gap-sm-3 align-items-center flex-sm-nowrap flex-wrap  w-100 mb-1">
                                    <div class="start w-100">
                                        <label for="" class="Modal_label">Start Date <span class="necessary">*</span></label>
                                        <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label(false) ?>
                                    </div>
                                    <span class="pt-sm-4 text-center">-</span>
                                    <div class="start w-100">
                                        <label for="" class="Modal_label">End Date <span class="necessary">*</span></label>
                                        <?= $form->field($model, 'end_date')->textInput(['type' => 'date'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="Modal_label">Stay Category</label>
                                <?= $form->field($model, 'stay_category_id')->dropDownList(['1' => ' Budget', '2' => 'Economical', '3' => 'Premium'], ['class' => 'form-select form-select-lg mb-3'])->label(false) ?>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label for="" class="Modal_label">Estimate Price Per Person (INR) <span class="necessary">*</span></label>
                                <div class="d-flex gap-3 align-items-center">
                                    <?= $form->field($model, 'estimate_price_min')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 1000])->label(false) ?>
                                    <span>-</span>
                                    <?= $form->field($model, 'estimate_price_max')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 2000])->label(false) ?>
                                </div>

                            </div>
                            <!-- <div class="col-lg-6">
                                <label for="" class="Modal_label">Tour Duration(1-10)</label>
                                <?= $form->field($model, 'tour_duration')->textInput(['type' => 'range', 'min' => 1, 'max' => 10, 'class' => 'slider', 'value' => ($model->tour_duration) ? $model->tour_duration : 1,])->label(false) ?>
                                <p>Value: <span id="tour"><?= $model->tour_duration ?></span></p>
                            </div> -->
                            <div class="col-lg-12 ">
                                <div class="textarea">
                                    <label for="" class="Modal_label">Plan <span class="necessary">*</span></label>
                                    <?= $form->field($model, 'safari_plan')->textarea(['row' => 4, 'placeholder' => 'Write about your plan'])->label(false) ?>
                                </div>

                            </div>

                            <div class="col-lg-12">


                                <!-- <label for="" class="Modal_label">Your Social Media Url/ Website Url</label>
                                <?= $form->field($model, 'website_url')->textInput()->label(false); ?> -->

                                <div class="d-flex align-items-center gap-2">
                                    <div class="selects w-100">
                                        <label for="" class="Modal_label">Total Seat <span class="necessary">*</span></label>
                                        <?= $form->field($model, 'total_seat')->dropDownList(
                                            ['2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'],
                                            [
                                                'prompt' => 'Total Seat',
                                                'class' => 'form-select form-select-lg mb-3',
                                                'onchange' => '
                        $.get( "' . Yii::$app->urlManager->createUrl('sharedsafari/default/dynamicsharedseat?total_seat=') . '"+$(this).val(), function( data ) {
                            $( "#sharedsafariform-share_seat").html(data);
                            })'
                                            ]
                                        )->label(false) ?>
                                    </div>
                                    <div class="selects w-100">
                                        <label for="" class="Modal_label">Share Seats <span class="necessary">*</span></label>
                                        <?= $form->field($model, 'share_seat')->dropDownList($model->getSharedseat(), ['prompt' => 'Share Seats', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 margin-remove">
                                <?= $form->field($model, 'host_type')->hiddenInput()->label(false); ?>
                                <div class="creat-safri d-flex justify-content-end">
                                    <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <?php if (isset($model->shared_safari_model->id)) { ?>
                                        <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                                    <?php } else {  ?>
                                        <?= Html::submitButton('Create ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php ActiveForm::end() ?>

            </div>
        </div>

</section>

<?php
$script = <<< JS

          $("#sharedsafariform-start_date").on("change", function(){
          $("#sharedsafariform-end_date").attr("min", $(this).val());
          });

          $("#sharedsafariform-tour_duration").on("input",function()
          {
            var selectedValue = $(this).val();
            $("#tour").html(selectedValue);
          });

          $("#sharedsafariform-no_of_safari").on("input",function()
          {
            var selectedValue = $(this).val();
            $("#safariseat").html(selectedValue);
          });
          
JS;
$this->registerJs($script);
?>