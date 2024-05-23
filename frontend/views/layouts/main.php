<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

FrontAppAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column ">
    <?php $this->beginBody() ?>

    <header>
        <?= \frontend\widgets\Header::widget() ?>

    </header>

    <main role="main" class="flex-shrink-0">

        <?= Alert::widget() ?>
        <?= $content ?>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <?= \frontend\widgets\Footer::widget() ?>

    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
