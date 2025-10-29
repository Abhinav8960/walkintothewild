<?php

/** @var \yii\web\View $this */
/** @var string $content */

use business\assets\AppAsset;
use business\assets\PartnerAppAsset;
use common\assets\NotifyAsset;

AppAsset::register($this);
PartnerAppAsset::register($this);
NotifyAsset::register($this);

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


<body class="sidebar-layout-icon">
    <?php $this->beginBody() ?>

    <div class="container-scroller">

        <div>
            <!-- main-sidebar -->
            <?= \business\widgets\Sidebar::widget() ?>
           
            <!-- main-sidebar -->
        </div>
        <!-- START #content -->
        <header class="container-fluid main-header">

            <!-- main-content -->
            <div class="main-pannel mt-4">

                <!-- /main-header -->
                <?= \business\widgets\Header::widget() ?>
                <!-- /main-header -->

                <!-- container -->
                <div class="container-fluid">
                    <?= \business\widgets\PageHeader::widget([
                        'title' => isset($this->params['title']) ? $this->params['title'] : '',
                        'buttons' => isset($this->params['buttons']) ? $this->params['buttons'] : []
                    ]) ?>


                    <?= $content ?>
                </div>
            </div>


            <!-- END #content -->
            <?= \common\widgets\NotifyAlert::widget() ?>

            <!-- END Setting -->
        </header>
    </div>
    <!-- END #app -->
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
