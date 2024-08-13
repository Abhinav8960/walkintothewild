<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="right-select">
    <div class="input_check pb-0 mb-3">
        <div class="form-group field-packagesearch-custom_sort_by">
            <?php
            $sort_option = [1 => 'Created Recently', 2 => 'Less Safaris', 3 => 'More Safaris', 4 => 'Cheapest'];
            ?>
            <select id="packagesearch-custom_sort_by" class="form-control" name="PackageSearch[custom_sort_by]">
                <option style="display:none;" selected value="">Sort by : <?= isset($sort_option[$searchModel->custom_sort_by]) ? $sort_option[$searchModel->custom_sort_by] : 'Created Recently' ?></option>
                <option value="1" class="<?= $searchModel->custom_sort_by == 1 ? 'selected' : '' ?>">Created Recently</option>
                <option value="2" class="<?= $searchModel->custom_sort_by == 2 ? 'selected' : '' ?>">Less Safaris</option>
                <option value="3" class="<?= $searchModel->custom_sort_by == 3 ? 'selected' : '' ?>">More Safaris</option>
                <option value="4" class="<?= $searchModel->custom_sort_by == 4 ? 'selected' : '' ?>">Cheapest</option>
            </select>
        </div>
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