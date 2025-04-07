<?php

use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

FrontAppAsset::register($this);
AppAsset::register($this);
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Bussiness Sign in | Walk Into the Wild';
$this->params['title'] = $this->title;
?>
<div class="modal fade _standard-text mobile_loginconditions show" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180px" class="logo">
                </h1>
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
            </div>
            <div class="modal-body px-5">
                <div class="row py-4">
                    <div class="col-12 logindesign">
                        <div class="content_terms">
                            <h5 class="text-center">Login your account</h5>
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
                                <?php foreach ($authAuthChoice->getClients() as $client): ?>
                                    <?= $authAuthChoice->clientLink(
                                        $client,
                                        '<button class="googlelogin w-100 py-2 px-5 mb-3 d-flex align-items-center gap-2"> <img src="' . $this->params['baseurl'] . '/img/google-logo.5867462c.svg" width="25" alt="banner">Continue with Google</button>',
                                    ) ?>
                                <?php endforeach; ?>
                                <?php AuthChoice::end(); ?>
                            </div>

                            <h5 class="text-center mt-3">Or</h5>

                            <div class="btnssss-g pt-2" style="border:none;">
                                <a class="googlelogin w-50 py-2 px-5 mb-2 d-flex align-items-center gap-2" href="<?= Url::toRoute(['business-request/create']) ?>">Business Request</a>

                            </div>
                            <div class="contenss pt-3">
                                <p class="text-center">By logging in, you agree to our <br> <a href="<?= Yii::$app->params['frontend_url'] ?>/terms-of-use" target="_blank">Terms of Use</a> and <a href="<?= Yii::$app->params['frontend_url'] ?>/privacy-policy" target="_blank">Privacy Policy</a>.</p>
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



<?php
$base_url = $_SERVER['HTTP_HOST'];
$script = <<< JS
    $(document).ready(function () {
      function isWebview() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Refined webview detection
        var isAndroidWebview = /Android.*(wv|WebView)/i.test(userAgent);

        return isAndroidWebview;
      }

      function isWebviewOFIOS(){
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Refined webview detection
        var isIOSWebview = /iPhone|iPad|iPod/.test(userAgent) && !window.MSStream && !window.external;

        return  isIOSWebview;
      }

      if (isWebview()) {
        new_link = 'intent://{$base_url}#Intent;scheme=https;package=com.android.chrome;end';
        $('.auth-link').attr("href",new_link);
      }

      if (isWebviewOFIOS()) {
          // alert('view in ios device');


      }
  });
JS;
$this->registerJs($script);
?>