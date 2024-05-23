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
<div class="modal fade" id="modalTermscondition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">TERMS & CONDITIONS</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="title_terms text-center">
          <h5>TERMS & CONDITIONS</h5>
        </div>
        <div class="terms_details">
          <h6 class="h6 pb-3">By accessing, using, or signing up for this website, newsletters, or any services, you enter into a legally binding agreement with Walk Into The Wild based on these terms. </h6>

          <h6>Introductio</h6>
          <p>Welcome to the www.walkintothewild.in website ("Website", "website", "Site" or "site"). This website, its pages, the content, services, and infrastructure are owned, operated, and provided by Walk Into The Wild ("Walk Into The Wild", "Us", "us", "We" or "we") or other parties. The website and its content are provided for your personal, non-commercial use only, subject to the terms of use as set out below. These terms of use (this "Agreement") set forth the terms and conditions governing your use of this website.</p>
          <h6>Modifications to this Agreement</h6>
          <p>We reserve the right to modify this Agreement at our sole discretion. Changes are effective immediately upon updating this page. Please review this Agreement periodically. By continuing to use our website after changes are made, you accept those changes.</p>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalprivacyPolicy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">PRIVACY POLICY</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="title_terms text-center">
          <h5>PRIVACY POLICY</h5>
        </div>
        <div class="terms_details">
          <h6>Privacy </h6>
          <p>We outline our current practices regarding personally identifiable and other information collected through our website in our Privacy Policy. We reserve the right to update our policies and practices at our sole discretion. By using our website, you acknowledge that you have read and agree to our privacy policy.</p>
          <h6>Your use of content and information (disclaimer) </h6>
          <p>We offer a diverse range of content on our website, including information, advice, recommendations, messages, comments, posts, text, graphics, software, music, sound, photographs, videos, data, and other materials ("Content" or "content"). Some content is provided by us or our suppliers, while other content is contributed by users of our website ("Users" or "users"), such as opinions and views shared via reviews, chat rooms, blogs, or message boards. While we strive to ensure the accuracy, completeness, and timeliness of the content on our website, we cannot guarantee it and are not responsible for any inaccuracies, omissions, or delays, whether in content provided by us, our suppliers, or users. Any opinions, advice, statements, or other information expressed by users or third parties are solely their own and do not represent our views.</p>
          <p>We are not obligated to prescreen, edit, or remove any user-provided content posted on or available through our website. However, we reserve the right (but not the obligation), at our sole discretion and for any reason, to prescreen, edit, refuse, remove, or relocate any such content.</p>
        </div>


      </div>

    </div>
  </div>
</div>