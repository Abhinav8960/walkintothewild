<?php

use common\models\GeneralModel;
use common\models\operator\SafariOperator;
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

    <div class="col-md-2">
        <?= $form->field($model, 'call_initiated_partner_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE])->all(),'id','business_name'),
            [
                'prompt' => 'Select Operator',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>