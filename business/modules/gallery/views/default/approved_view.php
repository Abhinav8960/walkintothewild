<?php

use common\models\partnergallery\PartnerGallery;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$gallery = null;
if (!empty($partner_gallery_model->live_images)) {
    $gallery = json_decode($partner_gallery_model->live_images, true);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="galleryViewMain-parent d-flex justify-content-between align-items-center">
                <div class="gallary-title">
                    <p>Gallery View</p>
                </div>
                <div class="selectandsearchmain d-flex align-items-center gap-4">

                </div>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="details-packages">
                <div class="topHeader d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="date-or-time">
                        <p class="mb-1">Title</p>
                        <p class="mb-0"><?= $partner_gallery_model->title ?></p>
                    </div>
                    <div class="date-or-time">
                        <p class="mb-1">Park</p>
                        <p class="mb-0"><?= isset($partner_gallery_model->park) ? $partner_gallery_model->park->title : '' ?></p>
                    </div>

                    <div class="active-btn approve-inner-butn">
                        <a href="">Approve</a>
                    </div>

                </div>
                <div class="d-flex">
                    <table class="table w-50 border-0 border_o d-inline-block py-3">
                        <tbody class="tbody-leads sighting-leads py-5 w-100">
                            <tr>
                                <td style="width: 25%;">Created Date:</td>
                                <td style="width: 75%;">
                                    <p><?= date('j F Y, g:i A', $partner_gallery_model->created_at) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>Updated Date:</td>
                                <td>
                                    <p><?= date('j F Y, g:i A', $partner_gallery_model->updated_at) ?></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <?php
        if (is_array($gallery)) {
            if (isset($gallery['images'])) {

                foreach ($gallery['images'] as $image) {
        ?>
                    <div class="col-xxl-3 col-xl-3 col-lg-4 md-6 col-12 mb-3">
                        <div class="galleryCard">
                            <div class="card p-0 border-0 bg-transparent">
                                <div class="position-relative">
                                    <img src="<?= $image['gallery_image_path'] ?>"
                                        class="card-img-top" alt="<?= $image['title'] ?>">


                                </div>
                                <div class="card-body fancy-box-body">
                                    <p class="mb-2"><?= $image['title'] ?></p>
                                    <p><?= $image['caption'] ?></p>
                                </div>
                            </div>
                        </div>

                    </div>
        <?php
                }
            }
        }
        ?>

    </div>
</div>