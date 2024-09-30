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
use common\models\trierror\SitePages;

FrontAppAsset::register($this);
AppAsset::register($this);
NotifyAsset::register($this);

$page_reqeust = Yii::$app->request;

$this->registerCsrfMetaTags();
$this->params['baseurl'] = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset')->baseUrl;

$is_sitemap_exist = SitePages::find()->where(['url' => $page_reqeust->pathInfo])->orderBy('id DESC')->one();

$default_desc = "We offer a seamless experience, connecting you with multiple safari tour operators and providing all the essential details you need to make informed decisions about your wildlife safari, all at no cost. Our shared safari feature connects you with fellow safari enthusiasts, enabling you to form a group and embark on a shared safari adventure together.";

if (!empty($is_sitemap_exist->description)) {
    $this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
    $this->registerMetaTag(['name' => 'twitter:site', 'content' => 'WalkIntoTheWild']);

    if (!empty($is_sitemap_exist->title)) {
        $this->registerMetaTag(['name' => 'og:title', 'content' => $is_sitemap_exist->title]);
        $this->registerMetaTag(['name' => 'twitter:title', 'content' => $is_sitemap_exist->title]);
    } else {
        $this->registerMetaTag(['name' => 'og:title', 'content' => 'WalkIntoTheWild']);
        $this->registerMetaTag(['name' => 'twitter:title', 'content' => 'WalkIntoTheWild']);
    }

    if (!empty($is_sitemap_exist->description)) {
        $this->registerMetaTag(['name' => 'og:description', 'content' => $is_sitemap_exist->description]);
        $this->registerMetaTag(['name' => 'twitter:description', 'content' => $is_sitemap_exist->description]);
    } else {
        $this->registerMetaTag(['name' => 'description', 'content' => $default_desc]);
        $this->registerMetaTag(['name' => 'twitter:description', 'content' => $default_desc]);
    }

    if (!empty($is_sitemap_exist->keywords)) {
        $this->registerMetaTag(['name' => 'keywords', 'content' => $is_sitemap_exist->keywords]);
    } else {
        $this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
    }

    if (!empty($is_sitemap_exist->image)) {
        $imgurl = Yii::$app->params['frontend_url'] . $is_sitemap_exist->image;
        $this->registerMetaTag(['name' => 'og:image', 'content' => str_replace("//storage", "/storage", $imgurl)]);
        $this->registerMetaTag(['name' => 'twitter:image', 'content' => str_replace("//storage", "/storage", $imgurl)]);
    } else {
        $this->registerMetaTag(['name' => 'og:image', 'content' => $this->params['baseurl'] . '/img/default_witw_jeep.png']);
        $this->registerMetaTag(['name' => 'twitter:image', 'content' => $this->params['baseurl'] . '/img/default_witw_jeep.png']);
    }

    $this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
    $this->registerMetaTag(['name' => 'og:site_name', 'content' => 'WalkIntoTheWild']);
    $this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->params['frontend_url'] . $is_sitemap_exist->url]);
} else {
    $this->registerMetaTag(['name' => 'description', 'content' => $default_desc]);
    $this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);

    $this->registerMetaTag(['name' => 'og:title', 'content' => 'WalkIntoTheWild']);
    $this->registerMetaTag(['name' => 'og:description', 'content' => $default_desc]);
    $this->registerMetaTag(['name' => 'og:type', 'content' => 'website']);
    $this->registerMetaTag(['name' => 'og:site_name', 'content' => 'WalkIntoTheWild']);
    $this->registerMetaTag(['name' => 'og:image', 'content' => 'https://walkintothewild.in/img/default_witw_jeep.png']);
    $this->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->params['frontend_url'] . $page_reqeust->pathInfo]);

    $this->registerMetaTag(['name' => 'twitter:title', 'content' => 'WalkIntoTheWild']);
    $this->registerMetaTag(['name' => 'twitter:description', 'content' => $default_desc]);
    $this->registerMetaTag(['name' => 'twitter:site', 'content' => 'WalkIntoTheWild']);
    $this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
    $this->registerMetaTag(['name' => 'twitter:image', 'content' => 'https://walkintothewild.in/img/default_witw_jeep.png']);
} //end of og tags

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


    <div class="modal fade _standard-text" id="update-organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h1>
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
