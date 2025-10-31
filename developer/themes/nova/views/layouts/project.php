<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\NovaAsset;
use common\widgets\Alert;
use yii\bootstrap4\Html;
use backend\widgets\Breadcrumbs;

NovaAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="<?= Yii::$app->charset ?>">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
	<meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

	<!-- Title -->
	<title> <?= \Yii::$app->name ?> | <?= Html::encode($this->title) ?> </title>

	<!-- CSRF Tag -->
	<?php $this->registerCsrfMetaTags() ?>
	<!-- Favicon -->
	<link rel="icon" href="/images/favicon.png" type="image/x-icon" />

	<?php $this->head() ?>

</head>

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
		<div class="main-content app-content">

			<!-- container -->
			<div class="main-container container-fluid">


				<!-- breadcrumb -->
				<?=
				Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				])
				?>


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

		<?= \backend\widgets\ProjectMenu::widget() ?>

		<!-- Footer closed -->
	</div>
	<!-- End Page -->

	<!-- Back-to-top -->
	<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>


	<?php $this->endBody() ?>
	<?= \backend\widgets\Alert::widget() ?>

</body>

</html>
<?php $this->endPage();
