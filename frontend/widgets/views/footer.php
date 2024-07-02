<?php
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
                <div class="footer_text">
                    <div class="heading-footer">
                        <h6>ABOUT US </h6>
                    </div>
                    <div class="footerContent">
                        <p>We offers a seamless experience, connecting you with multiple safari tour operators and providing all
                            the essential details you need to make informed decisions about your wildlife safari, all at no cost.
                        </p>
                        <p>Our shared safari feature connects you with fellow safari enthusiasts, enabling you to form a group and
                            embark on a shared safari adventure together.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer_text float-lg-end">
                    <div class="heading-footer">
                        <h6>Become A Partner </h6>
                    </div>
                    <div class="footerContent">
                        <ul class="footer_listing">
                            <li><a href="/safaritour-registration">Safari Tour Operator</a></li>
                            <li><a href="/birdingtour-registration">Birding Tour Operator</a></li>
                            <li><a href="#" style="cursor: default;">Resorts / Lodge / Home Stay</a></li>
                            <li><a href="/contact">Contact Us</a></li>
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
                        <p><strong>Email:</strong> <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="insticon"><i class="fa-brands fa-instagram"></i> </div>

                            <a href="">walkintothewild.in</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4 justify-content-between mobile-responsive align-items-center">
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