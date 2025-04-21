<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>


<?php $form = ActiveForm::begin([
    'id' => 'fixed-departure-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>



        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'getting_there')->textarea(['rows' => '2', 'placeholder' => 'How to reach'])->label('Share Safari Getting There', ['class' => 'Modal_label']) ?>
            </div>
        </div>
     
        <div class="row">
            <div class="col-md-12">
            <div class="creat-safri d-flex justify-content-end ">
                    <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                </div>
            </div>
        </div>

<?php ActiveForm::end(); ?>

<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
bulleteditor('createdepartureform-getting_there');
JS;
$this->registerJs($script);
?>