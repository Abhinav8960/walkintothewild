<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\assets\NotifyAsset;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

FrontAppAsset::register($this);
AppAsset::register($this);
NotifyAsset::register($this);

$page_reqeust = Yii::$app->request;

$this->registerCsrfMetaTags();
$this->params['baseurl'] = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset')->baseUrl;

// $is_sitemap_exist = SitePages::find()->where(['url' => $page_reqeust->pathInfo])->orderBy('id DESC')->one();

$default_desc = "We offer a seamless experience, connecting you with multiple safari tour operators and providing all the essential details you need to make informed decisions about your wildlife safari, all at no cost. Our shared safari feature connects you with fellow safari enthusiasts, enabling you to form a group and embark on a shared safari adventure together.";
$default_title = "WalkIntoTheWild";
$default_image_url = 'https://walkintothewild.in/img/default_witw_jeep.png';
$default_keywords = $this->params['meta_keywords'] ?? '';

if (!empty($is_sitemap_exist->description)) {
    if (!empty($is_sitemap_exist->title)) {
        $default_title = $is_sitemap_exist->title;
    }

    if (!empty($is_sitemap_exist->description)) {
        $default_desc = $is_sitemap_exist->description;
    }

    if (!empty($is_sitemap_exist->keywords)) {
        $default_keywords = $is_sitemap_exist->keywords;
    }

    if (!empty($is_sitemap_exist->image)) {
        $imgurl = Yii::$app->params['frontend_url'] . $is_sitemap_exist->image;
        $default_image_url = str_replace("//storage", "/storage", $imgurl);
    }
}


$this->registerMetaTag(['name' => 'description', 'content' => $default_desc]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $default_keywords]);

$this->registerMetaTag(['property' => 'og:title', 'content' => $default_title]);
$this->registerMetaTag(['property' => 'og:description', 'content' => $default_desc]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->params['frontend_url'] . $page_reqeust->pathInfo]);
$this->registerMetaTag(['property' => 'og:image', 'content' => $default_image_url]);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['property' => 'og:site_name', 'content' => 'WalkIntoTheWild']);

$this->registerMetaTag(['name' => 'twitter:title', 'content' => $default_title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $default_desc]);
$this->registerMetaTag(['name' => 'twitter:image', 'content' => $default_image_url]);
$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
$this->registerMetaTag(['name' => 'twitter:site', 'content' => 'WalkIntoTheWild']);



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= $this->params['baseurl']; ?>/img/favicon.ico" type="image/x-icon" />

    <?php $this->head() ?>

    <?php if (\Yii::$app->params['environment'] == "production") { ?>
        <!-- Google tag (gtag.js) -->
        <script defer data-domain="walkintothewild.in" src="https://plausible.io/js/script.outbound-links.pageview-props.tagged-events.js"></script>
        <script>
            window.plausible = window.plausible || function() {
                (window.plausible.q = window.plausible.q || []).push(arguments)
            }
        </script>
        <meta name="google-adsense-account" content="ca-pub-6116324330184807">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6116324330184807" crossorigin="anonymous"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-NPYSHF37NV"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-NPYSHF37NV');
        </script>
    <?php } ?>
</head>

<body class="d-flex flex-column <?= Yii::$app->requestedRoute == 'site/login' ? 'terms-contionsSplasescreen' : '' ?>">
    <?php $this->beginBody() ?>

    <header>
        <?= \frontend\widgets\Header::widget() ?>

    </header>

    <main role="main" class="flex-shrink-0">

        <?= $content ?>
    </main>
    <?= \common\widgets\NotifyAlert::widget() ?>

    <?= \frontend\widgets\Footer::widget() ?>
    <?= \frontend\widgets\AccountPopup::widget() ?>



    <div class="modal fade _standard-text" id="update-organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h2>
                    <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
                </div>
                <div class="modal-body pt-0">
                    <div id='updatesafarimodalContent'></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $script = <<< JS
        function updateorganizefunction() {
            $('.updateSafariBtn').on('click', function () {
                $('#update-organize-modal').modal('show')
                .find('#updatesafarimodalContent')
                .load($(this).attr('value'));
            });
        }
        updateorganizefunction();
             
    JS;
    $this->registerJs($script);
    ?>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
