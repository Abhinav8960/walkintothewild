<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use backend\assets\NovaAppAsset;
use common\widgets\Alert;

NovaAppAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" style="--bs-success-text:#198754; ">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= $this->title ?></title>
    <?php $this->head() ?>


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-X449945MQ2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-X449945MQ2');
    </script>

    <style>
        .invalid-feedback {
            color: #dc3545;
        }

        .body {
            background-color: #ebeef4 !important;
        }
    </style>
</head>

<body class="ltr main-body app sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="page">

        <div>
            <!-- /main-header -->
            <?= \backend\widgets\Header::widget() ?>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <?= \backend\widgets\Sidebar::widget() ?>
            <!-- main-sidebar -->
        </div>
        <!-- START #content -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <?= Alert::widget() ?>

                <?= \backend\widgets\PageHeader::widget([
                    'title' => isset($this->params['title']) ? $this->params['title'] : '',
                    'buttons' => isset($this->params['buttons']) ? $this->params['buttons'] : []
                ]) ?>


                <?= $content ?>
            </div>
        </div>


        <!-- END #content -->


        <!-- BEGIN Setting -->
        <?= \backend\widgets\Setting::widget() ?>
        <!-- END Setting -->
    </div>
    <!-- END #app -->
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
