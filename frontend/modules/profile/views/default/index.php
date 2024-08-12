<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = $user->name . ' | Profile';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>

    </div>
</section>

<section class="ta">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card card_bodyPadding  mb-4">
                            <div class="card-body">
                                <h6>About</h6>
                                <?php if ($user->about) { ?>
                                    <p><?= $user->about ?></p>
                                <?php } ?>
                                <h6>Social Media</h6>
                                <?php if ($user->facebook_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-facebook-f me-1"></i></a>
                                        <p>Facebook
                                            <span> <a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><?= $user->facebook_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->whatsapp_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-whatsapp me-1"></i></a>
                                        <p>Whatsapp
                                            <span> <a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><?= $user->whatsapp_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->x_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-x-twitter me-1"></i></a>
                                        <p>Twitter
                                            <span> <a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><?= $user->x_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->insta_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-instagram me-1"></i></a>
                                        <p>Instagram
                                            <span><a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"> <?= $user->insta_url; ?></a></span>
                                        </p>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>

                        <div class="card  mb-4 card_bodyPadding">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
                                            <h6 class="fs-6 fw-bold" style="padding-bottom: 0 !important;">Park Visited</h6>
                                            <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) { ?>
                                                <button class="parkrevieBtn photoBtn text-center mt-sm-0 mt-2 " value="<?= Url::toRoute(['/profile/user-experience']) ?>">+ Add Experience</button>
                                            <?php } ?>
                                        </div>
                                        <div class="tab-content_tour active">
                                            <div class="row">
                                                <?php
                                                if ($user_experiences) {
                                                    foreach ($user_experiences as $user_experience) {
                                                ?>
                                                        <div class="col-md-4 col-sm-6 col-lg-4 gap-2 mt-2 mb-2">
                                                            <div class="parksImgireview h-100 position-relative">
                                                                <div class="floating-watchlist">
                                                                    <?php
                                                                    if (Yii::$app->user->identity) {
                                                                        if (Yii::$app->user->identity->id == $user_experience->user_id) { ?>
                                                                            <div class="heart_bx">
                                                                                <?= Html::a('<i class="fa-solid fa-trash"></i>', ['delete', 'id' => $user_experience->id], [
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
                                                                <img src="<?= isset($user_experience->file) ? $user_experience->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                                                <div class="footer_safariname">
                                                                    <h6 class=""><?= isset(GeneralModel::safariparkoption()[$user_experience->park_id]) ? GeneralModel::safariparkoption()[$user_experience->park_id] : '' ?></h6>
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
                    <div class="col-xl-4 ">
                        <?= $this->render('_following_card', ['user' => $user]) ?>
                        <?= $this->render('_instagram', ['user' => $user]) ?>
                        <?= $this->render('_organized_shared_safari', ['user' => $user]) ?>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Feature Your Visited Parks</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body p-3">
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