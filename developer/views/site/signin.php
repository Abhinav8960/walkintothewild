<?php

use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

FrontAppAsset::register($this);
AppAsset::register($this);
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Developer Portal Sign in | Walk Into the Wild';
$this->params['title'] = $this->title;
?>
<div class="modal fade _standard-text mobile_loginconditions show" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180px" class="logo">
                </h1>
            </div>
            <div class="modal-body px-5">
                <div class="row py-4">
                    <div class="col-12 logindesign">
                        <div class="content_terms">
                            <h5 class="text-center">Developer Portal Login</h5>
                            <div class="btnssss-g pt-3" style="border:none;">
                                <?php if (!empty($_REQUEST['referrer'])) {
                                    $authAuthChoice = AuthChoice::begin([
                                        'baseAuthUrl' => [
                                            'site/auth',
                                            'referrer' => $_REQUEST['referrer']
                                        ],
                                        'popupMode' => false,
                                    ]);
                                } else {
                                    $authAuthChoice = AuthChoice::begin([
                                        'baseAuthUrl' => [
                                            'site/auth'
                                        ],
                                        'popupMode' => false,
                                    ]);
                                } ?>
                                <?php foreach ($authAuthChoice->getClients() as $client) { ?>
                                    <?= $authAuthChoice->clientLink(
                                        $client,
                                        '<button class="googlelogin w-100 py-2 px-5 mb-3 d-flex align-items-center gap-2"> <img src="' . $this->params['baseurl'] . '/img/google-logo.5867462c.svg" width="25" alt="banner">Continue with Google</button>',
                                    ) ?>
                                <?php } ?>
                                <?php AuthChoice::end(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    footer {

        display: none;
    }

    header {
        display: none;
    }
</style>