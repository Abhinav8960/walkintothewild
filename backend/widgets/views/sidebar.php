<!-- BEGIN #sidebar -->
<?php
$active_url = "/" . Yii::$app->requestedRoute;

?>

<!-- main-sidebar -->
<div class="sticky">
	<aside class="app-sidebar ">
		<div class="main-sidebar-header active" style="background: #09422D !important;">
			<a class="header-logo active" href="index.html">
				<img src="/img/logo.png" class="main-logo  desktop-logo" alt="logo">
				<img src="/img/2.jpg" class="main-logo  desktop-dark" alt="logo">
				<img src="/img/2.jpg" class="main-logo  mobile-logo" alt="logo">
				<img src="/img/2.jpg" class="main-logo  mobile-dark" alt="logo">
			</a>
		</div>
		<div class="main-sidemenu">
			<div class="slide-left disabled" id="slide-left"><img src="/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon"></div>
			<ul class="side-menu">
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<li class="slide">
						<a class="side-menu__item" href="/"><img src="/img/material-symbols-light_home-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Dashboard</span></a>
					</li>

					<li class="slide <?= in_array($active_url, array(
											"/master",
											"/master/animal/index",
											"/master/vehicle/index",
											"/master/state/index",
											"/master/country/index",
											"/master/city/index",
											"/master/location/index",
											"/master/railway-station/index",
											"/master/airport/index",
											"/master/bonus-experience/index",
											"/master/email/index",
											"/master/mail-template/index",
											"master/bonus-experience",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/meta",
														"/master/animal/index",
														"/master/vehicle/index",
														"/master/country/index",
														"/master/state/index",
														"/master/city/index",
														"/master/location/index",
														"/master/railway-station/index",
														"/master/airport/index",
														"/master/bonus-experience/index",
														"/master/email/index",
														"/master/mail-template/index",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/animal/index")) ? "active" : "" ?>" href="/master/animal/index">Animal</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/vehicle/index")) ? "active" : "" ?>" href="/master/vehicle/index">Vehicle</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/location/index")) ? "active" : "" ?>" href="/master/location/index">Location</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/state/index")) ? "active" : "" ?>" href="/master/state/index">State</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/city/index")) ? "active" : "" ?>" href="/master/city/index">City</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/railway-station/index")) ? "active" : "" ?>" href="/master/railway-station/index">Railway Station</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/airport/index")) ? "active" : "" ?>" href="/master/airport/index">Airport</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/bonus-experience/index")) ? "active" : "/master/bonus-experience/index" ?>" href="/master/bonus-experience/index">Bonus Experience</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/mail-template/index")) ? "active" : "" ?>" href="/master/mail-template/index">Mail Template</a></li>
						</ul>
					</li>

					<li class="slide <?= in_array($active_url, array(
											"/meta",
											"/meta/term-condition-type",
											"/meta/wild-life-type",
											"/meta/zone-type",
											"/meta/stay-category",
											"/meta/tour-operator",
											"/meta/park-trip-slot",
											"/meta/operator-credibility",
											"/meta/package",
											"/meta/other-wildlife-activities",
											"/meta/animal-type",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/meta",
														"/meta/term-condition-type",
														"/meta/wild-life-type",
														"/meta/zone-type",
														"/meta/stay-category",
														"/meta/park-trip-slot",
														"/meta/operator-credibility",
														"/meta/package",
														"/meta/other-wildlife-activities",
														"/meta/animal-type",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Meta</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Meta</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/wild-life-type")) ? "active" : "" ?>" href="/meta/wild-life-type">Wild Life Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/zone-type")) ? "active" : "" ?>" href="/meta/zone-type">Zone Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/stay-category")) ? "active" : "" ?>" href="/meta/stay-category">Stay Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/park-trip-slot")) ? "active" : "" ?>" href="/meta/park-trip-slot">Park Trip Slot</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/operator-credibility")) ? "active" : "" ?>" href="/meta/operator-credibility">Operator Credibility</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/package")) ? "active" : "" ?>" href="/meta/package">Package</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/other-wildlife-activities")) ? "active" : "" ?>" href="/meta/other-wildlife-activities">Other Wildlife Activities</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/animal-type")) ? "active" : "" ?>" href="/meta/animal-type">Animal Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/term-condition-type")) ? "active" : "" ?>" href="/meta/term-condition-type">Term & Condition Type</a></li>
						</ul>
					</li>

					<li class="slide">
						<a class="side-menu__item" href="/park"><img src="/img/material-symbols-light_park-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Parks</span></a>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_cms_manager) : ?>

					<li class="slide">
						<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">CMS</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu" style="display: none;">
							<li class="side-menu__label1"><a href="javascript:void(0);">CMS</a></li>
							<li class="sub-slide">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Article</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu" style="display: none;">
									<li><a class="sub-side-menu__item" href="#">Article Topics</a></li>
									<li><a class="sub-side-menu__item" href="#">Article Comments</a></li>
									<li><a class="sub-side-menu__item" href="#">Artcile Author</a></li>
									<li><a class="sub-side-menu__item" href="#">Article Tag</a></li>
									<li><a class="sub-side-menu__item" href="#">Artcile</a></li>
								</ul>
							</li>
							<li class="sub-slide">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Feature</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu" style="display: none;">
									<li><a class="sub-side-menu__item" href="#">Park</a></li>
									<li><a class="sub-side-menu__item" href="#">Article</a></li>
									<li><a class="sub-side-menu__item" href="#">RARE AND EXOTIC</a></li>
									<li><a class="sub-side-menu__item" href="#">Article Tag</a></li>
									<li><a class="sub-side-menu__item" href="#">Artcile</a></li>
								</ul>
							</li>
							<li class="sub-slide">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">FAQs</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu" style="display: none;">
									<li><a class="sub-side-menu__item" href="#">FAQ Category</a></li>
									<li><a class="sub-side-menu__item" href="#">FAQs</a></li>
								</ul>
							</li>
							<li><a class="slide-item" href="#">Banners</a></li>
							<li><a class="slide-item" href="/cms/about">About</a></li>
							<li><a class="slide-item" href="/cms/disclaimer">Disclaimer</a></li>
							<li><a class="slide-item" href="#">Privacy Policy</a></li>
							<li><a class="slide-item" href="#">Team & Conditions</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/registration/safari-operator-tour",
											"/registration/safari-operator-tour/index",
											"/registration/safari-operator-tour/view",
											"/registration/birding-operator-tour",
											"/registration/birding-operator-tour/index",
											"/registration/birding-operator-tour/view",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/registration/safari-operator-tour",
														"/registration/safari-operator-tour/index",
														"/registration/safari-operator-tour/view",
														"/registration/birding-operator-tour",
														"/registration/birding-operator-tour/index",
														"/registration/birding-operator-tour/view",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/material-symbols-light_app-registration.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Registrations</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Registrations</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/registration/safari-operator-tour",
															"/registration/safari-operator-tour/index",
															"/registration/safari-operator-tour/view",
														)) ? "active" : "" ?>" href="/registration/safari-operator-tour">Safari Tour Operator</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/registration/birding-operator-tour",
															"/registration/birding-operator-tour/index",
															"/registration/birding-operator-tour/view",
														)) ? "active" : "" ?>" href="/registration/birding-operator-tour">Birding Tour Operator</a></li>
							<li><a class="slide-item" href="#">Article Comments</a></li>
						</ul>
					</li>

				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator) : ?>

					<li class="slide">
						<a class="side-menu__item" href="widgets.html"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Safari Park</span></a>
					</li>

					<li class="slide">
						<a class="side-menu__item" href="widgets.html"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Resort</span></a>
					</li>

					<li class="slide">
						<a class="side-menu__item" href="widgets.html"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Shared Safari</span></a>
					</li>

					<li class="slide">
						<a class="side-menu__item" href="widgets.html"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Reviews</span></a>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<li class="slide">
						<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Share Safari</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Share Safari</a></li>
							<li><a class="slide-item" href="index.html">Safari</a></li>
							<li><a class="slide-item" href="index1.html">Safari Comments</a></li>
						</ul>
					</li>


					<li class="slide">
						<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Progress Tracking</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Progress Tracking</a></li>
							<li><a class="slide-item" href="#">Report</a></li>
							<li><a class="slide-item" href="#">Mail Log</a></li>
							<li><a class="slide-item" href="#">Tracking</a></li>
							<li><a class="slide-item" href="#">Ranking</a></li>
						</ul>
					</li>



					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/user",
														"/user/default/index",
													)) ? "active" : "" ?>" href="/user/default/index"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Users</span></a>
					</li>

				<?php endif; ?>

				<li class="slide">
					<a class="side-menu__item" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post"> <img src="/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon">
						<span class="side-menu__label">Logout</span></a>
				</li>

			</ul>
			<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
					<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
				</svg></div>
		</div>
	</aside>
</div>
<!-- main-sidebar -->
<!-- END #sidebar -->