<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\sharesafari\ShareSafari $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'custom_sort_by_form'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<div class="right-select">
    <div class="input_check pb-0 mb-3">
        <?= $form->field($searchModel, 'custom_sort_by')->dropDownlist(
            [
                // '1' => 'Created Recently',
                '2' => 'Less Safaris',
                '3' => 'More Safaris',
                '4' => 'Cheapest',


            ],['prompt'=>'Sort By : Created Recently']
        )->label(false); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

// $script = <<< JS

//     $('form').on('change', function(){
//         $("#side-search-form").attr("data-pjax", "true");    
//         $(this).closest('form').submit();

//     }); 
// JS;
// $this->registerJs($script);
?>