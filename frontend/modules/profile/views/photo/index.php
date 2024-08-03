<?php

use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Photo';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['photo' => 'active', 'user' => $user]) ?>

    </div>
</section>
<section>
    <div class="container ">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
                <div class="row justify-content-center ">
                    <div class="col-xxl-11 margin_bottomfooter">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card  mb-4 card_bodyPadding">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Shared Photos</h6>
                                                    <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                                        <button class="follow_btn photoBtn text-center mt-sm-0 " value="<?= Url::toRoute(['/profile/photo/create']) ?>">+ Add photo</button>
                                                    <?php } ?>
                                                </div>
                                                <div class="tab-content_tour active">
                                                    <div class="row">
                                                        <?php
                                                        if ($userposts) {
                                                            foreach ($userposts as $userpost) {
                                                        ?>
                                                                <div class="col-md-6 col-lg-4 gap-2  mb-2">
                                                                    <div class="parksImgireview h-100 position-relative">
                                                                        <div class="floating-watchlist">
                                                                            <?php
                                                                            if (Yii::$app->user->identity) {
                                                                                if (Yii::$app->user->identity->id == $userpost->user_id) { ?>
                                                                                    <div class="heart_bx">
                                                                                        <?= Html::a('<i class="fa-solid fa-trash"></i>', ['delete', 'id' => $userpost->id], [
                                                                                            'class' => 'btn btn-danger',
                                                                                            'data' => [
                                                                                                'confirm' => 'Are you sure you want to delete this photo?',
                                                                                                'method' => 'post',
                                                                                            ],
                                                                                        ]) ?>
                                                                                    </div>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                        <img src="<?= isset($userpost->file) ? $userpost->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                                                        <div class="footer_safariname">
                                                                            <h6 class=""><?= $userpost->caption ?></h6>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            <?php }
                                                        } else { ?>
                                                            <div class="col-6">
                                                                No Photo added!
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <?= $this->render('@frontend/modules/profile/views/default/_following_card', ['user' => $user]) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>




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