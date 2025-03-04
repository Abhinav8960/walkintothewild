<?php

/** @var \yii\web\View $this */
/** @var string $content */

use tinyurl\assets\AppAsset;
use tinyurl\assets\NovaAppAsset;
use common\assets\NotifyAsset;
use tinyurl\widgets\Header;
use tinyurl\widgets\PageHeader;
use tinyurl\widgets\Setting;
use tinyurl\widgets\Sidebar;

NovaAppAsset::register($this);
AppAsset::register($this);
NotifyAsset::register($this);


$webasset = $this->assetManager->getBundle('\tinyurl\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

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
</head>

<body class="ltr main-body app sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="page">

        <div>
            <!-- /main-header -->
            <?= Header::widget() ?>
            <!-- /main-header -->

            <!-- main-sidebar -->
            <?= Sidebar::widget() ?>
            <!-- main-sidebar -->
        </div>
        <!-- START #content -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">
                <?= PageHeader::widget([
                    'title' => isset($this->params['title']) ? $this->params['title'] : '',
                    'buttons' => isset($this->params['buttons']) ? $this->params['buttons'] : []
                ]) ?>


                <?= $content ?>
            </div>
        </div>


        <!-- END #content -->


        <!-- BEGIN Setting -->
        <?= Setting::widget() ?>
        <?= \common\widgets\NotifyAlert::widget() ?>

        <!-- END Setting -->
    </div>
    <!-- END #app -->
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
