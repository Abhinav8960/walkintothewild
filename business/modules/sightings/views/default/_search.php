<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;

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
        <?php echo $form->field($model, 'description')->textInput(['placeholder' => 'Search by Name'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'location')->dropDownList(
            \yii\helpers\ArrayHelper::map(SafariPark::find()->orderby(['safari_park.title' => SORT_ASC])->all(), 'id', 'title'),
            [
                'prompt' => 'Select Park',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'master_animal_id')->dropDownList(
            GeneralModel::animalfilteroption(),
            [
                'prompt' => 'Select Animal',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'safari_session_id')->dropDownList(
            GeneralModel::safarisessionoption(),
            [
                'prompt' => 'Select Session',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::newstatusoption(),
            [
                'prompt' => 'Select Status',
            ]
        ) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
    $('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>