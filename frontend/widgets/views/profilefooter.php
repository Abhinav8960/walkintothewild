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
      


        <div class="row pt-4 pb-2s justify-content-between border_top mobile-responsive align-items-center">
            <div class="col-lg-2 col-md-4">
                <div class="footerlogo">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="" width="160">
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="copyright text-center">
                    <p>COPYRIGHT © 2024 | WALK INTO THE WILD | ALL RIGHTS RESERVED</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-12">
                <div class="terms">
                    <p class="mb-0"><a href="/termsandcondition">TERMS & CONDITIONS</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>