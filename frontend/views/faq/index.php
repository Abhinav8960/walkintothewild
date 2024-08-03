<?php

use common\models\cms\faqs\Faqs;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'FAQs - Frequently Asked Questions';
$this->params['title'] = $this->title;
?>



<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/NewBanner_big.png" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1 class="mb-0">Frequently Asked Questions</h1>
                        <!-- <p class="text-center text-white mb-0">Organized by <?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></p> -->
                    </div>


                </div>

            </div>
        </div>

    </div>
</section>


<section class="faqs-wrpper margin_bottomfooter pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">

                    <?php
                    if ($faq_categories) {
                        foreach ($faq_categories as $faq_category) {

                            $faq_list = Faqs::find()->where(['status' => 1, 'category_id' => $faq_category->id])->all();
                    ?>
                            <h5><?= $faq_category->name ?></h5>
                            <hr>
                            <?php foreach ($faq_list as $faq) { ?>
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?= $faq->id ?>" aria-expanded="false" aria-controls="flush-<?= $faq->id ?>">
                                            <?= $faq->question ?>
                                        </button>
                                    </h2>
                                    <div id="flush-<?= $faq->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <?= $faq->answer ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                    <?php  }
                    } else {
                        echo 'Nothing to show!';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>