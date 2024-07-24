<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Photo';
$this->params['title'] = $this->title;
?>

<div class="container mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['photo' => 'active', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h5>Photos</h5>
                                <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                    <button class="join_btn photoBtn text-center mt-sm-0 mt-2" value="<?= Url::toRoute(['/profile/photo/create']) ?>">Add photo</button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-6">
                            No Photo added!
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade _standard-text" id="package-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Photo</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function organizefunction() {
	$('.photoBtn').on('click', function () {
        $('#package-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
             
JS;
$this->registerJs($script);
?>