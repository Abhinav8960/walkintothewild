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
    <?php foreach ($rare_exotics as $animal) { ?>
        <div class="animal-safari mb-4">
        <a href="<?= \yii\helpers\Url::toRoute(['/park/default/rareanimal', 'slug' => $animal->slug]) ?>" >
        <div class="inner_animals position-relative">
                <img src="<?= isset($animal->banner) ? $animal->bannerimagepath : $this->params['baseurl'] . '/img/brownbearbg.jpg' ?>" alt="" class="position-relative w-100">
                <div class="safariBox">
                    <div class="container">
                        <div class="row align-items-center gx-lg-auto gx-0">
                            <div class="col-lg-6 col-md-5 col-4  text-center position-relative">
                                <img src="<?= isset($animal->feature_image) ? $animal->imagepath : $this->params['baseurl'] . '/img/brownbear.png' ?>" alt="" class="imag_width position-relative">
                            </div>
                            <div class="col-lg-6 col-md-7 col-8">
                                <div class="safari_content">
                                    <h3><?= $animal->name ?></h3>
                                    <p class="two-line-text"><?= $animal->short_description ?></p>
                                    <div class="knowmore">
                                        <!-- <a href="<?= \yii\helpers\Url::toRoute(['/park/default/rareanimal', 'slug' => $animal->slug]) ?>" class="btn-knowmore">Know More</a> -->
                                        <div class="btn-knowmore mb-0">Know More</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </a>
           
        </div>
    <?php
    }
    ?>
<?php } ?>