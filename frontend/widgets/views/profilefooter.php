<?php

use common\models\cms\contentmanagement\ContentManagement;
use yii\helpers\Html;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<footer class="main_footer position-relative">
    <div class="footer_object">
        <img src="<?= $this->params['baseurl'] ?>/img/desktopfooter.png" alt="" class="d-md-block d-none">
        <img src="<?= $this->params['baseurl'] ?>/img/footermobile.png" alt="" class="d-md-none d-block">
    </div>
    <div class="container-fluid">

    <div class="row pt-4 justify-content-between mobile-responsive align-items-center border_top">
            <div class="col-lg-2 col-xxl-2 ">
                <div class="footerlogo">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="" width="160">
                </div>
            </div>
            <div class="col-lg-6 col-xxl-7 ">
                <div class="copyright text-center">
                    <p>COPYRIGHT © 2024 | WALK INTO THE WILD | ALL RIGHTS RESERVED</p>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-3 ">
                <div class="d-flex gap-3  justify-content-lg-end justify-content-center">
                    <div class="terms">
                        <p class="mb-0  pt-0"><a href="<?= \yii\helpers\Url::toRoute(['/privacy-policy']) ?>">PRIVACY POLICY</a></p>
                    </div>
                    <span>|</span>
                    <div class="terms">
                        <p class="mb-0 pt-0"><a href="<?= \yii\helpers\Url::toRoute(['/terms-of-use']) ?>">TERMS OF USE</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>