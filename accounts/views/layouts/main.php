<?php

/** @var \yii\web\View $this */
/** @var string $content */

use accounts\assets\AppAsset;
use accounts\assets\PartnerAppAsset;
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

<body class="ltr main-body app sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="page">
        <div>
            <?= \accounts\widgets\Header::widget() ?>
            <?= \accounts\widgets\Sidebar::widget() ?>
        </div>
        <div class="main-content app-content">
            <div class="main-container container-fluid">
                <?= \accounts\widgets\PageHeader::widget([
                    'title' => isset($this->params['title']) ? $this->params['title'] : '',
                    'buttons' => isset($this->params['buttons']) ? $this->params['buttons'] : []
                ]) ?>
                <?= $content ?>
            </div>
        </div>
        <?= \common\widgets\NotifyAlert::widget() ?>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
