<?php

use common\models\master\animal\MasterAnimal;
use common\models\master\animal\MasterRareAnimal;
use common\models\park\SafariParkAnimal;
use common\models\park\SafariParkRareAnimal;

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
    <?php foreach ($rare_exotics as $rare_exotic) {
        $safarianimal = SafariParkRareAnimal::find()->where(['safari_park_id' => $rare_exotic->id, 'status' => 1])->limit(1)->orderBy(['id' => SORT_ASC])->one();
        if ($safarianimal) {
            $animal = MasterRareAnimal::find()->where(['status' => 1, 'id' => $safarianimal->master_rare_animal_id])->limit(1)->one();
    ?>
            <div class="animal-safari mb-4">
                <div class="inner_animals position-relative">
                    <img src="<?= isset($animal->banner) ? $animal->bannerimagepath : $this->params['baseurl'] . '/img/brownbearbg.jpg' ?>" alt="" class="position-relative w-100">
                    <div class="safariBox"> 
                        <div class="container">
                            <div class="row align-items-center ">
                                <div class="col-lg-6 col-md-5 col-4 text-center position-relative">
                                    <img src="<?= isset($animal->feature_image) ? $animal->imagepath : $this->params['baseurl'] . '/img/brownbear.png' ?>" alt="" class="imag_width position-relative">
                                </div>
                                <div class="col-lg-6 col-md-7 col-8">
                                    <div class="safari_content">
                                        <h5><?= $animal->animal_name ?></h5>
                                        <p><?= $animal->short_description ?></p>
                                        <div class="knowmore">
                                            <a href="/parklist?SafariParkSearch%5Bmaster_rare_animal_id%5D=<?= $animal->id ?>" class="btn-knowmore">Know More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    <?php }
    }
    ?>
<?php } ?>