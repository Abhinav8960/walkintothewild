<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="right-select">
    <div class="input_check pb-0 mb-3">
        <?= $form->field($searchModel, 'custom_sort_by')->dropDownlist(
            [
                '1' => 'Short by : Created Recently',
                '2' => 'Short by : Less Safaris',
                '3' => 'Short by : More Safaris',
                '4' => 'Short by : Cheapest',


            ],

        )->label(false); ?>
    </div>
</div>


<?php

// $script = <<< JS

//     $('form').on('change', function(){
//         $("#side-search-form").attr("data-pjax", "true");    
//         $(this).closest('form').submit();

//     }); 
// JS;
// $this->registerJs($script);
?>