<?php


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

if ($rare_exotics) {
?>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2>RARE AND EXOTIC <br> ANIMAL SAFARIS</h2>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($rare_exotics as $rare_exotic) { ?>
        <div class="animal-safari mb-4">
            <div class="inner_animals position-relative">
                <img src="<?= $this->params['baseurl'] ?>/img/brownbearbg.jpg" alt="" class="position-relative w-100">
                <div class="safariBox">
                    <div class="container">
                        <div class="row align-items-center ">
                            <div class="col-lg-6 col-md-5 text-center position-relative">
                                <img src="<?= $this->params['baseurl'] ?>/img/brownbear.png" alt="" class="imag_width position-relative">
                            </div>
                            <div class="col-lg-6 col-md-7">
                                <div class="safari_content">
                                    <h5>HIMALAYAN BROWN BEAR</h5>
                                    <p>IUCN: CRITICALLY ENDANGERED</p>
                                    <div class="knowmore">
                                        <a href="" class="btn-knowmore">Know More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php } ?>
<?php } ?>