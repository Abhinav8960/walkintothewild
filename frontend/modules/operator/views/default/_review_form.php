<?php

use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="modal-body modal_form">
    <?php $form = ActiveForm::begin(['id' => 'review-form']); ?>
    <div class="row">
        <div class="col-12 mb-2">
            <label for="" class="label_modal">Where did you go?</label>
            <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($operator_id), ['prompt' => 'Select a Safari park', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
        <div class="col-12 my-4">
            <div class="stars d-flex gap-4 justify-content-center">
                <?= $form->field($model, 'rating')->hiddenInput()->label(''); ?>
                <div class="stars d-flex gap-4 justify-content-center">
                    <i class="fa-regular fa-star star_icon_1" value='1'></i>
                    <i class="fa-regular fa-star star_icon_2" value='2'></i>
                    <i class="fa-regular fa-star star_icon_3" value='3'></i>
                    <i class="fa-regular fa-star star_icon_4" value='4'></i>
                    <i class="fa-regular fa-star star_icon_5" value='5'></i>
                </div>
            </div>

        </div>
        <div class="col-lg-12 mb-2 ">
            <div class="textarea">
                <?= $form->field($model, 'review')->textarea(['placeholder' => 'Write your review', 'class' => 'form-control', 'maxlength' => true])->label(false); ?>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="submir_review">
                <?= Html::submitButton('Submit Review', ['name' => 'submit-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

<?php
$script = <<<JS
    $(document).ready(function() {  
        $(".star_icon_1").click(function() { 
            $(".fa-star").css("color", "black"); 
            $(".star_icon_1").css("color", "#fdbf2b");  
            var selected_value = $(this).attr('value');
            $('#safarioperatorreviewform-rating').val(selected_value);
        });  
        $(".star_icon_2").click(function() {   
            $(".fa-star").css("color", "black");
            $(".star_icon_1,.star_icon_2").css("color", "#fdbf2b");  
            var selected_value = $(this).attr('value');
            $('#safarioperatorreviewform-rating').val(selected_value);
        });  
        $(".star_icon_3").click(function() {   
            $(".fa-star").css("color", "black");
            $(".star_icon_1,.star_icon_2,.star_icon_3").css("color", "#fdbf2b");  
            var selected_value = $(this).attr('value');
            $('#safarioperatorreviewform-rating').val(selected_value);
        });   
        $(".star_icon_4").click(function() {   
            $(".fa-star").css("color", "black");
            $(".star_icon_1,.star_icon_2,.star_icon_3,.star_icon_4").css("color", "#fdbf2b");  
            var selected_value = $(this).attr('value');
            $('#safarioperatorreviewform-rating').val(selected_value);
        });  
        $(".star_icon_5").click(function() {   
            $(".fa-star").css("color", "black");
            $(".star_icon_1,.star_icon_2,.star_icon_3,.star_icon_4,.star_icon_5").css("color", "#fdbf2b");  
            var selected_value = $(this).attr('value');
            $('#safarioperatorreviewform-rating').val(selected_value);
        });  
    });  
JS;
$this->registerJs($script);
?>