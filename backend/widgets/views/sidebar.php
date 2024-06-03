<!-- BEGIN #sidebar -->
<?php
$active_url = "/" . Yii::$app->requestedRoute;

?>

<!-- main-sidebar -->
<div class="sticky">
	<aside class="app-sidebar ">
		<div class="main-sidebar-header active" style="background: #09422D !important;">
			<a class="header-logo active" href="#">
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
											"/master/bird/index",
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
											"/master/operator-category/index",
											"master/bonus-experience",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/meta",
														"/master/animal/index",
														"/master/bird/index",
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
														"/master/operator-category/index"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/animal/index")) ? "active" : "" ?>" href="/master/animal/index">Animal</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/bird/index")) ? "active" : "" ?>" href="/master/bird/index">Bird</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/vehicle/index")) ? "active" : "" ?>" href="/master/vehicle/index">Vehicle</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/location/index")) ? "active" : "" ?>" href="/master/location/index">Location</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/state/index")) ? "active" : "" ?>" href="/master/state/index">State</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/city/index")) ? "active" : "" ?>" href="/master/city/index">City</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/railway-station/index")) ? "active" : "" ?>" href="/master/railway-station/index">Railway Station</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/airport/index")) ? "active" : "" ?>" href="/master/airport/index">Airport</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/bonus-experience/index")) ? "active" : "/master/bonus-experience/index" ?>" href="/master/bonus-experience/index">Bonus Experience</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/mail-template/index")) ? "active" : "" ?>" href="/master/mail-template/index">Mail Template</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/operator-category/index")) ? "active" : "" ?>" href="/master/operator-category/index">Operator Category</a></li>
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
											"/meta/bird-type",
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
														"/meta/bird-type",
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
							<li><a class="slide-item <?= in_array($active_url, array("/meta/bird-type")) ? "active" : "" ?>" href="/meta/bird-type">Bird Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/term-condition-type")) ? "active" : "" ?>" href="/meta/term-condition-type">Term & Condition Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/accommodation")) ? "active" : "" ?>" href="/meta/accommodation">Accommodation</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/meta/safari-session")) ? "active" : "" ?>" href="/meta/safari-session">Safari Session</a></li>
						</ul>
					</li>

					<li class="slide <?= in_array($active_url, array(
											"/park/safari/default/index",
											"/park/birding/default/index",
											"/park/safari/default/create",
											"/park/safari/profile",
											"/park/safari/profile/gallery",
											"/park/safari/profile/creategallery",
											"/park/safari/profile/updategallery",
											"/park/safari/profile/animal",
											"/park/safari/profile/createanimal",
											"/park/safari/profile/updateanimal",
											"/park/safari/profile/zone",
											"/park/safari/profile/createzone",
											"/park/safari/profile/updatezone",
											"/park/safari/profile/vehicle",
											"/park/safari/profile/createvehicle",
											"/park/safari/profile/updatevehicle",
											"/park/safari/profile/flora-fauna",
											"/park/safari/profile/createflorafauna",
											"/park/safari/profile/updateflorafauna",
											"/park/safari/profile/how-to-reach",
											"/park/safari/profile/createhowtoreach",
											"/park/safari/profile/updatehowtoreach",
											"/park/safari/profile/map",


											"/park/birding/default/create",

											"/park/birding/profile",
											"/park/birding/profile/gallery",
											"/park/birding/profile/creategallery",
											"/park/birding/profile/updategallery",
											"/park/birding/profile/animal",
											"/park/birding/profile/createanimal",
											"/park/birding/profile/updateanimal",
											"/park/birding/profile/zone",
											"/park/birding/profile/createzone",
											"/park/birding/profile/updatezone",
											"/park/birding/profile/vehicle",
											"/park/birding/profile/createvehicle",
											"/park/birding/profile/updatevehicle",
											"/park/birding/profile/flora-fauna",
											"/park/birding/profile/createflorafauna",
											"/park/birding/profile/updateflorafauna",
											"/park/birding/profile/how-to-reach",
											"/park/birding/profile/createhowtoreach",
											"/park/birding/profile/updatehowtoreach",
											"/park/birding/profile/map"
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/park/safari/default/index",
														"/park/safari/default/create",
														"/park/safari/profile",
														"/park/safari/profile/gallery",
														"/park/safari/profile/creategallery",
														"/park/safari/profile/updategallery",
														"/park/safari/profile/animal",
														"/park/safari/profile/createanimal",
														"/park/safari/profile/updateanimal",
														"/park/safari/profile/zone",
														"/park/safari/profile/createzone",
														"/park/safari/profile/updatezone",
														"/park/safari/profile/vehicle",
														"/park/safari/profile/createvehicle",
														"/park/safari/profile/updatevehicle",
														"/park/safari/profile/flora-fauna",
														"/park/safari/profile/createflorafauna",
														"/park/safari/profile/updateflorafauna",
														"/park/safari/profile/how-to-reach",
														"/park/safari/profile/createhowtoreach",
														"/park/safari/profile/updatehowtoreach",
														"/park/safari/profile/map",

														"/park/birding/default/create",

														"/park/birding/default/index",
														"/park/birding/profile",
														"/park/birding/profile/gallery",
														"/park/birding/profile/creategallery",
														"/park/birding/profile/updategallery",
														"/park/birding/profile/animal",
														"/park/birding/profile/createanimal",
														"/park/birding/profile/updateanimal",
														"/park/birding/profile/zone",
														"/park/birding/profile/createzone",
														"/park/birding/profile/updatezone",
														"/park/birding/profile/vehicle",
														"/park/birding/profile/createvehicle",
														"/park/birding/profile/updatevehicle",
														"/park/birding/profile/flora-fauna",
														"/park/birding/profile/createflorafauna",
														"/park/birding/profile/updateflorafauna",
														"/park/birding/profile/how-to-reach",
														"/park/birding/profile/createhowtoreach",
														"/park/birding/profile/updatehowtoreach",
														"/park/birding/profile/map"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/material-symbols-light_park-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Parks</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Parks</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/park/safari/default/index",
															"/park/safari/default/create",
															"/park/safari/profile",
															"/park/safari/profile/gallery",
															"/park/safari/profile/creategallery",
															"/park/safari/profile/updategallery",
															"/park/safari/profile/animal",
															"/park/safari/profile/createanimal",
															"/park/safari/profile/updateanimal",
															"/park/safari/profile/zone",
															"/park/safari/profile/createzone",
															"/park/safari/profile/updatezone",
															"/park/safari/profile/vehicle",
															"/park/safari/profile/createvehicle",
															"/park/safari/profile/updatevehicle",
															"/park/safari/profile/flora-fauna",
															"/park/safari/profile/createflorafauna",
															"/park/safari/profile/updateflorafauna",
															"/park/safari/profile/how-to-reach",
															"/park/safari/profile/createhowtoreach",
															"/park/safari/profile/updatehowtoreach",
															"/park/safari/profile/map",
														)) ? "active" : "" ?>" href="/park/safari/default/index">Safari Park</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/park/birding/default/index",
															"/park/birding/default/create",
															"/park/birding/profile",
															"/park/birding/profile/gallery",
															"/park/birding/profile/creategallery",
															"/park/birding/profile/updategallery",
															"/park/birding/profile/animal",
															"/park/birding/profile/createanimal",
															"/park/birding/profile/updateanimal",
															"/park/birding/profile/zone",
															"/park/birding/profile/createzone",
															"/park/birding/profile/updatezone",
															"/park/birding/profile/vehicle",
															"/park/birding/profile/createvehicle",
															"/park/birding/profile/updatevehicle",
															"/park/birding/profile/flora-fauna",
															"/park/birding/profile/createflorafauna",
															"/park/birding/profile/updateflorafauna",
															"/park/birding/profile/how-to-reach",
															"/park/birding/profile/createhowtoreach",
															"/park/birding/profile/updatehowtoreach",
															"/park/birding/profile/map"
														)) ? "active" : "" ?>" href="/park/birding/default/index">Birding Park</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_cms_manager) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/cms",
											"/cms/article-category/index",
											"/cms/article-author/index",
											"/cms/article-tag/index",
											"/cms/banner",
											"/cms/about",
											"/cms/disclaimer",
											"/cms/privacypolicy",
											"/cms/termscondition"
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/cms",
														"/cms/article-category/index",
														"/cms/article-author/index",
														"/cms/article-tag/index",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">CMS</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu <?= in_array($active_url, array(
													"/cms",
													"/cms/article-category/index",
													"/cms/article-author/index",
													"/cms/article-tag/index",
													"/cms/banner",
													"/cms/about",
													"/cms/disclaimer",
													"/cms/privacypolicy",
													"/cms/termscondition"
												)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																				"/cms",
																				"/cms/article-category/index",
																				"/cms/article-author/index",
																				"/cms/article-tag/index",
																				"/cms/banner",
																				"/cms/about",
																				"/cms/disclaimer",
																				"/cms/privacypolicy",
																				"/cms/termscondition"
																			)) ? "" : "display: none;" ?>">
							<li class="side-menu__label1"><a href="javascript:void(0);">CMS</a></li>
							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/cms/article-category/index",
														"/cms/article-author/index",
														"/cms/article-tag/index",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Article</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/cms/article-category/index",
																"/cms/article-author/index",
																"/cms/article-tag/index",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/cms/article-category/index",
																							"/cms/article-author/index",
																							"/cms/article-tag/index",
																						)) ? "display: block;" : "display: none;" ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article-category/index")) ? "active" : "" ?>" href="/cms/article-category/index">Article Topics</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article-author/index")) ? "active" : "" ?>" href="/cms/article-author/index">Artcile Author</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article-tag/index")) ? "active" : "" ?>" href="/cms/article-tag/index">Article Tag</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article-comment/index")) ? "active" : "" ?>" href="#">Article Comments</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article/index")) ? "active" : "" ?>" href="#">Article</a></li>
								</ul>
							</li>
							<li class="sub-slide">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Feature</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu" style="display: none;">
									<li><a class="sub-side-menu__item" href="#">Park</a></li>
									<li><a class="sub-side-menu__item" href="#">Article</a></li>
									<li><a class="sub-side-menu__item" href="#">RARE AND EXOTIC</a></li>
									<li><a class="sub-side-menu__item" href="#">Article Tag</a></li>
									<li><a class="sub-side-menu__item" href="#">Article</a></li>
								</ul>
							</li>
							<li class="sub-slide">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">FAQs</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu" style="display: none;">
									<li><a class="sub-side-menu__item" href="/cms/faqcategory">FAQ Category</a></li>
									<li><a class="sub-side-menu__item" href="/cms/faqs">FAQs</a></li>
								</ul>
							</li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/banner")) ? "active" : "" ?>" href="#">Banners</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/about")) ? "active" : "" ?>" href="/cms/about">About</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/disclaimer")) ? "active" : "" ?>" href="/cms/disclaimer">Disclaimer</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/privacypolicy")) ? "active" : "" ?>" href="/cms/privacypolicy">Privacy Policy</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/termscondition")) ? "active" : "" ?>" href="/cms/termscondition">Team & Conditions</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/registration/safari-operator-tour",
											"/registration/safari-operator-tour/index",
											"/registration/safari-operator-tour/view",
											"/registration/safari-operator-tour/create",
											"/registration/safari-operator-tour/update",
											"/registration/birding-operator-tour",
											"/registration/birding-operator-tour/index",
											"/registration/birding-operator-tour/view",
											"/registration/birding-operator-tour/create",
											"/registration/birding-operator-tour/update",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/registration/safari-operator-tour",
														"/registration/safari-operator-tour/index",
														"/registration/safari-operator-tour/view",
														"/registration/safari-operator-tour/create",
														"/registration/safari-operator-tour/update",
														"/registration/birding-operator-tour",
														"/registration/birding-operator-tour/index",
														"/registration/birding-operator-tour/view",
														"/registration/birding-operator-tour/create",
														"/registration/birding-operator-tour/update",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/material-symbols-light_app-registration.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Registrations</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Registrations</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/registration/safari-operator-tour",
															"/registration/safari-operator-tour/index",
															"/registration/safari-operator-tour/view",
															"/registration/safari-operator-tour/create",
															"/registration/safari-operator-tour/update",
														)) ? "active" : "" ?>" href="/registration/safari-operator-tour">Safari Tour Operator</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/registration/birding-operator-tour",
															"/registration/birding-operator-tour/index",
															"/registration/birding-operator-tour/view",
															"/registration/birding-operator-tour/create",
															"/registration/birding-operator-tour/update",
														)) ? "active" : "" ?>" href="/registration/birding-operator-tour">Birding Tour Operator</a></li>
							<li><a class="slide-item" href="#">Article Comments</a></li>
						</ul>
					</li>

				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator) : ?>
					<li class="slide">
						<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Safari Operator</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Safari Operator</a></li>
							<li><a class="slide-item" href="#">Safari Tour Operator</a></li>
							<li><a class="slide-item" href="#">Biriding Tour Operator</a></li>
							<li><a class="slide-item" href="#">Resort/Lodge/Homen Stay</a></li>
						</ul>
					</li>
					<li class="slide">
						<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Share Safari</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Share Safari</a></li>
							<li><a class="slide-item" href="#">Safari</a></li>
							<li><a class="slide-item" href="#">Safari Comments</a></li>
						</ul>
					</li>
					<li class="slide">
						<a class="side-menu__item" href="#"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Resort</span></a>
					</li>



					<li class="slide">
						<a class="side-menu__item" href="#"><img src="/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Reviews</span></a>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide <?= in_array($active_url, array(
											"/log/default/index",
											"/trierror",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/log/default/index",
														"/trierror",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Log</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/log/default/index")) ? "active" : "" ?>" href="/log/default/index">Mail Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror")) ? "active" : "" ?>" href="/trierror">Error Log</a></li>
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

					<li class="slide <?= in_array($active_url, array(
											"/portalsetting/default/index",
											"/portalsetting/default/params",
											"/portalsetting/log/index",
											"/portalsetting/default/clear-assets",
											"/portalsetting/default/clear-cache"
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/portalsetting/default/index",
														"/portalsetting/default/params",
														"/portalsetting/log/index",
														"/portalsetting/default/clear-assets",
														"/portalsetting/default/clear-cache"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Portal Settings</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Portal Settings</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/index")) ? "active" : "" ?>" href="/portalsetting/default/index">Php Info</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/params")) ? "active" : "" ?>" href="/portalsetting/default/params">Params</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/index")) ? "active" : "" ?>" href="/portalsetting/log/index">Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/export")) ? "active" : "" ?>" href="/portalsetting/log/export">Export Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/clear")) ? "active" : "" ?>" href="/portalsetting/log/clear" data-method="post">Clear Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/clear-assets")) ? "active" : "" ?>" href="/portalsetting/default/clear-assets" data-method="post">Clear Assets</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/clear-cache")) ? "active" : "" ?>" href="/portalsetting/default/clear-cache" data-method="post">Clear Cache</a></li>
						</ul>
					</li>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/user",
														"/user/default/index",
													)) ? "active" : "" ?>" href="/user/default/index"><img src="/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Users</span></a>
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