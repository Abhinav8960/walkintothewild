<?php

use common\models\notification\FrontendNotification;

use yii\bootstrap5\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$active_url = "/" . Yii::$app->requestedRoute;
?>
<!-- main-header -->
<header class="header_wrapper">
	<nav class="navbar navbar-expand-lg ">
		<div class="container-fluid">
			<a href="/">
				<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180px" class="logo">
			</a>
			<div class="d-flex align-items-center">

				<div class="offcanvas offcanvas-end header_canvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
					<div class="offcanvas-header ps-1">
						<h5 class="offcanvas-title" id="offcanvasNavbarLabel">
							<a href="/park">
								<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="" class="logo">
							</a>
						</h5>
						<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" fill="#fff" class="bi bi-x-lg" viewBox="0 0 16 16" type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
							<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z">
							</path>
						</svg>

					</div>
					<div class="offcanvas-body pt-2  position-relative">
						<ul class="navbar-nav menu-navbar-nav align-items-center">
							<li class="nav-item text-lg-center  
							<?= in_array($active_url, array(
								"/",
								"/park/default/index",
								"/park/default/parklist",
								// "/park/default/view",
							)) ? "active" : "" ?>">

								<a class="nav-link" href="<?= \yii\helpers\Url::toRoute(['/']) ?>">
									<div class="d">
										<div class="card-img">
											<img src="<?= $this->params['baseurl'] ?>/img/plansafari-icon.png" alt="" width="32">
										</div> Plan Safari
								</a>
							</li>
							<li class="nav-item text-lg-center <?= (in_array($active_url, array("/package/default/index", "/package/default/view")) || str_starts_with($active_url, "/package")) ? "active" : "" ?>">

								<a href="/package" class="nav-link">
									<div class="card-img">
										<img src="<?= $this->params['baseurl'] ?>/img/Package.png" alt="" width="20">
									</div>Safari Packages
								</a>
							</li>
							<li class="nav-item text-lg-center <?= (in_array($active_url, array("/sharedsafari/default/index", "/sharesafari/default/view")) || str_starts_with($active_url, "/sharedsafari")) ? "active" : "" ?>">

								<a href="/sharedsafari" class="nav-link">
									<div class="card-img">
										<img src="<?= $this->params['baseurl'] ?>/img/safaric.png" alt="" width="32">
									</div>Shared Safari
								</a>
							</li>
						</ul>

						<div class="logoutBox d-lg-none">
							<div class="menuprofilemobile">
								<ul>
									<?php if (!Yii::$app->user->identity) { ?>
										<li>
											<a href="/site/auth?authclient=google"> <i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
										</li>
									<?php } else { ?>
										<?php
										if (Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator == 1) { ?>
											<li>
												<a class="" href="/manage">
													<i class="fa-solid fa-cog"></i>
													Manage Safari Tour Business</a>
											</li>
										<?php }
										?>


										<li>
											<a class="" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">
												<i class="fa-solid fa-user"></i>
												Profile</a>
										</li>
										<li>
											<a class="" href="/account">
												<i class="fa-solid fa-cog"></i>
												Account Setting</a>
										</li>
										<!-- <li>
												<a class="" href="/chat">
													<i class="fa-solid fa-message"></i>
													Messages</a>
											</li> -->
										<!-- <li>
												<a class="" href="/profile/search">
													<i class="fa-solid fa-search"></i>
													Search Profile</a>
											</li> -->
										<li>
											<a class="" href="/account/wishlist">
												<i class="fa-solid fa-heart"></i>
												Whishlist</a>
										</li>
										<li>
											<a class="" href="/site/logout" data-method="POST">
												<i class="fa-solid fa-arrow-right-from-bracket"></i>
												Log Out</a>

										</li>

									<?php } ?>


								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-flex gap-4 align-items-center justify-content-end initial_headers">

				<?php if (Yii::$app->user->identity) { ?>
					<div class="notification pt-2 "><i class="fa-solid fa-bell"></i></div>
					<div class="menunotification" id="menunotification_menu"></div>

					<div class="massge pt-2">
						<a href="/chat"><i class="fa-solid fa-envelope"></i></a>
					</div>
				<?php } ?>


				<div class="proilewrapper">
					<div class="profile">
						<div class="img-box2">
							<img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->profileimage <> '' ?  Yii::$app->user->identity->profileimage : $this->params['baseurl'] . '/img/user.png'  ?>" alt="" class="me-1 d-xl-inline-flex  rounded-circle" width="25" height="25">

						</div>
					</div>
					<div class="menuprofile">
						<div class="profileBoxwrap">

							<?php if ($user = Yii::$app->user->identity) { ?>
								<div class="profile_details d-flex gap-2">
									<div class="img-box2">
										<img src="<?= $user->profileimage <> '' ?  $user->profileimage : $this->params['baseurl'] . '/img/user.png'  ?>" alt="" class="me-1 d-xl-inline-flex  rounded-circle" width="35" height="35">
									</div>
									<div class="profile_name">
										<h6><?= $user->name ?></h6>
										<p><?= $user->userhandle ?></p>
									</div>
								</div>
							<?php } ?>
							<ul>
								<?php if (!Yii::$app->user->identity) { ?>
									<li>
										<a href="/site/login"> <i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
									</li>
								<?php } else { ?>


									<!-- <?php if (isset(Yii::$app->params['backend_url']) && (Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_birding_operator || Yii::$app->user->identity->is_cms_manager || Yii::$app->user->identity->is_resort_manager || Yii::$app->user->identity->is_report_manager)) { ?>
											<li>
												<a class="" target="_blank" href="<?= Yii::$app->params['backend_url'] ?>">
													<i class="fa-solid fa-cog"></i>
													Manage</a>
											</li>
										<?php } ?> -->
									<?php
									if (Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator == 1) { ?>
										<li>
											<a class="" href="/manage">
												<i class="fa-solid fa-cog"></i>
												Manage Safari Tour Business</a>
										</li>
									<?php }
									?>


									<li>
										<a class="" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">
											<i class="fa-solid fa-user"></i>
											Profile</a>
									</li>
									<li>
										<a class="" href="/account">
											<i class="fa-solid fa-cog"></i>
											Account Setting</a>
									</li>
									<!-- <li>
										<a class="" href="/chat">
											<i class="fa-solid fa-message"></i>
											Messages</a>
									</li> -->
									<!-- <li>
											<a class="" href="/profile/search">
												<i class="fa-solid fa-search"></i>
												Search Profile</a>
										</li> -->
									<li>
										<a class="" href="/account/wishlist">
											<i class="fa-solid fa-heart"></i>
											Whishlist</a>
									</li>
									<li class="border-top">
										<a class="py-3" href="/site/logout" data-method="POST">
											<i class="fa-solid fa-arrow-right-from-bracket"></i>
											Log Out</a>
									</li>
								<?php } ?>
							</ul>


						</div>

					</div>
				</div>
				<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
					<i class="fa-solid fa-bars"></i>
				</button>
			</div>
		</div>
	</nav>
</header>
