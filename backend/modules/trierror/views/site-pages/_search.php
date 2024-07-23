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
        <div class="col-md-6">
            <?= $form->field($model, 'url')->textInput(["placeholder" => "Search by url"]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'content_type')->dropDownList(
            $content_type,
            [
                'prompt' => 'Select Content Type',
            ]
        ) ?>
        </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
        
    </div>
</div>
<?php ActiveForm::end(); ?>