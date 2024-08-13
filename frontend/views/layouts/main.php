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

$this->registerCsrfMetaTags();
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);

$this->params['baseurl'] = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset')->baseUrl;
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

<body class="d-flex flex-column ">
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h1>
                    <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
                </div>
                <div class="modal-body pt-0">
                    <div id='modalContent'></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $script = <<< JS
        function organizefunction() {
            $('.updateSafariBtn').on('click', function () {
                $('#update-organize-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            });
        }
        organizefunction();
             
    JS;
    $this->registerJs($script);
    ?>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
