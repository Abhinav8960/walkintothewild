<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="right-select">
    <div class="input_check pb-0 mb-3">
        <?php
        $sort_option = [1 => 'Created Recently', 2 => 'Less Safaris', 3 => 'More Safaris', 4 => 'Cheapest', 5 => 'Date of occurrence:  Earlier to later', 6 => 'Date of occurrence: Later to earlier'];
        ?>
        <div class="form-group field-sharesafarisearch-custom_sort_by">
            <select id="sharesafarisearch-custom_sort_by" class="form-control custom_sort_by_input" name="ShareSafariSearch[custom_sort_by]">
                <option style="display:none;" selected value="">Sort by : <?= isset($sort_option[$searchModel->custom_sort_by]) ? $sort_option[$searchModel->custom_sort_by] : 'Created Recently' ?></option>
                <option value="1" class="<?= $searchModel->custom_sort_by == 1 ? 'selected' : '' ?>">Created Recently</option>
                <option value="2" class="<?= $searchModel->custom_sort_by == 2 ? 'selected' : '' ?>">Less Safaris</option>
                <option value="3" class="<?= $searchModel->custom_sort_by == 3 ? 'selected' : '' ?>">More Safaris</option>
                <option value="4" class="<?= $searchModel->custom_sort_by == 4 ? 'selected' : '' ?>">Cheapest</option>
                <option value="5" class="<?= $searchModel->custom_sort_by == 5 ? 'selected' : '' ?>">Date of occurrence: Earlier to later</option>
                <option value="6" class="<?= $searchModel->custom_sort_by == 6 ? 'selected' : '' ?>">Date of occurrence: Later to earlier</option>
            </select>
        </div>
    </div>
</div>