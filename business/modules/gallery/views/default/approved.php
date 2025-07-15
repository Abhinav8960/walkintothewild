<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Gallery';
?>


<div class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="selectandsearchmain d-flex justify-content-between align-items-center">
                    <div class="search-here position-relative">
                        <div class="topnav float-start">
                            <a class="<?= isset($approved_active) ? 'active' : '' ?>" href="<?= Url::toRoute(['approved']) ?>">Approved</a>
                            <a class="<?= isset($draft_active) ? 'active' : '' ?>" href="<?= Url::toRoute(['index']) ?>">In Draft</a>
                            <a class="<?= isset($pending_active) ? 'active' : '' ?>" href="<?= Url::toRoute(['pending-for-approval']) ?>">Pending For Approval</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <?= $this->render('_search', ['model' => $searchModel]) ?>
                        <button class="button-created new createAction" value="<?= Url::toRoute(['create']) ?>">Create</button>
                    </div>
                </div>
            </div>
            <?php if ($dataProvider) {
                foreach ($dataProvider->getModels() as $model) { ?>
                    <div class="col-xxl-3 col-xl-3 col-lg-4 md-6 col-12 mb-3">
                        <div class="galleryCard">
                            <div class="card p-0 border-0 bg-transparent">
                                <div class="position-relative">
                                    <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>"> <img src="<?= $model->thumbnail ?>"
                                            class="card-img-top" alt=""></a>
                                    <?php if ($model->in_draft == 1) { ?>
                                        <div class="dropdown-wrapper" tabindex="0">
                                            <a href="#" class="dot-icon">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <p>
                                                    <button value="<?= Url::toRoute(['edit-gallery', 'id' => $model->id]) ?>" class="galleryParetnAction">Edit</button>
                                                </p>
                                                <p>
                                                    <a href="<?= Url::toRoute(['gallery-delete', 'id' => $model->id]) ?>">Delete</a>
                                                </p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="approve-btn not-approve-btn approveBtn">
                                        <button type="btn">Approve</button>
                                    </div>


                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <p class="mb-0"><?= $model->title ?></p>
                                    <p class="mb-0"><?= $model->gallery_count ?></p>
                                </div>

                            </div>
                        </div>

                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>


<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
        <div class=" modal-content">
        <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
            <p class="" id="">Create Gallery</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 pb-4 pt-0">
            <div id='modalContent' class="row"></div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="editparentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
        <div class=" modal-content">
        <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
            <p class="" id="">Edit Gallery</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 py-4" id='modalContent'>
        </div>
    </div>
</div>
</div>


<?php
$script = <<< JS


    $('.createAction').on('click', function () {
        $('#exampleModal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

     $('.quotation-button').on('click', function () {
        $('#quotationAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

      $('.galleryParetnAction').on('click', function () {
        $('#editparentModal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});


JS;
$this->registerJs($script);

?>

<style>
    .topnav {
        overflow: hidden;
        background-color: #333;
    }

    .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        background-color: #04AA6D;
        color: white;
    }
</style>