<!-- BEGIN #sidebar -->
<?php
$active_url = "/" . Yii::$app->requestedRoute;
?>

<!-- main-sidebar -->
<div class="sticky">
	<aside class="app-sidebar ">
		<div class="main-sidebar-header active" style="background: #09422D !important;">
			<a class="header-logo active" href="/">
				<img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  desktop-logo" alt="logo">
				<img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  desktop-dark" alt="logo">
				<img src="<?= $this->params['baseurl'] ?>/img/sidebar_logo.png" class="main-logo  mobile-logo" alt="logo">
				<img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  mobile-dark" alt="logo">
			</a>
		</div>
		<div class="main-sidemenu">
			<div class="slide-left disabled" id="slide-left"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon"></div>
			<ul class="side-menu">

				<li class="slide">
					<a class="side-menu__item" href="/"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_home-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Dashboard</span></a>
				</li>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/master",
											"/master/rare-animal/index",
											"/master/rare-animal/create",
											"/master/rare-animal/update",
											"/master/rare-animal/view",
											"/master/animal/index",
											"/master/animal/create",
											"/master/animal/update",
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
											"/master/suggestion-category/index",
											"master/bonus-experience",
											"/master/packagefeature/index",
											"/master/packagefeature/create",
											"/master/packagefeature/update",
											"/master/packageinclude/index",
											"/master/packageinclude/create",
											"/master/packageinclude/update",
											"/master/share-safari-reason/index",
											"/master/share-safari-reason/create",
											"/master/share-safari-reason/update",
											"/master/message/index",
											"/master/message/create",
											"/master/message/update",
											"/master/user-flag/index",
											"/master/user-flag/create",
											"/master/user-flag/update",

										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/master",
														"/master/rare-animal/index",
														"/master/rare-animal/create",
														"/master/rare-animal/update",
														"/master/rare-animal/view",
														"/master/animal/index",
														"/master/animal/create",
														"/master/animal/update",
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
														"/master/operator-category/index",
														"/master/suggestion-category/index",
														"/master/packagefeature/index",
														"/master/packagefeature/create",
														"/master/packagefeature/update",
														"/master/packageinclude/index",
														"/master/packageinclude/create",
														"/master/packageinclude/update",
														"/master/share-safari-reason/index",
														"/master/share-safari-reason/create",
														"/master/share-safari-reason/update",
														"/master/message/index",
														"/master/message/create",
														"/master/message/update",
														"/master/user-flag/index",
														"/master/user-flag/create",
														"/master/user-flag/update",

													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>

							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/master/animal/index",
														"/master/animal/create",
														"/master/animal/update",
														"/master/rare-animal/index",
														"/master/rare-animal/create",
														"/master/rare-animal/update",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Animal</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/master/animal/index",
																"/master/animal/create",
																"/master/animal/update",
																"/master/rare-animal/index",
																"/master/rare-animal/create",
																"/master/rare-animal/update",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/master/animal/index",
																							"/master/animal/create",
																							"/master/animal/update",
																							"/master/rare-animal/index",
																							"/master/rare-animal/create",
																							"/master/rare-animal/update",
																						)) ? "display: block;" : "display: none;" ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			"/master/rare-animal/index",
																			"/master/rare-animal/create",
																			"/master/rare-animal/update",
																			"/master/rare-animal/view",
																		)) ? "active" : "" ?>" href="/master/rare-animal/index">Rare and Exotic</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			"/master/animal/index",
																			"/master/animal/create",
																			"/master/animal/update",
																		)) ? "active" : "" ?>" href="/master/animal/index">Usual</a></li>
									<!-- <li><a class="sub-side-menu__item <?php // in_array($active_url, array("/cms/feature-tag/index")) ? "active" : "" 
																			?>" href="/cms/feature-tag/index">Article Tag</a></li> -->
								</ul>
							</li>

							<!-- <li><a class="slide-item <?= in_array($active_url, array("/master/bird/index")) ? "active" : "" ?>" href="/master/bird/index">Bird</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array("/master/vehicle/index")) ? "active" : "" ?>" href="/master/vehicle/index">Vehicle</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/location/index")) ? "active" : "" ?>" href="/master/location/index">Location</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/state/index")) ? "active" : "" ?>" href="/master/state/index">State</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/city/index")) ? "active" : "" ?>" href="/master/city/index">City</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/railway-station/index")) ? "active" : "" ?>" href="/master/railway-station/index">Railway Station</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/airport/index")) ? "active" : "" ?>" href="/master/airport/index">Airport</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/bonus-experience/index")) ? "active" : "/master/bonus-experience/index" ?>" href="/master/bonus-experience/index">Bonus Experience</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/mail-template/index")) ? "active" : "" ?>" href="/master/mail-template/index">Mail Template</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/notification-template/index")) ? "active" : "" ?>" href="/master/notification-template/index">Notification Template</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/operator-category/index")) ? "active" : "" ?>" href="/master/operator-category/index">Operator Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/master/suggestion-category/index")) ? "active" : "" ?>" href="/master/suggestion-category/index">Suggestion Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/master/packagefeature/index",
															"/master/packagefeature/create",
															"/master/packagefeature/update",
														)) ? "active" : "" ?>" href="/master/packagefeature/index">Package Feature</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/master/packageinclude/index",
															"/master/packageinclude/create",
															"/master/packageinclude/update",
														)) ? "active" : "" ?>" href="/master/packageinclude/index">Package Include</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/master/share-safari-reason/index",
															"/master/share-safari-reason/create",
															"/master/share-safari-reason/update",
														)) ? "active" : "" ?>" href="/master/share-safari-reason/index">Share Safari Reject Reason</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/master/user-flag/index",
															"/master/user-flag/create",
															"/master/user-flag/update",
														)) ? "active" : "" ?>" href="/master/user-flag/index">User Flag</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																"/master/message/index",
																"/master/message/create",
																"/master/message/update",
															)) ? "active" : "" ?>" href="/master/message/index">Message</a></li> -->

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
											"/meta/accommodation",
											"/meta/safari-session"
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
														"/meta/accommodation",
														"/meta/safari-session"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Meta</span><i class="angle fe fe-chevron-right"></i></a>
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

				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

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
											"/park/safari/profile/suggestions",


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
											"/park/birding/profile/map",

											"/park/operator-quote/index",
											"/park/operator-quote/view",
											"/park/safari-suggestion/index"
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
														"/park/safari/profile/suggestions",




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
														"/park/birding/profile/map",

														"/park/operator-quote/index",
														"/park/operator-quote/view",
														"/park/safari-suggestion/index"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_park-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Parks</span><i class="angle fe fe-chevron-right"></i></a>
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
															"/park/safari/profile/suggestions",
														)) ? "active" : "" ?>" href="/park/safari/default/index">Safari Park</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
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
															)) ? "active" : "" ?>" href="/park/birding/default/index">Birding Park</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array(
															"/park/operator-quote/index",
															"/park/operator-quote/view",
														)) ? "active" : "" ?>" href="/park/operator-quote/index">Operator Quotes</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/park/safari-suggestion/index",
														)) ? "active" : "" ?>" href="/park/safari-suggestion/index">Safari Suggestion</a></li>

						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_cms_manager) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/cms",
											"/cms/blog-category/index",
											"/cms/blog-category/create",
											"/cms/blog-category/update",
											"/cms/blog-author/index",
											"/cms/blog-author/create",
											"/cms/blog-author/update",
											"/cms/blog-tag/index",
											"/cms/blog-tag/create",
											"/cms/blog-tag/update",
											"/cms/blog/index",
											"/cms/blog/update",
											"/cms/blog/create",
											"/cms/blog/comment",
											"/cms/banner",
											"/cms/about",
											"/cms/disclaimer",
											"/cms/privacypolicy",
											"/cms/termscondition",
											"/cms/faqcategory",
											"/cms/faqs",
											"/cms/feature-park/index",
											"/cms/banner/index",
											"/cms/banner/create",
											"/cms/banner/update",
											"/cms/frontend-banner",
											"/cms/frontend-banner/index",
											"/cms/frontend-banner/create",
											"/cms/frontend-banner/update",

											"/cms/feature-article/index",
											"/cms/feature-rare-exotic/index",
											"/cms/feature-tag/index",
											"/cms/content-management",
											"/cms/flag-reason",

										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/cms",
														"/cms/blog-category/index",
														"/cms/blog-category/create",
														"/cms/blog-category/update",
														"/cms/blog-author/index",
														"/cms/blog-author/create",
														"/cms/blog-author/update",
														"/cms/blog-tag/index",
														"/cms/blog-tag/create",
														"/cms/blog-tag/update",
														"/cms/blog/index",
														"/cms/blog/update",
														"/cms/blog/create",
														"/cms/blog/comment",
														"/cms/faqcategory",
														"/cms/faqs",
														"/cms/about/index",
														"/cms/disclaimer/index",
														"/cms/banner/index",
														"/cms/banner/create",
														"/cms/banner/update",
														"/cms/frontend-banner/index",
														"/cms/frontend-banner/create",
														"/cms/frontend-banner/update",

														"/cms/feature-park/index",
														"/cms/feature-article/index",
														"/cms/feature-rare-exotic/index",
														"/cms/feature-tag/index",
														"/cms/content-management",
														"/cms/flag-reason",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">CMS</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu <?= in_array($active_url, array(
													"/cms",
													"/cms/blog-category/index",
													"/cms/blog-category/create",
													"/cms/blog-category/update",
													"/cms/blog-author/index",
													"/cms/blog-author/create",
													"/cms/blog-author/update",
													"/cms/blog-tag/index",
													"/cms/blog-tag/create",
													"/cms/blog-tag/update",
													"/cms/blog/index",
													"/cms/blog/update",
													"/cms/blog/create",
													"/cms/blog/comment",

													"/cms/banner",
													"/cms/frontend-banner",

													"/cms/about",
													"/cms/disclaimer",
													"/cms/privacypolicy",
													"/cms/termscondition",
													"/cms/faqcategory",
													"/cms/faqs",
													"/cms/feature-park/index",
													"/cms/feature-article/index",
													"/cms/feature-rare-exotic/index",
													"/cms/feature-tag/index",
													"/cms/content-management",
													"/cms/flag-reason",
												)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																				"/cms",
																				"/cms/blog-category/index",
																				"/cms/blog-category/create",
																				"/cms/blog-category/update",
																				"/cms/blog-author/index",
																				"/cms/blog-author/create",
																				"/cms/blog-author/update",
																				"/cms/blog-tag/index",
																				"/cms/blog-tag/create",
																				"/cms/blog-tag/update",
																				"/cms/blog/index",
																				"/cms/blog/update",
																				"/cms/blog/create",
																				"/cms/blog/comment",

																				"/cms/banner",
																				"/cms/frontend-banner",

																				"/cms/about",
																				"/cms/disclaimer",
																				"/cms/privacypolicy",
																				"/cms/termscondition",
																				"/cms/faqcategory",
																				"/cms/faqs",
																				"/cms/feature-park/index",
																				"/cms/banner/index",
																				"/cms/banner/create",
																				"/cms/banner/update",
																				"/cms/frontend-banner/index",
																				"/cms/frontend-banner/create",
																				"/cms/frontend-banner/update",

																				"/cms/feature-article/index",
																				"/cms/feature-rare-exotic/index",
																				"/cms/feature-tag/index",
																				"/cms/content-management",
																				"/cms/flag-reason",
																			)) ? "" : "display: none;" ?>">
							<li class="side-menu__label1"><a href="javascript:void(0);">CMS</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															"/cms/master-tag/index",
															"/cms/master-tag/create",
															"/cms/master-tag/update",
														)) ? "active" : "" ?>" href="/cms/master-tag/index">Tags</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															"/cms/master-category/index",
															"/cms/master-category/create",
															"/cms/master-category/update",
														)) ? "active" : "" ?>" href="/cms/master-category/index">Topics</a></li>
							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/cms/blog-category/index",
														"/cms/blog-category/create",
														"/cms/blog-category/update",
														"/cms/blog-author/index",
														"/cms/blog-author/create",
														"/cms/blog-author/update",
														"/cms/blog-tag/index",
														"/cms/blog-tag/create",
														"/cms/blog-tag/update",
														"/cms/blog/index",
														"/cms/blog/update",
														"/cms/blog/create",
														"/cms/blog/comment",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Blog</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/cms/blog-category/index",
																"/cms/blog-category/create",
																"/cms/blog-category/update",
																"/cms/blog-author/index",
																"/cms/blog-author/create",
																"/cms/blog-author/update",
																"/cms/blog-tag/index",
																"/cms/blog-tag/create",
																"/cms/blog-tag/update",
																"/cms/blog/index",
																"/cms/blog/update",
																"/cms/blog/create",
																"/cms/blog/comment",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/cms/blog-category/index",
																							"/cms/blog-category/create",
																							"/cms/blog-category/update",
																							"/cms/blog-author/index",
																							"/cms/blog-author/create",
																							"/cms/blog-author/update",
																							"/cms/blog-tag/index",
																							"/cms/blog-tag/create",
																							"/cms/blog-tag/update",
																							"/cms/blog/index",
																							"/cms/blog/update",
																							"/cms/blog/create",
																							"/cms/blog/comment",

																						)) ? "display: block;" : "display: none;" ?>">
									<!-- <li><a class="sub-side-menu__item <?= in_array($active_url, array(
																				"/cms/blog-category/index",
																				"/cms/blog-category/create",
																				"/cms/blog-category/update",
																			)) ? "active" : "" ?>" href="/cms/blog-category/index">Blog Topics</a></li> -->
									<!-- <li><a class="sub-side-menu__item <?= in_array($active_url, array(
																				"/cms/blog-author/index",
																				"/cms/blog-author/create",
																				"/cms/blog-author/update",
																			)) ? "active" : "" ?>" href="/cms/article-author/index">Blog Author</a></li> -->
									<!-- <li><a class="sub-side-menu__item <?= in_array($active_url, array(
																				"/cms/blog-tag/index",
																				"/cms/blog-tag/create",
																				"/cms/blog-tag/update",
																			)) ? "active" : "" ?>" href="/cms/blog-tag/index">Blog Tag</a></li> -->
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			"/cms/blog/index",
																			"/cms/blog/update",
																			"/cms/blog/create",
																			"/cms/blog/comment",
																		)) ? "active" : "" ?>" href="/cms/blog/index">Blog</a></li>



								</ul>
							</li>

							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/cms/article-category/index",
														"/cms/article-category/create",
														"/cms/article-category/update",
														"/cms/article-author/index",
														"/cms/article-author/create",
														"/cms/article-author/update",
														"/cms/article-tag/index",
														"/cms/article-tag/create",
														"/cms/article-tag/update",
														"/cms/article/index",
														"/cms/article/update",
														"/cms/article/create",
														"/cms/article/comment",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Article</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/cms/article-category/index",
																"/cms/article-category/create",
																"/cms/article-category/update",
																"/cms/article-author/index",
																"/cms/article-author/create",
																"/cms/article-author/update",
																"/cms/article-tag/index",
																"/cms/article-tag/create",
																"/cms/article-tag/update",
																"/cms/article/index",
																"/cms/article/update",
																"/cms/article/create",
																"/cms/article/comment",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/cms/article-category/index",
																							"/cms/article-category/create",
																							"/cms/article-category/update",
																							"/cms/article-author/index",
																							"/cms/article-author/create",
																							"/cms/article-author/update",
																							"/cms/article-tag/index",
																							"/cms/article-tag/create",
																							"/cms/article-tag/update",
																							"/cms/article/index",
																							"/cms/article/update",
																							"/cms/article/create",
																							"/cms/article/comment",

																						)) ? "display: block;" : "display: none;" ?>">

									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			"/cms/master-article-author/index",
																			"/cms/master-article-author/create",
																			"/cms/master-article-author/update",
																		)) ? "active" : "" ?>" href="/cms/master-article-author/index">Article Author</a></li>

									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			"/cms/article/index",
																			"/cms/article/update",
																			"/cms/article/create",
																			"/cms/article/comment",
																		)) ? "active" : "" ?>" href="/cms/article/index">Article</a></li>



								</ul>
							</li>
							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/cms/feature-park/index",
														"/cms/feature-article/index",
														"/cms/feature-rare-exotic/index",
														"/cms/feature-tag/index",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Feature</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/cms/feature-park/index",
																"/cms/feature-article/index",
																"/cms/feature-rare-exotic/index",
																"/cms/feature-tag/index",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/cms/feature-park/index",
																							"/cms/feature-article/index",
																							"/cms/feature-rare-exotic/index",
																							"/cms/feature-tag/index",
																						)) ? "display: block;" : "display: none;" ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/feature-park/index")) ? "active" : "" ?>" href="/cms/feature-park/index">Park</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/feature-article/index")) ? "active" : "" ?>" href="/cms/feature-article/index">Article</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/feature-rare-exotic/index")) ? "active" : "" ?>" href="/cms/feature-rare-exotic/index">RARE AND EXOTIC</a></li>
									<!-- <li><a class="sub-side-menu__item <?php // in_array($active_url, array("/cms/feature-tag/index")) ? "active" : "" 
																			?>" href="/cms/feature-tag/index">Article Tag</a></li> -->
								</ul>
							</li>
							<li class="sub-slide <?= in_array($active_url, array(
														"/cms",
														"/cms/faqcategory",
														"/cms/faqs",
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">FAQs</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																"/cms",
																"/cms/faqcategory",
																"/cms/faqs",
															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							"/cms",
																							"/cms/faqcategory",
																							"/cms/faqs",
																						)) ? "display: block;" :  "display: none;"  ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/article-category/index")) ? "active" : "" ?>" href="/cms/faqcategory">FAQ Category</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array("/cms/faqs")) ? "active" : "" ?>" href="/cms/faqs">FAQs</a></li>
								</ul>
							</li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/banner/index", "/cms/banner/create", "/cms/banner/update")) ? "active" : "" ?>" href="/cms/banner/index">Banners</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/cms/frontend-banner/index", "/cms/frontend-banner/create", "/cms/frontend-banner/update")) ? "active" : "" ?>" href="/cms/frontend-banner/index">Frontend Banner</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/cms/about")) ? "active" : "" ?>" href="/cms/about">About</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/cms/disclaimer")) ? "active" : "" ?>" href="/cms/disclaimer">Disclaimer</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/cms/privacypolicy")) ? "active" : "" ?>" href="/cms/privacypolicy">Privacy Policy</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/cms/termscondition")) ? "active" : "" ?>" href="/cms/termscondition">Team & Conditions</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array("/cms/content-management")) ? "active" : "" ?>" href="/cms/content-management">Content Management</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/cms/flag-reason",
														)) ? "active" : "" ?>" href="/cms/flag-reason">Flag Reason</a></li>

						</ul>
					</li>
				<?php endif; ?>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

					<!-- <li class="slide <?= in_array($active_url, array(
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
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_app-registration.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Registrations</span><i class="angle fe fe-chevron-right"></i></a>
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
						</ul>
					</li> -->

					<li class="slide <?= in_array($active_url, array(
											"/operator/safari-operator/index",
											"/operator/safari-operator/index/view",
											"/operator/birding-operator/index",
											"/operator/birding-operator/index/view",
											"/operator/safari-operator/index",
											"/operator/safari-operator/index/view",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/operator/safari-operator/index",
														"/operator/safari-operator/index/view",
														"/operator/birding-operator/index",
														"/operator/birding-operator/index/view",
														"/operator/safari-operator/index",
														"/operator/safari-operator/index/view",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Operator</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/operator/safari-operator/index",
															"/operator/safari-operator/index/view",
														)) ? "active" : "" ?>" href="/operator/safari-operator/index">Safari Tour Operator</a></li>
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator approval List</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/operatorapproval/default/index",
															"/operatorapproval/default/view",
														)) ? "active" : "" ?>" href="/operatorapproval/default/index">Operator approval List</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																"/operator/birding-operator/index",
																"/operator/birding-operator/index/view",
															)) ? "active" : "" ?>" href="/operator/birding-operator/index">Biriding Tour Operator</a></li>
							<li><a class="slide-item" href="#">Resort/Lodge/Homen Stay</a></li> -->
						</ul>
					</li>



					<li class="slide <?= in_array($active_url, array(
											"/pendingapproval/article-comment/index",
											"/pendingapproval/article-comment/view",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/pendingapproval/article-comment/index",
														"/pendingapproval/article-comment/view",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Pending Approvals</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Pending Approvals</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																"/pendingapproval/article-comment/index",
																"/pendingapproval/article-comment/view",
															)) ? "active" : "" ?>" href="/pendingapproval/article-comment/index">Article Comments</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																"/pendingapproval/user-article/index",
																"/pendingapproval/user-article/view",
															)) ? "active" : "" ?>" href="/pendingapproval/user-article/index">User Article Approvals</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array(
															"/pendingapproval/park-review-approval/index",
														)) ? "active" : "" ?>" href="/pendingapproval/park-review-approval/index">Park Review Approvals</a></li>

						</ul>
					</li>


					<li class="slide <?= in_array($active_url, array(
											"/flag/blog/index",

											"/flag/operator/index",

											"/flag/package/index",

											"/flag/share-safari/index",
											"/flag/untraced-flag/index",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/flag/blog/index",
														"/flag/operator/index",
														"/flag/share-safari/index",
														"/flag/package/index",
														"/flag/untraced-flag/index",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Flag</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Flag</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/operator/index",
														)) ? "active" : "" ?>" href="/flag/operator/index">Operator Comments</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/package/index",
														)) ? "active" : "" ?>" href="/flag/package/index">Package Comments</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/share-safari/index",
														)) ? "active" : "" ?>" href="/flag/share-safari/index">Share Safari</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/blog/index",
														)) ? "active" : "" ?>" href="/flag/blog/index">Blog Comments</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/article/index",
														)) ? "active" : "" ?>" href="/flag/article/index">Article Comments</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/flag/untraced-flag/index",
														)) ? "active" : "" ?>" href="/flag/untraced-flag/index">Untraced Flags</a></li>


						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator) : ?>
					<!-- <li class="slide <?= str_starts_with($active_url, '/operatordashboard') ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= str_starts_with($active_url, '/operatordashboard') ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Operator</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator</a></li>
							<li class="sub-slide <?= in_array($active_url, array(
														"/operatordashboard/safari"
													)) ? "is-expanded" : "" ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Safari Tour Operator</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/operatordashboard/safari',
																'/operatordashboard/safari/index',
																'/operatordashboard/safari/quote',
																'/operatordashboard/safari/sharedsafari',
																'/operatordashboard/safari/review',
																'/operatordashboard/safari/follower',

															)) ? "open" : "" ?>" style="<?= in_array($active_url, array(
																							'/operatordashboard/safari',
																							'/operatordashboard/safari/index',
																							'/operatordashboard/safari/quote',
																							'/operatordashboard/safari/sharedsafari',
																							'/operatordashboard/safari/review',
																							'/operatordashboard/safari/follower',

																						)) ? "display: block;" :  "display: none;"  ?>">
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/index') ? "active" : "" ?>" href="/operatordashboard/safari/index">Overview</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/quote') ? "active" : "" ?>" href="/operatordashboard/safari/quote">Get a Free Quote</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/sharedsafari') ? "active" : "" ?>" href="/operatordashboard/safari/sharedsafari">Shared Safari</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/review') ? "active" : "" ?>" href="/operatordashboard/safari/review">User Review</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/follower') ? "active" : "" ?>" href="/operatordashboard/safari/follower">Follower</a></li>


								</ul>
							</li>
							<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/birding') ? "active" : "" ?>" href="/operatordashboard/birding/index">Biriding Tour Operator</a></li>
							<li><a class="slide-item" href="#">Resort/Lodge/Homen Stay</a></li>
						</ul>
					</li> -->
				<?php endif; ?>


				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator) : ?>

					<li class="slide <?= in_array($active_url, array(
											"/sharesafari/default/index",
											"/sharesafari/default/view",
											// "/sharesafari/request/index",
											// "/sharesafari/request/view",
											"/sharesafari/share-safari-comment/index",
											"/sharesafari/default/fixed-departure",
											"/sharesafari/default/fixed-view",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/sharesafari/default/index",
														"/sharesafari/default/view",
														// "/sharesafari/request/index",
														// "/sharesafari/request/view",
														"/sharesafari/share-safari-comment/index",
														"/sharesafari/default/fixed-departure",
														"/sharesafari/default/fixed-view",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Share Safari</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Share Safari</a></li>
							<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>

								<!-- <li><a class="slide-item <?= in_array($active_url, array(
																	"/sharesafari/request/index",
																	"/sharesafari/request/view",
																)) ? "active" : "" ?>" href="/sharesafari/request/index">Share Safari Request</a></li> -->
							<?php endif; ?>

							<li><a class="slide-item <?= in_array($active_url, array(
															"/sharesafari/default/index",
															"/sharesafari/default/view",
														)) ? "active" : "" ?>" href="/sharesafari/default/index">Share Safari</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/sharesafari/default/fixed-departure",
															"/sharesafari/default/fixed-view",
														)) ? "active" : "" ?>" href="/sharesafari/default/fixed-departure">Fixed Departure</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																"/sharesafari/share-safari-comment/index",
																"/sharesafari/share-safari-comment/view",
															)) ? "active" : "" ?>" href="/sharesafari/share-safari-comment/index">Share Safari Comments</a></li> -->
						</ul>
					</li>
				<?php endif; ?>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) {  ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/sightings/default/index",
														"/sightings/default/create",
													)) ? "active" : "" ?>" href="/sightings/default/index"><img src="<?= $this->params['baseurl'] ?>/img/sighting.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Sightings</span></a>
					</li>
				<?php } ?>
				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) {  ?>


					<li class="slide"><a class="side-menu__item <?= in_array($active_url, array(
																	"/posts/default/index",
																	"/posts/default/create",

																)) ? "active" : "" ?>" href="/posts/default/index"><img src="<?= $this->params['baseurl'] ?>/img/post.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Posts</span></a>
					</li>
				<?php } ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide <?= in_array($active_url, array(
											"/package/default/index",
											"/package/default/create",
											"/package/profile",
											"/package/profile/itinerary",
											"/package/profile/inclusion",
											"/package/profile/exclusion",
											"/package/profile/term-condition",
											"/package/profile/create-term-condition",
											"/package/profile/update-term-condition",
											"/package/profile/faq",
											"/package/profile/create-faq",
											"/package/profile/faq-update",
											"/package/quote/index",
											"/package/quote",
											"/package/preview/index",
											"/packageapproval/default/index",
											"/packageapproval/default/view",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/package/default/index",
														"/package/default/create",
														"/package/profile",
														"/package/profile/itinerary",
														"/package/profile/inclusion",
														"/package/profile/exclusion",
														"/package/profile/term-condition",
														"/package/profile/create-term-condition",
														"/package/profile/update-term-condition",
														"/package/profile/faq",
														"/package/profile/create-faq",
														"/package/profile/faq-update",
														"/package/quote/index",
														"/package/quote",
														"/package/preview/index",
														"/packageapproval/default/index",
														"/packageapproval/default/view",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Package</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Package</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/package/default/index",
															"/package/default/create",
															"/package/profile",
															"/package/profile/itinerary",
															"/package/profile/inclusion",
															"/package/profile/exclusion",
															"/package/profile/term-condition",
															"/package/profile/create-term-condition",
															"/package/profile/update-term-condition",
															"/package/profile/faq",
															"/package/profile/create-faq",
															"/package/profile/faq-update",
														)) ? "active" : "" ?>" href="/package/default/index">Package List</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/package/quote/index",
															"/package/quote",
														)) ? "active" : "" ?>" href="/package/quote/index">Package Quote</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															"/packageapproval/default/index",
															"/packageapproval/default/view",
														)) ? "active" : "" ?>" href="/packageapproval/default/index">Package approval List</a></li>
						</ul>
					</li>

				<?php endif; ?>



				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_report_manager) : ?>
					<li class="slide <?= in_array($active_url, array(
											"/log/default/index",
											"/log/default/front-index",
											"/trierror/default/index",
											"/trierror/frontend-request-log",
											"/trierror/site-pages",
											"/trierror/site-untraced-request",
											"/trierror/default/front-index",
											"/portalsetting/log/index",
											"/portalsetting/log/front",
											"/portalsetting/log/console-log"
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/log/default/index",
														"/trierror",
														"/log/default/front-index",
														"/trierror/frontend-request-log",
														"/trierror/site-pages",
														"/trierror/site-untraced-request",
														"/trierror/default/front-index",
														"/portalsetting/log/index",
														"/portalsetting/log/front",
														"/portalsetting/log/console-log"
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Log</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/log/default/index")) ? "active" : "" ?>" href="/log/default/index">Mail Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/log/notification-log/index")) ? "active" : "" ?>" href="/log/notification-log/index">Notification Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/site-pages")) ? "active" : "" ?>" href="/trierror/site-pages">Site Pages</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/trierror/default/index")) ? "active" : "" ?>" href="/trierror/default/index">Backend Error Log</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/frontend-request-log")) ? "active" : "" ?>" href="/trierror/frontend-request-log">Frontend Request</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/site-untraced-request")) ? "active" : "" ?>" href="/trierror/site-untraced-request">Frontend Request Untraced</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/default/front-index")) ? "active" : "" ?>" href="/trierror/default/front-index">Frontend Request Error</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/index")) ? "active" : "" ?>" href="/portalsetting/log/index">Backend Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/front")) ? "active" : "" ?>" href="/portalsetting/log/front">Frontend Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/log/console-log")) ? "active" : "" ?>" href="/portalsetting/log/console-log">Console Log</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/api-request-log/index")) ? "active" : "" ?>" href="/trierror/api-request-log/index">Api Request Log</a></li>
						</ul>
					</li>
				<?php endif; ?>





				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_report_manager) : ?>
					<li class="slide <?= in_array($active_url, array(
											"/portalsetting/default/index",
											"/portalsetting/default/params",
											"/portalsetting/pageview/index",
											"/trierror/site-robots",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/portalsetting/default/index",
														"/portalsetting/default/params",
														"/portalsetting/pageview/index",
														"/trierror/site-robots",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Portal Settings</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Portal Settings</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/index")) ? "active" : "" ?>" href="/portalsetting/default/index">Php Info</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/params")) ? "active" : "" ?>" href="/portalsetting/default/params">Params</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/trierror/site-robots")) ? "active" : "" ?>" href="/trierror/site-robots">Robots Txt</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/clear-assets")) ? "active" : "" ?>" href="/portalsetting/default/clear-assets" data-method="post">Clear Backend Assets</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/clear-assets")) ? "active" : "" ?>" href="/portalsetting/default/clear-assets?type=frontend" data-method="post">Clear Frontend Assets</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/portalsetting/default/clear-cache")) ? "active" : "" ?>" href="/portalsetting/default/clear-cache" data-method="post">Clear Cache</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array("/portalsetting/pageview/index")) ? "active" : "" ?>" href="/portalsetting/pageview/index">Page View</a></li> -->
						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide <?= in_array($active_url, array(
											"/reportsection/default/index",
											"/reportsection/operator-quote-request/index",
											"/reportsection/package-quote-request/index",
											"/reportsection/comment-report/index",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/reportsection/default/index",
														"/reportsection/operator-quote-request/index",
														"/reportsection/package-quote-request/index",
														"/reportsection/comment-report/index",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Report Section</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Report Section</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/default/index")) ? "active" : "" ?>" href="/reportsection/default/index">Joined Report</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/operator-quote-request/index")) ? "active" : "" ?>" href="/reportsection/operator-quote-request/index">Operator Quote Report</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/package-quote-request/index")) ? "active" : "" ?>" href="/reportsection/package-quote-request/index">Package Quote Report</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/comment-report/index")) ? "active" : "" ?>" href="/reportsection/comment-report/index">Comment Report</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/comment-report/reply")) ? "active" : "" ?>" href="/reportsection/comment-report/reply">Reply Report</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/reportsection/share-safari-report/index")) ? "active" : "" ?>" href="/reportsection/share-safari-report/index">Share Safari Report</a></li>

						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) {  ?>
					<li class="slide <?= in_array($active_url, array(
											"/moderation/default/index",
										)) ? "is-expanded" : "" ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/moderation/default/index",
													)) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Moderation</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Moderation</a></li>
							<li><a class="slide-item <?= in_array($active_url, array("/moderation/default/index")) ? "active" : "" ?>" href="/moderation/default/index">Moderation</a></li>
						</ul>
					</li>
				<?php } ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/compliancedocuments",
														"/compliancedocuments/default/index",
													)) ? "active" : "" ?>" href="/compliancedocuments/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Compliance Documents</span></a>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/urlshortner",
														"/urlshortner/default/index",
													)) ? "active" : "" ?>" href="/urlshortner/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Url Shortner</span></a>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) { ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/home",
														"/home/default/index",
													)) ? "active" : "" ?>" href="/home/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">User Posts</span></a>
						<a class="side-menu__item <?= in_array($active_url, array(
														"/home",
														"/home/sighting/index",
													)) ? "active" : "" ?>" href="/home/sighting/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Sightings</span></a>
					</li>
				<?php } ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) { ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/leads",
														"/leads/default/index",
													)) ? "active" : "" ?>" href="/leads/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Leads</span></a>
					</li>
				<?php } ?>

				<?php if (Yii::$app->user->identity->is_adminstrator || Yii::$app->user->identity->is_admin) : ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/user",
														"/user/default/index",
														"/user/default/update",
														"/user/default/profile",
													)) ? "active" : "" ?>" href="/user/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Users</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/user/login-user",
														"/user/login-user/index",
													)) ? "active" : "" ?>" href="/user/login-user/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Login Users</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														"/contact",
														"/contact/default/index",
													)) ? "active" : "" ?>" href="/contact/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Contacts</span></a>
					</li>
				<?php endif; ?>



				<li class="slide">
					<a class="side-menu__item" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post"> <img src="<?= $this->params['baseurl'] ?>/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon">
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