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
                        <!-- <input type="search" placeholder="Search" />
                        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a> -->
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <!-- <a href="" class="sequenceBtn">set sequence</a> -->
                        <!-- <div class="filter-areaParent">
                                <div class="shortList-wrapper">
                                    <div class="shortList d-flex gap-5 align-items-center border">
                                        <span>Sort</span>
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="shortList-dropdown dropdown">
                                        <p>Created Recently</p>
                                        <p>Most Images</p>
                                        <p>Popularity</p>
                                    </div>
                                </div>
                            </div> -->
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
                                    <div class="dropdown-wrapper" tabindex="0">
                                        <a href="#" class="dot-icon">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <p>Edit</p>
                                            <p>Delete</p>

                                        </div>
                                    </div>
                                    <div class="approve-btn not-approve-btn">
                                        <button type="btn">Approve</button>
                                    </div>
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <p class="mb-0"><?= $model->title ?></p>
                                    <p class="mb-0"><?= $model->title ?></p>
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


JS;
$this->registerJs($script);

?>