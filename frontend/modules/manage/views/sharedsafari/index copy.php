<?php

use yii\helpers\Url;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 ms-auto">
                            <button class="btn_newsafari departureBtn" value="<?= \yii\helpers\Url::toRoute(['create-fixed-departure']) ?>">+ Create Fixed Departure </button>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($fixed_safari as $safari) { ?>
                            <div class="col-4">

                                <div class="sharesafri-card mt-4">
                                    <div class="flotingdate">
                                        <div class="icons text-center">
                                            <p class="mb-0"><?= date('M', strtotime($safari->start_date)) ?></p>
                                            <p class="mb-0"><?= date('d', strtotime($safari->start_date)) ?></p>
                                        </div>
                                    </div>
                                    <div class="shareimg">
                                        <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $safari->slug]) ?>"><img src="<?= $safari->sharedimagepath ? $safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                    </div>
                                    <div class="card_body">
                                        <div class="top_seats">
                                            <div class="safari d-flex justify-content-between ">
                                                <div class="safarinum d-flex gap-2 align-items-center ">
                                                    <p class="text_safari">SAFARI</p>
                                                    <h6 class="number-safari"><?= $safari->no_of_safari ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="titleDate">
                                            <button class="btn btn-info btn-sm departureBtn" value="<?= \yii\helpers\Url::toRoute(['update-fixed-departure', 'slug' => $safari->slug]) ?>">Update</button>
                                            <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $safari->slug]) ?>"><?= $safari->park->title ?></a></h6>
                                            <div class="orgnizer">
                                                <p>Organized by: <strong><?= $safari->safarioperator->business_name ?></strong></p>
                                            </div>
                                        </div>
                                        <div class="footer_card row pb-2 px-2 align-items-center">
                                            <div class="col-6">
                                                <div class="users">
                                                    <?php if ($interests = $safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                        $count = $safari->getIntrested()->count();
                                                        $avatar_count = 3;
                                                        foreach ($interests as $interest) {
                                                    ?>
                                                            <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                        <?php
                                                        };
                                                        $count = $safari->getIntrested()->count();
                                                        $avatar_count = 3;
                                                        $data = $count - $avatar_count;
                                                        if ($data > 3) {  ?>
                                                            <div class="roundes_countuser">
                                                                <?= $data ?>+
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <img src="<?= $safari->user && $safari->user->avatar <> '' ? $safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="departure-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Organize a New Fixed Departure</h1>
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

function departurefunction() {
	$('.departureBtn').on('click', function () {
        $('#departure-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
departurefunction();
             
JS;
$this->registerJs($script);
?>