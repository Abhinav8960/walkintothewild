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

?>
<?php $form = ActiveForm::begin([
    'id' => 'organize-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]); ?>
<div class="modal-body modal_form">

    <div class="row">

        <?php if (Yii::$app->user->identity->is_safari_operator) { ?>
            <div class="col-12 mb-2">
                <label for="" class="Modal_label">Select a Safari Park</label>
                <?= $form->field($model, 'park_id')->dropDownList(
                    GeneralModel::operatorsafariparkoption(Yii::$app->user->identity),
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
        <?php } else { ?>
            <div class="col-12 mb-2">
                <label for="" class="Modal_label">Select a Safari Park</label>
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
        <?php } ?>



        <?php
        if ($model->shared_safari_model->image) { ?>
            <div class="col-md-3">
                <label for="" class="Modal_label">Current Display Image</label>
                <?php echo '<img src="' . $model->shared_safari_model->sharedimagepath . '" width="100px" height="100px"></img>'; ?>
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
                    <?php echo '<img src="' . $model->shared_safari_model->sharedimagepath . '" width="100px" height="100px"></img>'; ?>
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
            <label for="" class="Modal_label">Agenda</label>
            <?= $form->field($model, 'share_safari_agenda_id')->dropDownList(['1' => 'Photography', '2' => 'Vlogging', '3' => 'Safari Experience'], ['prompt' => 'Select Agenda', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>

        </div>

        <div class="col-md-6 mb-1">
            <label for="" class="Modal_label">Number of Safaris</label>
            <?= $form->field($model, 'no_of_safari')->textInput()->label(false) ?>
        </div>

        <div class="col-md-12">
            <div class="d-flex  gap-sm-3 align-items-center flex-sm-nowrap flex-wrap  w-100 mb-1">
                <div class="start w-100">
                    <label for="" class="Modal_label">Start Date</label>
                    <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label(false) ?>
                </div>
                <span class="pt-sm-4 text-center">-</span>
                <div class="start w-100">
                    <label for="" class="Modal_label">End Date</label>
                    <?= $form->field($model, 'end_date')->textInput(['type' => 'date'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <label for="" class="Modal_label">Stay Category</label>
            <?= $form->field($model, 'stay_category_id')->dropDownList(['1' => ' Budget', '2' => 'Economical', '3' => 'Premium'], ['class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
        <div class="col-lg-6 mb-2">
            <label for="" class="Modal_label">Estimate Price Per Person (INR)</label>
            <div class="d-flex gap-3 align-items-center">
                <?= $form->field($model, 'estimate_price_min')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 1000])->label(false) ?>
                <span>-</span>
                <?= $form->field($model, 'estimate_price_max')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 2000])->label(false) ?>
            </div>

        </div>
        <div class="col-lg-12 ">
            <div class="textarea">
                <?= $form->field($model, 'safari_plan')->textarea(['row' => 4, 'placeholder' => 'Write about your plan'])->label(false) ?>
            </div>

        </div>

    </div>
    <div class="row mt-2 pe-0">
        <div class="col-lg-12">
            <?php if (Yii::$app->user->identity->is_safari_operator) { ?>
                <?= $form->field($model, 'host_type')->hiddenInput(['value' => 4])->label(false); ?>
            <?php } else {  ?>
                <label for="" class="Modal_label">You Are?</label>
                <?= $form->field($model, 'host_type')->dropDownList(['1' => 'Individual', '2' => 'Wildlife Photographer', '3' => 'Wildlife Influencer'], ['prompt' => 'Select Who you Are?', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
            <?php } ?>

            <?php if (!Yii::$app->user->identity->is_safari_operator) { ?>
                <label for="" class="Modal_label">Social Media Url/ Website Url</label>
                <?= $form->field($model, 'website_url')->textInput()->label(false); ?>
            <?php } ?>

            <div class="d-flex align-items-center gap-2">
                <div class="selects w-100">
                    <label for="" class="Modal_label">Total Seat</label>
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
                    <label for="" class="Modal_label">Share Seats</label>
                    <?= $form->field($model, 'share_seat')->dropDownList(($model->share_seat) ? $model->getSharedseat() : [], ['prompt' => 'Share Seats', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12 ">
            <div class="creat-safri d-flex justify-content-end">
                <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <?= Html::submitButton('Create ', ['class' => 'safari_create font_set w-auto ms-2']) ?>

            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end() ?>
<?php

$script = <<< JS

          $("#sharedsafariform-start_date").on("change", function(){
          $("#sharedsafariform-end_date").attr("min", $(this).val());
          });
          
JS;
$this->registerJs($script);
?>