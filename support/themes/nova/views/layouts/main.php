<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap5\Html;
use backend\assets\NovaAsset;
use backend\widgets\Breadcrumbs;
NovaAsset::register($this);
//echo "<pre>";
//print_r($this->assetBundles['backend\assets\NovaAsset']->baseUrl);exit;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Project managment system">
        <meta name="Author" content="Triline infotech Private Limited">
        <meta name="Keywords" content="project,bug,meeting,action ponts,notes,calender" />
        <title><?= !empty(\Yii::$app->params['projectTitle']) ? \Yii::$app->params['projectTitle'] . ' |' : '' ?>  <?= Html::encode($this->title) ?> |  <?= \Yii::$app->name ?> </title>
        <?php $this->registerCsrfMetaTags() ?>
        <link rel="icon" href="/images/svgs/vector.svg" type="image/x-icon" />
        <?php $this->head() ?>
    </head>

    <!-- <body class="ltr main-body app light-theme horizontal horizontal-hover" onload="countdowntimes()"> -->
    <body class="ltr main-body app light-theme horizontal horizontal-hover">

        <!-- Loader -->
        <div id="global-loader">
            <img src="/images/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page">

            <div>
                <!-- main-header -->

                <?= \backend\widgets\Header::widget() ?>

                <!-- /main-header -->

                <!-- main-sidebar -->
                <?= \backend\widgets\MainSidebar::widget() ?>


                <!-- main-sidebar -->
            </div>

            <!-- main-content -->
            <div class="main-content app-content mt-3">

                <!-- container -->
                <div class="main-container container-fluid">





                    <?= $content ?>
                    <!--Content End-->



                </div>
                <!-- /Container -->
            </div>
            <!-- /main-content -->

            <!-- Sidebar-right-->
            <?= \backend\widgets\ProjectNotification::widget() ?>


            <!--/Sidebar-right-->



            <?= \backend\widgets\Modals::widget() ?>



            <!-- Footer opened -->
            <?= \backend\widgets\Footer::widget() ?>

            <!-- Footer closed -->
        </div>
        <!-- End Page -->

        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

        <?= \backend\widgets\Alert::widget() ?>


        <?php $this->endBody() ?>
    </body>

</html>
<?php
$this->endPage();
