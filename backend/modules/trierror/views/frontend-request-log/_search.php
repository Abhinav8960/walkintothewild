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
            <?= $form->field($model, 'user_id')->dropDownList(
            yii\helpers\ArrayHelper::map(common\models\User::find()->orderBy('name', 'asc')->all(), 'id', 'name'),
            [
                'prompt' => 'Select User',
            ]
        ) ?>
        </div><?php /*
        <div class="col-md-3">
            <?= $form->field($model, 'route') ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'request_code') ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'request_code') ?>
        </div> */ ?>
    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>