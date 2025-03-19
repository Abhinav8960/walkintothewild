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
        <div class="row justify-content-between border_bottom px-lg-5">
            <div class="col-lg-5">
                <?php
                // Directly fetch the data from the model
                $content = ContentManagement::findOne(['id' => ContentManagement::CM_ABOUT]);

                // Check if the content exists and its status is 1
                $showFooterContent = $content && $content->status == \common\interfaces\NewStatusInterface::STATUS_ACTIVE;
                ?>

                <?php if ($showFooterContent) : ?>
                    <div class="footer_text">
                        <div class="heading-footer">
                            <h6>About Us</h6>
                        </div>
                        <div class="footerContent">
                            <div class="content_terms" style="word-break: break-word;">
                                <?= $content ? Html::decode($content->content) : '<p>No content available</p>' ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer_text float-lg-end">
                    <div class="heading-footer">
                        <h6>Useful Links </h6>
                    </div>
                    <div class="footerContent">
                        <ul class="footer_listing">
                            <!-- <li><a href="/safaritour-registration">Safari Tour Operator</a></li> -->
                            <!-- <li><a href="/birdingtour-registration">Birding Tour Operator</a></li> -->
                            <!-- <li><a href="#" style="cursor: default;">Resorts / Lodge / Home Stay</a></li> -->
                            <li><a href="/article">Articles and Tips</a></li>
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/contact-us">Contact Us</a></li>
                            <li><a href="/faq">FAQs</a></li>
                            <!-- <li><a href="/sitemap">Sitemap</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer_text float-lg-end">
                    <div class="heading-footer">
                        <h6>Contact Info </h6>
                    </div>
                    <div class="footerContent">
                        <p><strong>Address:</strong> New Delhi , India</p>
                        <p><strong>Email:</strong> <a href="mailto:support@walkintothewild.in">support@walkintothewild.in</a></p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="insticon"><i class="fa-brands fa-instagram"></i> </div>

                            <a href="https://www.instagram.com/walkintothewild.in/" target="_blank">walkintothewild.in</a>

                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="mt-5">
                <div class="heading-footer">
                    <h6>DISCLAIMER</h6>
                </div>
                <div class="footerContent">
                    <
                    $content = ContentManagement::findOne(['id' => ContentManagement::CM_DISCLAIMER]);
                    ?>
                    <div class="content_terms" style="word-break: break-word;">
                        < $content ? Html::decode($content->content) : '<p>No content available</p>' ?>
                    </div>
                </div>
            </div> -->

        </div>


        <div class="row pt-4 justify-content-between mobile-responsive align-items-center">
            <div class="col-lg-2 col-xxl-2 ">
                <div class="footerlogo">
                    <img src="<?= $this->params['baseurl'] ?>/img/WLogoLightgreen.svg" alt="" width="70">
                </div>
            </div>
            <div class="col-lg-6 col-xxl-7 ">
                <div class="copyright text-center">
                    <p>Developed by Mediarc Technologies Pvt. Ltd. | All Rights Reserved</p>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-3 ">
                <div class="d-flex gap-3  justify-content-lg-end justify-content-center">
                    <div class="terms">
                        <p class="mb-0  pt-0"><a href="<?= \yii\helpers\Url::toRoute(['/privacy-policy']) ?>">PRIVACY POLICY</a></p>
                    </div>
                    <span class="pt-lg-0 pt-2">|</span>
                    <div class="terms">
                        <p class="mb-0 pt-0"><a href="<?= \yii\helpers\Url::toRoute(['/terms-of-use']) ?>">TERMS OF USE</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>

<?php

if (isset(Yii::$app->params['PUSHER_AUTH_KEY']) && Yii::$app->params['PUSHER_AUTH_KEY'] != '') {
    if (Yii::$app->user->identity) {
        echo $this->render('_notification_pusher');
    }
}
?>