<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'type')->dropDownList(
            [
                '2' => 'Video',
                '3' => 'Image',
            ],
            [
                'prompt' => 'Select Type',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'is_api_failed')->dropDownList(
            [
                '1' => 'Yes',
                '0' => 'No',
            ],
            [
                'prompt' => 'Is Api Failed',
            ]
        ) ?>
    </div>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>