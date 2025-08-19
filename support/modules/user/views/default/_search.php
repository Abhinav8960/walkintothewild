<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'user-search-form'
    ],
    'method' => 'post',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <?php if (false) { ?>
        <div class="col-md-2">
            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Search by Login ID'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Search by Email'])->label(false) ?>
        </div>
    <?php } ?>



    <div class="col-12 mb-3">
        <div class="filterBar bg-transparent">
            <div class="filters">
                <div class="filterItem position-relative">
                    <label>User:</label>
                    <?= $form->field($model, 'id')->widget(Select2::class, [
                        'initValueText' => $model->id ? GeneralModel::name_with_email($model->id) : '',
                        'options' => ['placeholder' => 'Select User', 'multiple' => false],
                        'pluginOptions' => [
                            'width' => '300px',
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'containerCssClass' => 'custom-select2', //adding custom css to select2 wigdet 
                            'ajax' => [
                                'url' => \yii\helpers\Url::toRoute(['user-list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        ],
                    ]); ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Verified Mobile:</label>
                    <?= $form->field($model, 'is_mobile_no_verified')->dropDownList(
                        GeneralModel::mobileVerfied(),
                        [
                            'prompt' => 'Select by Verified Mobile',
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>


                <div class="filterItem position-relative">
                    <label>Status:</label>
                    <?= $form->field($model, 'status')->dropDownList(['10' => 'Active', '9' => 'Inactive'], ['placeholder' => 'Search by Status'])->label(false) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$searchjs = <<<JS
$('#user-search-form').on('change', function() {
    $(this).submit();
});
JS;
$this->registerJs($searchjs);
?>



<style>
    .custom-select2 {
    border: none !important;
    outline: none !important;
    background: transparent !important;
    font-weight: 700 !important;
    color: #44444F !important;
    cursor: pointer !important;
    padding: 4px 50px 4px 8px !important;
    font-size: 16px !important;
}
.custom-select2 .select2-selection__placeholder {
    color: #44444F !important;
    font-weight: 600 !important;
    font-size: 16px !important;
}


</style>