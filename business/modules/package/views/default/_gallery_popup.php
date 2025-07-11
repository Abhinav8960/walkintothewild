<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$partner_gallery_id = $_REQUEST['partner_gallery_id'] ?? null;
?>



<div class="container-fluid mt-2">
    <div class="row">
        <?php if ($dataProvider) {
            foreach ($dataProvider->getModels() as $model) { ?>
                <div class="col-xxl-3 col-xl-3 col-lg-4 md-6 col-12 mb-3">
                    <div class="galleryCard <?= $partner_gallery_id == $model->id ? 'selected' : '' ?>" data-id="<?= $model->id ?>" data-src="<?= $model->thumbnail ?>">
                        <div class="card p-0 border-0 bg-transparent">
                            <div class="position-relative">
                                <img src="<?= $model->thumbnail ?>"
                                    class="card-img-top" alt="">


                            </div>
                            <div class="card-body">
                                <p class="mb-0"><?= $model->title ?></p>

                            </div>
                        </div>
                    </div>

                </div>
        <?php }
        } ?>
    </div>
</div>



<?php
$context = json_encode($context); // safely encode PHP variable for JS
$preview = json_encode($preview); // safely encode PHP variable for JS

$script = <<< JS
    $(document).on('click', '.galleryCard', function() {
        var contxt = $context;
        var preview = $preview;
        const isSelected = $(this).hasClass('selected');
        $('.galleryCard').removeClass('selected');
        if (!isSelected) {
            $(this).addClass('selected');
            const id = $(this).data('id');
            const thumbnail = $(this).data('src');
            $('#' + contxt).val(id);
            $('#' + preview).attr('src', thumbnail);
             $('#' + preview).closest('.galleryModal').find('.fadeImage').show();
        } else {
            $('#' + contxt).val('');
            $('#' + preview).attr('src', '');
            $('#' + preview).closest('.galleryModal').find('.fadeImage').hide();

        }
    });
JS;
$this->registerJs($script);
?>

<style>
    .galleryCard.selected {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.8);
        border-radius: 4px;
    }
</style>