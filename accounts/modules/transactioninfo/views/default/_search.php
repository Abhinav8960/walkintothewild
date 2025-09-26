<?php

use common\models\GeneralModel;
use yii\widgets\ActiveForm;
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

<div class="row pb-4">
    <div class="col-12">
        <div class="d-flex align-items-center filter-areaParent w-100">
            <div class="">
                <div class="d-flex flex-wrap align-items-center gap-4">

                    <div class="">
                        <div class="filter-one d-flex gap-2">
                            <span>Start Date Range:</span>
                            <input type="date" placeholder="dd/mm/yyyy" id="visible_start_date" value="<?= $model->start_date_filter ?>">
                        </div>
                    </div>

                    <div class="">
                        <div class="filter-one d-flex gap-2">
                            <span>End Date Range:</span>
                            <input type="date" placeholder="dd/mm/yyyy" id="visible_end_date" value="<?= $model->end_date_filter ?>">
                        </div>
                    </div>

                    

                </div>

                <?= $form->field($model, 'start_date_filter')->hiddenInput(['id' => 'start_date_input', 'class' => 'form-control search-border'])->label(false); ?>
                <?= $form->field($model, 'end_date_filter')->hiddenInput(['id' => 'end_date_input', 'class' => 'form-control search-border'])->label(false); ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
$js = <<<JS
$('#visible_start_date, #visible_end_date').on('change', function() {
    $('#start_date_input').val($('#visible_start_date').val());
    $('#end_date_input').val($('#visible_end_date').val());
    $('#Searchform').submit();
});

JS;
$this->registerJs($js);
?>