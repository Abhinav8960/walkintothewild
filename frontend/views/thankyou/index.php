<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<section class="thankyoupage ">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card_tankyou">
                   <div class="tanksHeading">
                    <h3 class="text-center pt-4">Thank you</h3>
                   </div>
                   <div class="content_wrp text-center">
                    <p>Thank tou for Visiting <span>Walk into the Wild</span> you will <br> received an Email message Shortly!</p>
                   </div>
                   <div class="checkImgs text-center">
                   <img src="<?= $this->params['baseurl'] ?>/img/check-mark.png" alt="" width="200">
                   </div>
            </div>
        </div>
    </div>
</div>
</section>