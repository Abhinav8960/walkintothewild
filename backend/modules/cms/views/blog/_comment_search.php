<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;

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
        <?= $form->field($model, 'comment')->textInput(['placeholder' => 'Search by Comment'])->label(false) ?>
    </div>
    <!-- <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::commentstatusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div> -->
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>