<?php

use common\models\cms\contentmanagement\ContentManagement;
use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Privacy Policy';
$this->params['title'] = $this->title;
?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/safariformbanner.jpg" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/safariformbanner.jpg" class="d-block w-100 " alt="banner">
    </picture>

</section>
<section class="terms_wrapper">
    <div class="container-lg">
        <div class="row pb-5 mb-5">
            <div class="col-12">
                <div class="title_terms">
                    <h2>Privacy Policy</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="terms_details">
                    <?php
                    $content = ContentManagement::findOne(['id' => ContentManagement::CMS_PRIVACY_POLICY]);
                    ?>
                    <div class="content_terms">
                        <p><?= $content ? Html::decode($content->content) : 'No content available' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>