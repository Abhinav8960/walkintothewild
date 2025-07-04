<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Gallery Collection';
?>



<div class="container-fluid">
    <div class="row">
        <?php if ($dataProvider) {
            foreach ($dataProvider->getModels() as $model) { ?>
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-6 mb-3">
                    <div class="galleryCard">
                        <div class="card p-0 border-0 bg-transparent">
                            <div class="position-relative">
                                <img src="<?= $model->gallery_image ?>"
                                    class="card-img-top" alt="">
                                <!-- <div class="dropdown-wrapper" tabindex="0">
                                        <a href="#" class="dot-icon">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <p>Edit</p>
                                            <p>Delete</p>

                                        </div>
                                    </div> -->

                            </div>
                            <div class="card-body">
                                <p class="mb-0"><?= $model->title ?></p>
                                <p class="mb-0" style="color:#848A90"><?= $model->caption ?></p>
                            </div>
                        </div>
                    </div>

                </div>
        <?php }
        } ?>
    </div>
</div>