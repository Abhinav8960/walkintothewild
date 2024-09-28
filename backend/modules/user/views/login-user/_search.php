<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserSession;
use common\models\GeneralModel;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimalSearch $model */
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
        <?= $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(UserSession::find()->joinwith(['user'])->orderby(['name' => SORT_ASC])->all(), 'user_id', 'user.name'), ['prompt' => 'Select User'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'app_name')->dropDownList(['Frontend' => 'Frontend', 'Backend' => 'Backend'], ['prompt' => 'Select Application'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>