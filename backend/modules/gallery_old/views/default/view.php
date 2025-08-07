<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Collection ' . '(' . $partner_gallery_model->title . ')';
$this->params['title'] = $this->title;

$gallery = null;
if (!empty($partner_gallery_model->live_images)) {
    $gallery = json_decode($partner_gallery_model->live_images, true);
}

?>



<div class="card">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>

        <div class="row">
            <?php
            if ($partner_gallery_model && !empty($partner_gallery_model->live_images)) {
                $live_arr = json_decode($partner_gallery_model->live_images, true);
                if ($live_arr['images']) {
            ?>
                    <div class="col-lg-12 col-md-12">
                        <h5>Live Images</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Caption</th>
                                        <th>Gallery</th>
                                        <th>Set As <br>Thumbnail</br></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($live_arr['images'] as $index => $live) {  ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><?= isset($live['title']) ? $live['title'] : '' ?></td>
                                            <td><?= isset($live['caption']) ? $live['caption'] : '' ?></td>
                                            <td><img src="<?= isset($live['gallery_image_path']) ? $live['gallery_image_path'] : '' ?>" alt="Gallery" style="width:50px; height: 50px; text-align: center;"></td>
                                            <td>
                                                <?php
                                                if ($live['set_as_thumbnail']) {
                                                    if ($live['set_as_thumbnail'] == 1) { ?>
                                                        Yes
                                                    <?php } else { ?>
                                                        No
                                                <?php }
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php $count++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            <?php
                }
            } ?>

        </div>
    </div>
</div>


<div class="modal fade" id="rejectAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Gallery Rejection Remark
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='rejectContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.reject-popup').on('click', function () {
        $('#rejectAction').modal('show')
		.find('#rejectContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>