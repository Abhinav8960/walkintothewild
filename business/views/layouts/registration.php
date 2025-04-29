<?php

/** @var \yii\web\View $this */
/** @var string $content */

use business\assets\AppAsset;
use business\assets\NovaAppAsset;
use common\assets\NotifyAsset;

NovaAppAsset::register($this);
AppAsset::register($this);
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

<body class="main-body">
    <?php $this->beginBody() ?>

    <!-- <div class="page"> -->

    <div>
        <!-- /main-header -->
        <?= \business\widgets\Registrationheader::widget() ?>
        <!-- /main-header -->
    </div>
    <!-- START #content -->

    <!-- main-content -->
    <div class="container">
        <!-- container -->
        <!-- <div class="main-container"> -->
        <?= $content ?>
        <!-- </div> -->
    </div>
    
    <div>
        <!-- partner Reject Reason -->
        <?= \business\widgets\PartnerRejectReason::widget() ?>
        <!-- partner Reject Reason -->
    </div>


    <!-- END #content -->
    <?= \common\widgets\NotifyAlert::widget() ?>

    <!-- END Setting -->
    <!-- </div> -->
    <!-- END #app -->
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
