<?php
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<footer class="main_footer position-relative">
  <div class="footer_object">
    <img src="<?= $this->params['baseurl'] ?>/img/footer.png" alt="">
  </div>
  <div class="container-fluid">
    <div class="row  border_bottom soon_pagefooter">
      <div class="col-xxl-4 col-lg-6 col-md-6 pb-lg-0 pb-5">
        <div class="footer_text ">
          <div class="heading-footer">
            <h6>Contact </h6>
          </div>
          <div class="footerContent">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="comingsoonpage-footer d-flex align-items-center gap-2">
                <div class="insticon"><i class="fa-brands fa-instagram"></i> </div>
                <a href="">walkintothewild.in</a>
              </div>
              <span class="d-sm-block d-none">|</span>
              <div class="comingsoonpage-footer">
                <p class="mb-0"><strong>Email:</strong> <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-5 col-lg-6 col-md-6 pb-lg-0 pb-4">
        <div class="footer_text ">
          <div class="heading-footer">
            <h6>BECOME A PARTNER </h6>
          </div>
          <div class="footerContent">
            <ul class="footer_listing d-flex gap-md-3 gap-2 flex-wrap">
              <li><a href="">Safari Tour Operator</a></li>
              <li>|</li>
              <li><a href="">Birding Tour Operator</a></li>
              <li>|</li>
              <li><a href="">Resorts / Lodge / Home Stay</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-lg-6  col-md-6 pb-lg-0 pb-4">
        <div class="footer_text float-xxl-end">
          <div class="heading-footer">
            <h6>LEGAL</h6>
          </div>
          <div class="footerContent legal">
            <ul class="footer_listing d-flex gap-2">
              <li><a href="" data-bs-toggle="modal" data-bs-target="#modalTermscondition">TERMS & CONDITIONS</a></li>
              <li>|</li>
              <li><a href="" data-bs-toggle="modal" data-bs-target="#modalprivacyPolicy">PRIVACY POLICY</a></li>
            </ul>
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
      <div class="col-lg-0 col-md-8">
        <div class="copyright float-lg-end">
          <p>COPYRIGHT © 2024 | WALK INTO THE WILD | ALL RIGHTS RESERVED</p>
        </div>
      </div>

    </div>
  </div>
</footer>