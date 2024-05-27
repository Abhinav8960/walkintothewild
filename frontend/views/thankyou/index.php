<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Thank You';
$this->params['title'] = $this->title;
?>

<section class="thankyoupage ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <a href="/">
          <div class="card_tankyou">
            <div class="tanksHeading">
              <h3 class="text-center pt-4">Thank you</h3>
            </div>
            <div class="content_wrp text-center">
              <p>Thank you for sharing your details with <span>Walk Into The Wild.</span> You will <br> receive a confirmation email shortly!</p>
            </div>
            <div class="checkImgs text-center">
              <img src="<?= $this->params['baseurl'] ?>/img/check-mark.png" alt="" width="200">
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>