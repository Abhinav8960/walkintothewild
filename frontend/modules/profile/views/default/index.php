<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Profile';
$this->params['title'] = $this->title;
?>


<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    <div class="row">
        <div class="col-8">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <h6>About</h6>
                    <?php if ($user->about) { ?>
                        <p><?= $user->about ?></p>
                    <?php } ?>
                    <h6>Social Media</h6>
                    <?php if ($user->facebook_url) { ?>
                        <a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                        <p><?= $user->facebook_url; ?></p>
                    <?php } ?>
                    <?php if ($user->whatsapp_url) { ?>
                        <a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                        <p><?= $user->whatsapp_url; ?></p>
                    <?php } ?>
                    <?php if ($user->x_url) { ?>
                        <a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                        <p><?= $user->x_url; ?></p>
                    <?php } ?>
                    <?php if ($user->insta_url) { ?>
                        <a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                        <p><?= $user->insta_url; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mt-2">
                <div class="card-body">
                    <h5>Following</h5>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Share Safari Experience</h5>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Instagram</h5>
                </div>
            </div>
        </div>
        <div class="col-8">
        </div>
        <div class="col-4">
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Shared Safari</h5>
                    <div class="col-6 mb-4 padding_righ">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">

                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="#"><img src="<?= $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                            </div>
                            <div class="card_body">
                                <div class="top_seats">
                                    <div class="safari d-flex justify-content-between ">
                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                            <p class="text_safari">SAFARI</p>

                                        </div>
                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                            <p class="text_safari">SEATS</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="titleDate">

                                </div>
                                <div class="footer_card row pb-2 px-2 align-items-center">
                                    <div class="col-6">

                                    </div>
                                    <div class="col-6">
                                        <div class="safari text-center">
                                            <div class="joinsafari">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>