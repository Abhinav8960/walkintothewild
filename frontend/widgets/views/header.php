	<?php

	$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
	$this->params['baseurl'] = $webasset->baseUrl;

	$active_url = "/" . Yii::$app->requestedRoute;
	?>
	<!-- main-header -->
	<header class="header_wrapper">
		<nav class="navbar navbar-expand-xl p-0">
			<div class="container-fluid">
				<a href="/park">
					<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="210px" class="logo">
				</a>

				<div class="d-flex align-items-center">
					<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
						<i class="fa-solid fa-bars"></i>
					</button>
					<div class="offcanvas offcanvas-end header_canvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
						<div class="offcanvas-header ps-1">
							<h5 class="offcanvas-title" id="offcanvasNavbarLabel">
								<a href="/park">
									<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="">
								</a>
							</h5>

							<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" fill="#fff" class="bi bi-x-lg" viewBox="0 0 16 16" type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
								<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z">
								</path>
							</svg>

						</div>
						<div class="offcanvas-body justify-content-end">
							<ul class="navbar-nav menu-navbar-nav align-items-center">
								<li class="nav-item 
							<?= in_array($active_url, array(
								"/",
								"/park/default/index",
								"/park/default/parklist",
								"/park/default/view",
							)) ? "active" : "" ?>">
									<a class="nav-link" href="<?= \yii\helpers\Url::toRoute(['/parklist']) ?>"> <i class="fa-solid fa-magnifying-glass d-xl-inline-flex d-none"></i> Search Safari</a>
								</li>
								<li class="nav-item <?= in_array($active_url, array(
														"/article/default/index",
														"/article/default/view",
													)) ? "active" : "" ?>">
									<a class="nav-link" href="/article"> <img src="<?= $this->params['baseurl'] ?>/img/Articlestipsicon.png" alt="" class="me-1 d-xl-inline-flex d-none"> ARTICLES & TIPS</a>
								</li>
								<!-- <li class="nav-item <?= in_array($active_url, array(
																"/contact",
															)) ? "active" : "" ?>">
								<a class="nav-link" href="/contact"> <img src="<?= $this->params['baseurl'] ?>/img/contact-us.png" alt="" class="me-1 d-xl-inline-flex d-none" width="25"> Contact Us</a>
							</li> -->
								<a href="/sharedsafari" class="sahreSafari text-xl-center">
									<div class="card-img">
										<img src="<?= $this->params['baseurl'] ?>/img/ShareSafariIcon.png" alt="">
									</div>
									<h5>Shared Safari</h5>
								</a>

								<li>

								</li>

							</ul>
						</div>
					</div>
					<div class="proilewrapper">
						<div class="profile">
							<div class="img-box2">
								<img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->avatar <> '' ? Yii::$app->user->identity->avatar : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="me-1 d-xl-inline-flex  rounded-circle" width="40" height="40">
							</div>
						</div>
						<div class="menuprofile">
							<ul>
								<?php if (!Yii::$app->user->identity) { ?>
									<li>
										<a href="/site/auth?authclient=google"> <i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
									</li>
								<?php } else { ?>
									<li>
										<a class="" href="/site/logout">
											<i class="fa-solid fa-arrow-right-from-bracket"></i>
											Log Out</a>
									</li>
								<?php } ?>

							</ul>
						</div>
					</div>
				</div>

			</div>

		</nav>
	</header>
	<!-- /main-header -->