<?php


use common\interfaces\Constants;
use common\models\cms\banner\Banner;

/* @var $this yii\web\View */

$this->title = 'Quatation';
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>
<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Adventure Awaits: Your Personalized Travel Quote</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<?=
    $this->render('_form', [
        'model' => $model,
]) ?>