<?php

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\park\SafariPark;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'safari_operator_id')->dropDownList(
            SafariOperatorRatingSearch::getOperatorlist(),
            [
                'prompt' => 'Select Operator',
            ]
        ) ?>
    </div>
    <!-- <div class="col-md-2">
        <?= $form->field($model, 'flaged')->dropDownList(
            ['0' => 'Not Flaged', '1' => 'Flaged'],
            [
                'prompt' => 'Select Status of Flaged',
            ]
        ) ?>
    </div> -->
   
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