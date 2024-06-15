<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card">
    <div class="card-body">
        <h5>Basic Detail</h5>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title']) ?>
            </div>


            <div class="col-md-12">
                <?= $form->field($model, 'short_description')->textarea(['maxlength' => true, 'placeholder' => 'Enter featured description']) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 4],
                    'preset' => 'full',

                ]) ?>
            </div>


            <div class="col-md-3">
                <?= $form->field($model, 'avg_safari_price_min')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price Min'])->label('Average Safri Cost (Min)') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'avg_safari_price_max')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price Max'])->label('Average Safri Cost (Max)') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'safri_cost_note')->textInput(['maxlength' => true, 'placeholder' => 'Enter Safari Cost Note']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'official_website')->textInput(['maxlength' => true, 'placeholder' => 'Enter Offical Website']) ?>
            </div>

            <div class="col-md-3 select_width">
                <?= $form->field($model, 'master_bonus_experience_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::bonusexperienceoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Bonus Experience') ?>
            </div>
            <div class="col-md-3 select_width">
                <?= $form->field($model, 'accomodation')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::accomodationoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Accomodation') ?>
            </div>
            <div class="col-md-3 select_width">
                <?= $form->field($model, 'safari_session')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::safarisessionoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Safari Session') ?>
            </div>
            <div class="col-md-3 select_width">
                <?= $form->field($model, 'month')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::monthoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Month') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'month_note')->textInput(['maxlength' => true, 'placeholder' => 'Enter Month Note']) ?>
            </div>


            <div class="col-md-3 select_width">
                <?= $form->field($model, 'vehicle_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::vehicleoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select Vehicles', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-md-3 select_width">
                <?= $form->field($model, 'master_animal_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::animaloption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select Animal', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-md-3 select_width">
                <?= $form->field($model, 'master_rare_animal_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::rareanimaloption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select Rare Animal', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'animal_text')->textarea(['maxlength' => true, 'placeholder' => 'Enter Animals']) ?>
            </div>
        </div>
        <hr>

        <h5>Address</h5>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'state_id', ['inputOptions' => ['id' => 'state']])->dropDownList(
                    GeneralModel::getAllState(1),
                    [
                        'prompt' => 'Select State',
                        'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getcity?master_state_id=') . '"+$(this).val(), function( data ) {
                    $( "select#city" ).html( data );
                    })'
                    ]
                ); ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'city_id', ['inputOptions' => ['id' => 'city']])->dropDownList(
                    GeneralModel::getAllCity($model->state_id),
                    [
                        'prompt' => 'Select City',
                    ]
                ); ?>


            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'master_location_id', ['inputOptions' => ['id' => 'location']])->dropDownList(GeneralModel::getAllLocation(), ['prompt' => 'Select Location'])->label('Location') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'pincode')->textInput(['maxlength' => true, 'placeholder' => 'Enter Pincode']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Latitude']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Longitude']) ?>
            </div>

        </div>
        <hr>

        <h5>About Park</h5>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'about_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter About Title']) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'about_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 4],
                    'preset' => 'full',

                ]) ?>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <?php if ($model->safari_park_model->id) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
                </div>

            <?php } ?>

            <?php

            echo Html::a('<img src="/img/red_delete.png" alt="" style="width:25px;">', ['/park/safari/default/delete', 'id' => $model->safari_park_model->id], [
                'class' => 'btn btn-sm p-0 change-menuicon  col-md-2 float-end mb-3',
                'title' => 'Delete',
                'data' => [
                    'confirm' => 'Are you sure you want to delete ' . $model->safari_park_model->title . '?',
                    'method' => 'post',
                ],
            ]); ?>
        </div>


        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<style>
    .select_width .select2.select2-container {

        width: 100% !important;
        display: block !important;
    }
</style>