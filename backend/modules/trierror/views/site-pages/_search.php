<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'url')->textInput(["placeholder" => "Search by url"]) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'category')->dropDownList(
            $content_type,
            [
                'prompt' => 'Select Category',
                'onchange' => '$.get("' . Yii::$app->urlManager->createUrl('/trierror/site-pages/getsubcategorylist?category_id=') . '"+$(this).val(), function( data ) {
                    $( "select#searchsitepages-sub_category" ).html( data );
                })'
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'sub_category')->dropDownList(
            GeneralModel::getsitepagessubcategory($model->category),
            [
                'prompt' => 'Select Sub-Category',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'url_type')->dropDownList(
            ['Primary' => 'Primary', 'Secondary' => 'Secondary'],
            [
                'prompt' => 'Select Type',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'og_tag_type')->dropDownList(
            ['no_title' => 'No Title', 'no_description' => 'No Description', 'no_keywords' => 'No Keywords', 'no_image' => 'No Image'],
            [
                'prompt' => 'Select OG Tags',
            ]
        ) ?>
    </div>

    <div class="col-md-1">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>

    </div>
</div>
<?php ActiveForm::end(); ?>