<?php


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
if ($featured_parks) {    ?>
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2> <?= $section_title ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="safari-carousel owl-carousel owl-theme">
        <?php
        foreach ($featured_parks as $featured_park) {
        ?>
            <div class="safari-box">
                <figure class="image-box">
                    <img src="<?= isset($featured_park->feature_image) ? $featured_park->featureimagepath : $this->params['baseurl'] . '/img/Jim Corbett.jpg' ?>" alt="" loading="lazy">
                </figure>
                <div class="content-box">
                    <h3><a href="/park/<?= $featured_park->slug ?>"><?= $featured_park->title ?></a></h3>
                </div>
                <div class="overlay-content d-flex align-items-center justify-content-between">
                    <div class="content_o pe-2">
                        <h3><a href="/park/<?= $featured_park->slug ?>"><?= $featured_park->title ?></a></h3>
                        <p><?= $featured_park->short_description ?></p>
                    </div>
                    <div class="link"><a href="/park/<?= $featured_park->slug ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>
        <?php }
        ?>
    </div>
<?php } ?>