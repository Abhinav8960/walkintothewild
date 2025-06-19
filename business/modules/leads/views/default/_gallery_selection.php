<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php if ($dataProvider->getCount() > 0) { ?>
    <?php $form = ActiveForm::begin([
        'id' => 'gallery-selection-form',
        'options' => ['class' => 'gallery-form'],
    ]); ?>

    <div class="gallery-container row">
        <?php foreach ($dataProvider->getModels() as $gallery) { ?>
            <div class="col-md-3 mb-3">
                <div class="gallery-item border rounded p-2 text-center" data-slug="<?= $gallery->slug ?>" style="cursor:pointer;">
                    <img src="<?= $gallery->thumbnail ?>" alt="<?= $gallery->title ?>" class="img-fluid">
                    <div class="mt-2"><?= $gallery->title ?></div>
                </div>
            </div>
        <?php } ?>
    </div>


    <?= $form->field($gallery_selection_model, 'gallery_slug')->hiddenInput(['id' => 'selected-gallery-slug'])->label(false) ?>
    <div class="col-2">
        <div class="santBtn">
            <?= Html::submitButton('Send Gallery') ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
<?php } else { ?>
    No Gallery Found
<?php } ?>

<?php
$js = <<<JS
$('.gallery-item').on('click', function() {
    $('.gallery-item').removeClass('selected border-primary');
    $(this).addClass('selected border-primary');
    
    var slug = $(this).data('slug');
    $('#selected-gallery-slug').val(slug);
});
JS;
$this->registerJs($js);
?>


<style>
    .gallery-item.selected {
        border: 2px solid #007bff;
        background-color: #eef5ff;
    }

    .santBtn button {
        border: 1px solid #000;
        padding: 8px 20px;
        background-color: #09422d;
        border-radius: 4px;
        color: #fff;
    }
</style>