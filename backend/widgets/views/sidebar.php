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
				<li class="slide">
					<a class="side-menu__item" href="widgets.html"><img src="/img/material-symbols-light_home-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Dashboard</span></a>
				</li>
				<li class="slide">
					<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-right"></i></a>
					<ul class="slide-menu">
						<li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>
						<li><a class="slide-item" href="/master/animal">Animal</a></li>
						<li><a class="slide-item" href="/master/vehicle">Vehicle</a></li>
						<li><a class="slide-item" href="/master/state">State</a></li>
						<li><a class="slide-item" href="/master/city">City</a></li>
						<li><a class="slide-item" href="/master/railway-station">Railway Station</a></li>
						<li><a class="slide-item" href="/master/airport">Airport</a></li>
						<li><a class="slide-item" href="/master/bonus-experience">Bonus Experience</a></li>
						<li><a class="slide-item" href="/master/email">Email</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Meta</span><i class="angle fe fe-chevron-right"></i></a>
					<ul class="slide-menu">
						<li class="side-menu__label1"><a href="javascript:void(0);">Meta</a></li>
						<li><a class="slide-item" href="/meta/wild-life-type">Wild Life Type</a></li>
						<li><a class="slide-item" href="/meta/location">Location</a></li>
						<li><a class="slide-item" href="/meta/zone-type">Zone Type</a></li>
						<li><a class="slide-item" href="/meta/stay-category">Stay Category</a></li>
						<li><a class="slide-item" href="/meta/tour-operator">Tour Operator</a></li>
						<li><a class="slide-item" href="/meta/park-trip-slot">Park Trip Slot</a></li>
						<li><a class="slide-item" href="/meta/operator-credibility">Operator Credibility</a></li>
						<li><a class="slide-item" href="/meta/package">Package</a></li>
						<li><a class="slide-item" href="/meta/other-wildlife-activities">Other Wildlife Activities</a></li>
						<li><a class="slide-item" href="/meta/animal-type">Animal Type</a></li>
						<li><a class="slide-item" href="/meta/team-condition">Team & Condition</a></li>
						<li><a class="slide-item" href="/meta/email">Email</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" href="widgets.html"><img src="/img/material-symbols-light_park-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Parks</span></a>
				</li>


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
						<li><a class="slide-item" href="#">About</a></li>
						<li><a class="slide-item" href="#">Disclaimer</a></li>
						<li><a class="slide-item" href="#">Privacy Policy</a></li>
						<li><a class="slide-item" href="#">Team & Conditions</a></li>
					</ul>
				</li>
				<li class="slide">
					<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/material-symbols-light_app-registration.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Registrations</span><i class="angle fe fe-chevron-right"></i></a>
					<ul class="slide-menu">
						<li class="side-menu__label1"><a href="javascript:void(0);">Registrations</a></li>
						<li><a class="slide-item" href="#">Safari Tour Operator</a></li>
						<li><a class="slide-item" href="#">Birding Tour Operator</a></li>
						<li><a class="slide-item" href="#">Article Comments</a></li>
					</ul>
				</li>



				<li class="slide">
					<a class="side-menu__item" href="widgets.html"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Safari Operator</span></a>
				</li>


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