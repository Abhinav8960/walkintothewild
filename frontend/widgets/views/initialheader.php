	<?php

	$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
	$this->params['baseurl'] = $webasset->baseUrl;

	use yii\helpers\Url;
	?>
	<!-- main-header -->
	<header class="header_wrapper navigation_hide d-flex align-items-center">
		<div class="container-fluid">
			<div class="row justify-content-between align-items-center">
				<div class="col-2 ">
					<a href="/">
						<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180" class="logo">
					</a>
				</div>
				<div class="col-8">
					<div class="d-flex gap-4 align-items-center justify-content-end initial_headers">
						<div class="notification pt-2"><i class="fa-solid fa-bell"></i></div>
						<div class="massge pt-2"><i class="fa-solid fa-envelope"></i></div>
						<div class="proilewrapper">
							<div class="profile">
								<div class="img-box2">
									<img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->profileimage <> '' ?  Yii::$app->user->identity->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="me-1 d-xl-inline-flex  rounded-circle" width="25" height="25">

								</div>
							</div>
							<div class="menuprofile">
								<ul>
									<?php if (!Yii::$app->user->identity) { ?>
										<li>
											<a href="/site/auth?authclient=google"> <i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
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
										<li>
											<a class="" href="#">
												<i class="fa-solid fa-message"></i>
												Messages</a>
										</li>
										<li>
											<a class="" href="/profile/search">
												<i class="fa-solid fa-search"></i>
												Search Profile</a>
										</li>
										<li>
											<a class="" href="/account/wishlist">
												<i class="fa-solid fa-heart"></i>
												Whishlist</a>
										</li>
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
			</div>

		</div>
	</header>
	<!-- /main-header -->