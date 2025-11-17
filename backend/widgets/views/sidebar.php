<!-- BEGIN #sidebar -->
<?php
$active_url = '/' . Yii::$app->requestedRoute;
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
				<?php if (Yii::$app->user->identity->is_admin) { ?>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/leads',
														'/leads/default/index',
														'/leads/default/view',
														'/leads/default/operator-lead-chat',
													)) ? 'active' : '' ?>" href="/leads/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Leads</span></a>
					</li>
					<li class="slide">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/chat',
														'/chat/default/index',
													)) ? 'active' : '' ?>" href="/chat/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Chat</span></a>
					</li>
				<?php } ?>
				<?php if (Yii::$app->user->identity->is_admin): ?>

					<li class="slide <?= in_array($active_url, array(
											'/master',
											'/master/rare-animal/index',
											'/master/rare-animal/create',
											'/master/rare-animal/update',
											'/master/rare-animal/view',
											'/master/animal/index',
											'/master/animal/create',
											'/master/animal/update',
											'/master/vehicle/index',
											'/master/vehicle/create',
											'/master/vehicle/update',
											'/master/state/index',
											'/master/state/create',
											'/master/state/update',
											'/master/state/statefromfile',
											'/master/country/index',
											'/master/city/index',
											'/master/city/create',
											'/master/city/update',
											'/master/city/cityfromfile',
											'/master/location/index',
											'/master/location/create',
											'/master/location/update',
											'/master/railway-station/index',
											'/master/railway-station/create',
											'/master/railway-station/update',
											'/master/railway-station/railwayfromfile',
											'/master/airport/index',
											'/master/airport/create',
											'/master/airport/airportfromfile',
											'/master/bonus-experience/index',
											'/master/bonus-experience/create',
											'/master/bonus-experience/update',
											'/master/email/index',
											'/master/mail-template/index',
											'/master/mail-template/create',
											'/master/mail-template/update',
											'/master/operator-category/index',
											'/master/suggestion-category/index',
											'master/bonus-experience',
											'/master/packagefeature/index',
											'/master/packagefeature/create',
											'/master/packagefeature/update',
											'/master/packageinclude/index',
											'/master/packageinclude/create',
											'/master/packageinclude/update',
											'/master/packagetag/index',
											'/master/packagetag/create',
											'/master/packagetag/update',
											'/master/share-safari-reason/index',
											'/master/share-safari-reason/create',
											'/master/share-safari-reason/update',
											'/master/message/index',
											'/master/message/create',
											'/master/message/update',
											'/master/user-flag/index',
											'/master/user-flag/create',
											'/master/user-flag/update',
											'/master/notification-template/index',
											'/master/notification-template/create',
											'/master/sms-template/index',
											'/master/sms-template/create',
											'/master/operator-category/index',
											'/master/operator-category/create',
											'/master/operator-category/update',
											'/master/suggestion-category/index',
											'/master/suggestion-category/create',
											'/master/suggestion-category/update',
										)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/master',
														'/master/rare-animal/index',
														'/master/rare-animal/create',
														'/master/rare-animal/update',
														'/master/rare-animal/view',
														'/master/animal/index',
														'/master/animal/create',
														'/master/animal/update',
														'/master/vehicle/index',
														'/master/vehicle/create',
														'/master/vehicle/update',
														'/master/country/index',
														'/master/state/index',
														'/master/state/create',
														'/master/state/update',
														'/master/state/statefromfile',
														'/master/city/index',
														'/master/city/create',
														'/master/city/update',
														'/master/city/cityfromfile',
														'/master/location/index',
														'/master/location/create',
														'/master/location/update',
														'/master/railway-station/index',
														'/master/railway-station/create',
														'/master/railway-station/update',
														'/master/railway-station/railwayfromfile',
														'/master/airport/index',
														'/master/airport/create',
														'/master/airport/airportfromfile',
														'/master/bonus-experience/index',
														'/master/bonus-experience/create',
														'/master/bonus-experience/update',
														'/master/email/index',
														'/master/mail-template/index',
														'/master/mail-template/create',
														'/master/mail-template/update',
														'/master/operator-category/index',
														'/master/suggestion-category/index',
														'/master/packagefeature/index',
														'/master/packagefeature/create',
														'/master/packagefeature/update',
														'/master/packageinclude/index',
														'/master/packageinclude/create',
														'/master/packageinclude/update',
														'/master/share-safari-reason/index',
														'/master/share-safari-reason/create',
														'/master/share-safari-reason/update',
														'/master/message/index',
														'/master/message/create',
														'/master/message/update',
														'/master/user-flag/index',
														'/master/user-flag/create',
														'/master/user-flag/update',
														'/master/notification-template/index',
														'/master/notification-template/create',
														'/master/sms-template/index',
														'/master/sms-template/create',
														'/master/operator-category/index',
														'/master/operator-category/create',
														'/master/operator-category/update',
														'/master/suggestion-category/index',
														'/master/suggestion-category/create',
														'/master/suggestion-category/update',
														'/master/packagetag/index',
														'/master/packagetag/create',
														'/master/packagetag/update',
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/airport/index',
															'/master/airport/create',
															'/master/airport/airportfromfile',
														)) ? 'active' : '' ?>" href="/master/airport/index">Airport</a></li>

							<li class="sub-slide <?= in_array($active_url, array(
														'/master',
														'/master/animal/index',
														'/master/animal/create',
														'/master/animal/update',
														'/master/rare-animal/index',
														'/master/rare-animal/create',
														'/master/rare-animal/update',
														'/master/rare-animal/view',
													)) ? 'is-expanded' : '' ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Animal</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/master',
																'/master/animal/index',
																'/master/animal/create',
																'/master/animal/update',
																'/master/rare-animal/index',
																'/master/rare-animal/create',
																'/master/rare-animal/update',
																'/master/rare-animal/view',
															)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																							'/master',
																							'/master/animal/index',
																							'/master/animal/create',
																							'/master/animal/update',
																							'/master/rare-animal/index',
																							'/master/rare-animal/create',
																							'/master/rare-animal/update',
																							'/master/rare-animal/view',
																						)) ? 'display: block;' : 'display: none;' ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/master/rare-animal/index',
																			'/master/rare-animal/create',
																			'/master/rare-animal/update',
																			'/master/rare-animal/view',
																		)) ? 'active' : '' ?>" href="/master/rare-animal/index">Rare and Exotic</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/master/animal/index',
																			'/master/animal/create',
																			'/master/animal/update',
																		)) ? 'active' : '' ?>" href="/master/animal/index">Usual</a></li>
									<!-- <li><a class="sub-side-menu__item <?php  // in_array($active_url, array("/cms/feature-tag/index")) ? "active" : ""
																			?>" href="/cms/feature-tag/index">Article Tag</a></li> -->
								</ul>
							</li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/bonus-experience/index',
															'/master/bonus-experience/create',
															'/master/bonus-experience/update',
														)) ? 'active' : '/master/bonus-experience/index' ?>" href="/master/bonus-experience/index">Bonus Experience</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/state/index',
															'/master/state/create',
															'/master/state/update',
															'/master/state/statefromfile',
														)) ? 'active' : '' ?>" href="/master/state/index">State</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/city/index',
															'/master/city/create',
															'/master/city/update',
															'/master/city/cityfromfile',
														)) ? 'active' : '' ?>" href="/master/city/index">City</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/location/index',
															'/master/location/create',
															'/master/location/update',
														)) ? 'active' : '' ?>" href="/master/location/index">Location</a></li>


							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/mail-template/index',
															'/master/mail-template/create',
															'/master/mail-template/update',
														)) ? 'active' : '' ?>" href="/master/mail-template/index">Mail Template</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/notification-template/index',
															'/master/notification-template/create',
														)) ? 'active' : '' ?>" href="/master/notification-template/index">Notification Template</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/sms-template/index',
															'/master/sms-template/create',
														)) ? 'active' : '' ?>" href="/master/sms-template/index">SMS Template</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/operator-category/index',
															'/master/operator-category/create',
															'/master/operator-category/update',
														)) ? 'active' : '' ?>" href="/master/operator-category/index">Operator Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/packagefeature/index',
															'/master/packagefeature/create',
															'/master/packagefeature/update',
														)) ? 'active' : '' ?>" href="/master/packagefeature/index">Package Feature</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/packageinclude/index',
															'/master/packageinclude/create',
															'/master/packageinclude/update',
														)) ? 'active' : '' ?>" href="/master/packageinclude/index">Package Include</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/packagetag/index',
															'/master/packagetag/create',
															'/master/packagetag/update',
														)) ? 'active' : '' ?>" href="/master/packagetag/index">Package Tag</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/railway-station/index',
															'/master/railway-station/create',
															'/master/railway-station/update',
															'/master/railway-station/railwayfromfile',
														)) ? 'active' : '' ?>" href="/master/railway-station/index">Railway Station</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/share-safari-reason/index',
															'/master/share-safari-reason/create',
															'/master/share-safari-reason/update',
														)) ? 'active' : '' ?>" href="/master/share-safari-reason/index">Share Safari Reject Reason</a></li>


							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/suggestion-category/index',
															'/master/suggestion-category/create',
															'/master/suggestion-category/update',
														)) ? 'active' : '' ?>" href="/master/suggestion-category/index">Suggestion Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/vehicle/index',
															'/master/vehicle/create',
															'/master/vehicle/update',
														)) ? 'active' : '' ?>" href="/master/vehicle/index">Vehicle</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/master/user-flag/index',
															'/master/user-flag/create',
															'/master/user-flag/update',
														)) ? 'active' : '' ?>" href="/master/user-flag/index">User Flag</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																'/master/message/index',
																'/master/message/create',
																'/master/message/update',
															)) ? 'active' : '' ?>" href="/master/message/index">Message</a></li> -->

						</ul>
					</li>

					<li class="slide <?= in_array($active_url, array(
											'/meta',
											'/meta/term-condition-type',
											'/meta/wild-life-type',
											'/meta/zone-type',
											'/meta/stay-category',
											'/meta/tour-operator',
											'/meta/park-trip-slot',
											'/meta/operator-credibility',
											'/meta/package',
											'/meta/other-wildlife-activities',
											'/meta/animal-type',
											// "/meta/bird-type",
											'/meta/accommodation',
											'/meta/safari-session'
										)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/meta',
														'/meta/term-condition-type',
														'/meta/wild-life-type',
														'/meta/zone-type',
														'/meta/stay-category',
														'/meta/park-trip-slot',
														'/meta/operator-credibility',
														'/meta/package',
														'/meta/other-wildlife-activities',
														'/meta/animal-type',
														// "/meta/bird-type",
														'/meta/accommodation',
														'/meta/safari-session'
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Meta</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Meta</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/accommodation')) ? 'active' : '' ?>" href="/meta/accommodation">Accommodation</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/animal-type')) ? 'active' : '' ?>" href="/meta/animal-type">Animal Type</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array('/meta/bird-type')) ? 'active' : '' ?>" href="/meta/bird-type">Bird Type</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array('/meta/operator-credibility')) ? 'active' : '' ?>" href="/meta/operator-credibility">Operator Credibility</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/other-wildlife-activities')) ? 'active' : '' ?>" href="/meta/other-wildlife-activities">Other Wildlife Activities</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/package')) ? 'active' : '' ?>" href="/meta/package">Package</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/park-trip-slot')) ? 'active' : '' ?>" href="/meta/park-trip-slot">Park Trip Slot</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/safari-session')) ? 'active' : '' ?>" href="/meta/safari-session">Safari Session</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/stay-category')) ? 'active' : '' ?>" href="/meta/stay-category">Stay Category</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/term-condition-type')) ? 'active' : '' ?>" href="/meta/term-condition-type">Term & Condition Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/wild-life-type')) ? 'active' : '' ?>" href="/meta/wild-life-type">Wild Life Type</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/meta/zone-type')) ? 'active' : '' ?>" href="/meta/zone-type">Zone Type</a></li>
						</ul>
					</li>

				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_admin): ?>

					<li class="slide <?= in_array($active_url, array(
											'/park/safari/default/index',
											'/park/safari/default/create',
											'/park/safari/default/view',
											'/park/safari/profile',
											'/park/safari/profile/gallery',
											'/park/safari/profile/creategallery',
											'/park/safari/profile/updategallery',
											'/park/safari/profile/animal',
											'/park/safari/profile/createanimal',
											'/park/safari/profile/updateanimal',
											'/park/safari/profile/zone',
											'/park/safari/profile/createzone',
											'/park/safari/profile/updatezone',
											'/park/safari/profile/vehicle',
											'/park/safari/profile/createvehicle',
											'/park/safari/profile/updatevehicle',
											'/park/safari/profile/flora-fauna',
											'/park/safari/profile/createflorafauna',
											'/park/safari/profile/updateflorafauna',
											'/park/safari/profile/how-to-reach',
											'/park/safari/profile/createhowtoreach',
											'/park/safari/profile/updatehowtoreach',
											'/park/safari/profile/map',
											'/park/safari/profile/suggestions',
											'/park/operator-quote/index',
											'/park/operator-quote/view',
											'/park/safari-suggestion/index',
											'/park/safari/default/parkfromfile',
										)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/park/safari/default/index',
														'/park/safari/default/create',
														'/park/safari/default/view',
														'/park/safari/profile',
														'/park/safari/profile/gallery',
														'/park/safari/profile/creategallery',
														'/park/safari/profile/updategallery',
														'/park/safari/profile/animal',
														'/park/safari/profile/createanimal',
														'/park/safari/profile/updateanimal',
														'/park/safari/profile/zone',
														'/park/safari/profile/createzone',
														'/park/safari/profile/updatezone',
														'/park/safari/profile/vehicle',
														'/park/safari/profile/createvehicle',
														'/park/safari/profile/updatevehicle',
														'/park/safari/profile/flora-fauna',
														'/park/safari/profile/createflorafauna',
														'/park/safari/profile/updateflorafauna',
														'/park/safari/profile/how-to-reach',
														'/park/safari/profile/createhowtoreach',
														'/park/safari/profile/updatehowtoreach',
														'/park/safari/profile/map',
														'/park/safari/profile/suggestions',
														'/park/operator-quote/index',
														'/park/operator-quote/view',
														'/park/safari-suggestion/index',
														'/park/safari/default/parkfromfile'
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_park-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Parks</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Parks</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/park/safari/default/index',
															'/park/safari/default/create',
															'/park/safari/default/view',
															'/park/safari/profile',
															'/park/safari/profile/gallery',
															'/park/safari/profile/creategallery',
															'/park/safari/profile/updategallery',
															'/park/safari/profile/animal',
															'/park/safari/profile/createanimal',
															'/park/safari/profile/updateanimal',
															'/park/safari/profile/zone',
															'/park/safari/profile/createzone',
															'/park/safari/profile/updatezone',
															'/park/safari/profile/vehicle',
															'/park/safari/profile/createvehicle',
															'/park/safari/profile/updatevehicle',
															'/park/safari/profile/flora-fauna',
															'/park/safari/profile/createflorafauna',
															'/park/safari/profile/updateflorafauna',
															'/park/safari/profile/how-to-reach',
															'/park/safari/profile/createhowtoreach',
															'/park/safari/profile/updatehowtoreach',
															'/park/safari/profile/map',
															'/park/safari/profile/suggestions',
															'/park/safari/default/parkfromfile'
														)) ? 'active' : '' ?>" href="/park/safari/default/index">Safari Park</a></li>

							<!-- <li><a class="slide-item <?= in_array($active_url, array(
																'/park/operator-quote/index',
																'/park/operator-quote/view',
															)) ? 'active' : '' ?>" href="/park/operator-quote/index">Operator Quotes</a></li> -->
							<li><a class="slide-item <?= in_array($active_url, array(
															'/park/safari-suggestion/index',
														)) ? 'active' : '' ?>" href="/park/safari-suggestion/index">Safari Suggestion</a></li>

						</ul>
					</li>
				<?php endif; ?>

				<?php if (Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_cms_manager): ?>

					<li class="slide <?= in_array($active_url, array(
											'/cms',
											'/cms/article-category/index',
											'/cms/article-category/create',
											'/cms/article-category/update',
											'/cms/article-author/index',
											'/cms/article-author/create',
											'/cms/article-author/update',
											'/cms/article-tag/index',
											'/cms/article-tag/create',
											'/cms/article-tag/update',
											'/cms/article/index',
											'/cms/article/update',
											'/cms/article/create',
											'/cms/article/comment',
											'/cms/master-article-author/index',
											'/cms/master-article-author/create',
											'/cms/master-article-author/update',
											'/cms/banner',
											'/cms/about',
											'/cms/disclaimer',
											'/cms/privacypolicy',
											'/cms/termscondition',
											'/cms/faqcategory',
											'/cms/faqcategory/create',
											'/cms/faqcategory/update',
											'/cms/faqs',
											'/cms/faqs/create',
											'/cms/faqs/update',
											'/cms/feature-park/index',
											'/cms/banner/index',
											'/cms/banner/create',
											'/cms/banner/update',
											'/cms/frontend-banner',
											'/cms/frontend-banner/index',
											'/cms/frontend-banner/create',
											'/cms/frontend-banner/update',
											'/cms/feature-article/index',
											'/cms/feature-rare-exotic/index',
											'/cms/feature-tag/index',
											'/cms/content-management',
											'/cms/flag-reason',
											'/cms/flag-reason/create',
											'/cms/flag-reason/update',
											'/cms/master-tag/index',
											'/cms/master-tag/create',
											'/cms/master-tag/update',
											'/cms/master-category/index',
											'/cms/master-category/create',
											'/cms/master-category/update',
											'/cms/content-management',
											'/cms/content-management/update',
										)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/cms',
														'/cms/faqcategory',
														'/cms/faqcategory/create',
														'/cms/faqcategory/update',
														'/cms/faqs',
														'/cms/faqs/create',
														'/cms/faqs/update',
														'/cms/about/index',
														'/cms/disclaimer/index',
														'/cms/banner/index',
														'/cms/banner/create',
														'/cms/banner/update',
														'/cms/frontend-banner/index',
														'/cms/frontend-banner/create',
														'/cms/frontend-banner/update',
														'/cms/feature-park/index',
														'/cms/feature-article/index',
														'/cms/feature-rare-exotic/index',
														'/cms/feature-tag/index',
														'/cms/content-management',
														'/cms/flag-reason',
														'/cms/flag-reason/create',
														'/cms/flag-reason/update',
														'/cms/master-tag/index',
														'/cms/master-tag/create',
														'/cms/master-tag/update',
														'/cms/master-category/index',
														'/cms/master-category/create',
														'/cms/master-category/update',
														'/cms/content-management',
														'/cms/content-management/update',
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">CMS</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu <?= in_array($active_url, array(
													'/cms',
													'/cms/article-category/index',
													'/cms/article-category/create',
													'/cms/article-category/update',
													'/cms/article-author/index',
													'/cms/article-author/create',
													'/cms/article-author/update',
													'/cms/article-tag/index',
													'/cms/article-tag/create',
													'/cms/article-tag/update',
													'/cms/article/index',
													'/cms/article/update',
													'/cms/article/create',
													'/cms/article/comment',
													'/cms/master-article-author/index',
													'/cms/master-article-author/create',
													'/cms/master-article-author/update',
													'/cms/banner',
													'/cms/frontend-banner',
													'/cms/about',
													'/cms/disclaimer',
													'/cms/privacypolicy',
													'/cms/termscondition',
													'/cms/faqcategory',
													'/cms/faqcategory/create',
													'/cms/faqcategory/update',
													'/cms/faqs',
													'/cms/faqs/create',
													'/cms/faqs/update',
													'/cms/feature-park/index',
													'/cms/feature-article/index',
													'/cms/feature-rare-exotic/index',
													'/cms/feature-tag/index',
													'/cms/content-management',
													'/cms/content-management/update',
													'/cms/flag-reason',
													'/cms/flag-reason/create',
													'/cms/flag-reason/update',
													'/cms/master-tag/index',
													'/cms/master-tag/create',
													'/cms/master-tag/update',
													'/cms/master-category/index',
													'/cms/master-category/create',
													'/cms/master-category/update',
												)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																				'/cms',
																				'/cms/article-category/index',
																				'/cms/article-category/create',
																				'/cms/article-category/update',
																				'/cms/article-author/index',
																				'/cms/article-author/create',
																				'/cms/article-author/update',
																				'/cms/article-tag/index',
																				'/cms/article-tag/create',
																				'/cms/article-tag/update',
																				'/cms/article/index',
																				'/cms/article/update',
																				'/cms/article/create',
																				'/cms/article/comment',
																				'/cms/master-article-author/index',
																				'/cms/master-article-author/create',
																				'/cms/master-article-author/update',
																				'/cms/banner',
																				'/cms/frontend-banner',
																				'/cms/about',
																				'/cms/disclaimer',
																				'/cms/privacypolicy',
																				'/cms/termscondition',
																				'/cms/faqcategory',
																				'/cms/faqcategory/create',
																				'/cms/faqcategory/update',
																				'/cms/faqs',
																				'/cms/faqs/create',
																				'/cms/faqs/update',
																				'/cms/feature-park/index',
																				'/cms/banner/index',
																				'/cms/banner/create',
																				'/cms/banner/update',
																				'/cms/frontend-banner/index',
																				'/cms/frontend-banner/create',
																				'/cms/frontend-banner/update',
																				'/cms/feature-article/index',
																				'/cms/feature-rare-exotic/index',
																				'/cms/feature-tag/index',
																				'/cms/content-management',
																				'/cms/content-management/update',
																				'/cms/flag-reason',
																				'/cms/flag-reason/create',
																				'/cms/flag-reason/update',
																				'/cms/master-tag/index',
																				'/cms/master-tag/create',
																				'/cms/master-tag/update',
																				'/cms/master-category/index',
																				'/cms/master-category/create',
																				'/cms/master-category/update',
																			)) ? '' : 'display: none;' ?>">
							<li class="side-menu__label1"><a href="javascript:void(0);">CMS</a></li>


							<li class="sub-slide <?= in_array($active_url, array(
														'/cms',
														'/cms/article-category/index',
														'/cms/article-category/create',
														'/cms/article-category/update',
														'/cms/article-author/index',
														'/cms/article-author/create',
														'/cms/article-author/update',
														'/cms/article-tag/index',
														'/cms/article-tag/create',
														'/cms/article-tag/update',
														'/cms/article/index',
														'/cms/article/update',
														'/cms/article/create',
														'/cms/article/comment',
														'/cms/master-article-author/index',
														'/cms/master-article-author/create',
														'/cms/master-article-author/update',
													)) ? 'is-expanded' : '' ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Article</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/cms',
																'/cms/article-category/index',
																'/cms/article-category/create',
																'/cms/article-category/update',
																'/cms/article-author/index',
																'/cms/article-author/create',
																'/cms/article-author/update',
																'/cms/article-tag/index',
																'/cms/article-tag/create',
																'/cms/article-tag/update',
																'/cms/article/index',
																'/cms/article/update',
																'/cms/article/create',
																'/cms/article/comment',
																'/cms/master-article-author/index',
																'/cms/master-article-author/create',
																'/cms/master-article-author/update',
															)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																							'/cms',
																							'/cms/article-category/index',
																							'/cms/article-category/create',
																							'/cms/article-category/update',
																							'/cms/article-author/index',
																							'/cms/article-author/create',
																							'/cms/article-author/update',
																							'/cms/article-tag/index',
																							'/cms/article-tag/create',
																							'/cms/article-tag/update',
																							'/cms/article/index',
																							'/cms/article/update',
																							'/cms/article/create',
																							'/cms/article/comment',
																							'/cms/master-article-author/index',
																							'/cms/master-article-author/create',
																							'/cms/master-article-author/update',
																						)) ? 'display: block;' : 'display: none;' ?>">

									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/cms/master-article-author/index',
																			'/cms/master-article-author/create',
																			'/cms/master-article-author/update',
																		)) ? 'active' : '' ?>" href="/cms/master-article-author/index">Article Author</a></li>

									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/cms/article/index',
																			'/cms/article/update',
																			'/cms/article/create',
																			'/cms/article/comment',
																		)) ? 'active' : '' ?>" href="/cms/article/index">Article</a></li>



								</ul>
							</li>
							<li><a class="slide-item <?= in_array($active_url, array('/cms/banner/index', '/cms/banner/create', '/cms/banner/update')) ? 'active' : '' ?>" href="/cms/banner/index">Banners</a></li>
							<li><a class="slide-item <?= in_array($active_url, array('/cms/content-management', '/cms/content-management/update')) ? 'active' : '' ?>" href="/cms/content-management">Content Management</a></li>
							<li class="sub-slide <?= in_array($active_url, array(
														'/cms',
														'/cms/faqcategory',
														'/cms/faqcategory/create',
														'/cms/faqcategory/update',
														'/cms/faqs',
														'/cms/faqs/create',
														'/cms/faqs/update',
													)) ? 'is-expanded' : '' ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">FAQs</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/cms',
																'/cms/faqcategory',
																'/cms/faqcategory/create',
																'/cms/faqcategory/update',
																'/cms/faqs',
																'/cms/faqs/create',
																'/cms/faqs/update',
															)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																							'/cms',
																							'/cms/faqcategory',
																							'/cms/faqs',
																							'/cms/faqs/create',
																							'/cms/faqs/update',
																							'/cms/faqcategory/create',
																							'/cms/faqcategory/update',
																						)) ? 'display: block;' : 'display: none;' ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/cms/faqcategory',
																			'/cms/faqcategory/create',
																			'/cms/faqcategory/update',
																		)) ? 'active' : '' ?>" href="/cms/faqcategory">FAQ Category</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array(
																			'/cms/faqs',
																			'/cms/faqs/create',
																			'/cms/faqs/update',
																		)) ? 'active' : '' ?>" href="/cms/faqs">FAQs</a></li>
								</ul>
							</li>

							<li class="sub-slide <?= in_array($active_url, array(
														'/cms',
														'/cms/feature-park/index',
														'/cms/feature-article/index',
														'/cms/feature-rare-exotic/index',
														'/cms/feature-tag/index',
													)) ? 'is-expanded' : '' ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Feature</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/cms',
																'/cms/feature-park/index',
																'/cms/feature-article/index',
																'/cms/feature-rare-exotic/index',
																'/cms/feature-tag/index',
															)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																							'/cms',
																							'/cms/feature-park/index',
																							'/cms/feature-article/index',
																							'/cms/feature-rare-exotic/index',
																							'/cms/feature-tag/index',
																						)) ? 'display: block;' : 'display: none;' ?>">
									<li><a class="sub-side-menu__item <?= in_array($active_url, array('/cms/feature-park/index')) ? 'active' : '' ?>" href="/cms/feature-park/index">Park</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array('/cms/feature-article/index')) ? 'active' : '' ?>" href="/cms/feature-article/index">Article</a></li>
									<li><a class="sub-side-menu__item <?= in_array($active_url, array('/cms/feature-rare-exotic/index')) ? 'active' : '' ?>" href="/cms/feature-rare-exotic/index">RARE AND EXOTIC</a></li>
									<!-- <li><a class="sub-side-menu__item <?php  // in_array($active_url, array("/cms/feature-tag/index")) ? "active" : ""
																			?>" href="/cms/feature-tag/index">Article Tag</a></li> -->
								</ul>
							</li>


							<li><a class="slide-item <?= in_array($active_url, array('/cms/frontend-banner/index', '/cms/frontend-banner/create', '/cms/frontend-banner/update')) ? 'active' : '' ?>" href="/cms/frontend-banner/index">Frontend Banner</a></li>
							<!-- <li><a class="slide-item <?= in_array($active_url, array('/cms/about')) ? 'active' : '' ?>" href="/cms/about">About</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array('/cms/disclaimer')) ? 'active' : '' ?>" href="/cms/disclaimer">Disclaimer</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array('/cms/privacypolicy')) ? 'active' : '' ?>" href="/cms/privacypolicy">Privacy Policy</a></li> -->
							<!-- <li><a class="slide-item <?= in_array($active_url, array('/cms/termscondition')) ? 'active' : '' ?>" href="/cms/termscondition">Team & Conditions</a></li> -->

							<li><a class="slide-item <?= in_array($active_url, array(
															'/cms/flag-reason',
															'/cms/flag-reason/create',
															'/cms/flag-reason/update',
														)) ? 'active' : '' ?>" href="/cms/flag-reason">Flag Reason</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/cms/master-tag/index',
															'/cms/master-tag/create',
															'/cms/master-tag/update',
														)) ? 'active' : '' ?>" href="/cms/master-tag/index">Tags</a></li>

							<li><a class="slide-item <?= in_array($active_url, array(
															'/cms/master-category/index',
															'/cms/master-category/create',
															'/cms/master-category/update',
														)) ? 'active' : '' ?>" href="/cms/master-category/index">Topics</a></li>

						</ul>
					</li>
				<?php endif; ?>
				<?php if (Yii::$app->user->identity->is_admin): ?>

					<!-- <li class="slide <?= in_array($active_url, array(
												'/registration/safari-operator-tour',
												'/registration/safari-operator-tour/index',
												'/registration/safari-operator-tour/view',
												'/registration/safari-operator-tour/create',
												'/registration/safari-operator-tour/update',
												// "/registration/birding-operator-tour",
												// "/registration/birding-operator-tour/index",
												// "/registration/birding-operator-tour/view",
												// "/registration/birding-operator-tour/create",
												// "/registration/birding-operator-tour/update",
											)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/registration/safari-operator-tour',
														'/registration/safari-operator-tour/index',
														'/registration/safari-operator-tour/view',
														'/registration/safari-operator-tour/create',
														'/registration/safari-operator-tour/update',
														// "/registration/birding-operator-tour",
														// "/registration/birding-operator-tour/index",
														// "/registration/birding-operator-tour/view",
														// "/registration/birding-operator-tour/create",
														// "/registration/birding-operator-tour/update",
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_app-registration.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Registrations</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Registrations</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/registration/safari-operator-tour',
															'/registration/safari-operator-tour/index',
															'/registration/safari-operator-tour/view',
															'/registration/safari-operator-tour/create',
															'/registration/safari-operator-tour/update',
														)) ? 'active' : '' ?>" href="/registration/safari-operator-tour">Safari Tour Operator</a></li>
							
						</ul>
					</li> -->

					<li class="slide <?= in_array($active_url, array(
											'/operator/safari-operator/index',
											'/operator/safari-operator/index/view',
											'/operator/safari-operator/index',
											'/operator/safari-operator/index/view',
											'/gallery/default/index',
											'/gallery/default/view',
											'/operator/safari-operator/index',
											'/operator/safari-operator/index/view',
											'/operator/safari-operator/index',
											'/operator/safari-operator/view',
											'/operator/safari-operator/quote',
											'/operator/safari-operator/review',
											'/operator/safari-operator/operator-parks',
											'/operator/safari-operator/bank-and-kyc-details',
											'/operator/safari-operator/update-details',
											'/leadoperatorwise/default/index',
											'/leadoperatorwise/default/view',
											'/operatorapproval/default/index',
											'/operatorapproval/default/view',
											'/operatorapproval/default/update',
										)) ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= in_array($active_url, array(
														'/operator/safari-operator/index',
														'/operator/safari-operator/view',
													)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Operator</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">

							<li class="side-menu__label1"><a href="javascript:void(0);">Gallery List</a></li>
							<li class="slide"><a class="slide-item <?= in_array($active_url, array(
																		'/gallery/default/index',
																		// "/galleryapproval/default/index",
																		'/gallery/default/view'
																	)) ? 'active' : '' ?>" href="/gallery/default/index">Gallery List</a>
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator approval List</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/operatorapproval/default/index',
															'/operatorapproval/default/view',
															'/operatorapproval/default/update',
														)) ? 'active' : '' ?>" href="/operatorapproval/default/index">Operator approval List</a></li>
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator</a></li>
							<li><a class="slide-item <?= in_array($active_url, array(
															'/operator/safari-operator/index',
															'/operator/safari-operator/view',
															'/operator/safari-operator/quote',
															'/operator/safari-operator/review',
															'/operator/safari-operator/operator-parks',
															'/operator/safari-operator/bank-and-kyc-details',
															'/operator/safari-operator/update-details',
															'/leadoperatorwise/default/index',
															'/leadoperatorwise/default/view',
														)) ? 'active' : '' ?>" href="/operator/safari-operator/index">Safari Tour Operator</a></li>

					</li>

			</ul>
			</li>



			<li class="slide <?= in_array($active_url, array(
									'/pendingapproval/article-comment/index',
									'/pendingapproval/article-comment/view',
									'/pendingapproval/park-review-approval/index',
									'/pendingapproval/operator-review/index',
									'/sharesafari/fixed-departure/index',
									'/sharesafari/fixed-departure/view',
									'/galleryapproval/default/index',
									'/galleryapproval/default/view',
									'/packageapproval/default/index',
									'/packageapproval/default/view',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/pendingapproval/article-comment/index',
												'/pendingapproval/article-comment/view',
												'/pendingapproval/park-review-approval/index',
												'/pendingapproval/operator-review/index',
												'/sharesafari/fixed-departure/index',
												'/sharesafari/fixed-departure/view',
												'/galleryapproval/default/index',
												'/galleryapproval/default/view',
												'/packageapproval/default/index',
												'/packageapproval/default/view',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Pending Approvals</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Pending Approvals</a></li>
					<!-- <li><a class="slide-item <?= in_array($active_url, array(
														'/pendingapproval/article-comment/index',
														'/pendingapproval/article-comment/view',
													)) ? 'active' : '' ?>" href="/pendingapproval/article-comment/index">Article Comments</a></li> -->
					<!-- <li><a class="slide-item <?= in_array($active_url, array(
														'/pendingapproval/user-article/index',
														'/pendingapproval/user-article/view',
													)) ? 'active' : '' ?>" href="/pendingapproval/user-article/index">User Article Approvals</a></li> -->

					<li><a class="slide-item <?= in_array($active_url, array(
													'/sharesafari/fixed-departure/index',
													'/sharesafari/fixed-departure/view',
												)) ? 'active' : '' ?>" href="/sharesafari/fixed-departure/index">Fixed Departure Approvals</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/galleryapproval/default/index',
													'/galleryapproval/default/view',
												)) ? 'active' : '' ?>" href="/galleryapproval/default/index">Gallery Approvals</a></li>

					<li><a class="slide-item <?= in_array($active_url, array(
													'/packageapproval/default/index',
													'/packageapproval/default/view',
												)) ? 'active' : '' ?>" href="/packageapproval/default/index">Package Approvals</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/pendingapproval/park-review-approval/index',
												)) ? 'active' : '' ?>" href="/pendingapproval/park-review-approval/index">Park Review Approvals</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/pendingapproval/operator-review/index',
												)) ? 'active' : '' ?>" href="/pendingapproval/operator-review/index">Operator Review Approvals</a></li>

				</ul>
			</li>


			<li class="slide <?= in_array($active_url, array(
									'/flag/operator/index',
									'/flag/operator/view',
									'/flag/package/index',
									'/flag/package/view',
									'/flag/share-safari/index',
									'/flag/share-safari/view',
									'/flag/untraced-flag/index',
									'/flag/user-post/index',
									'/flag/user-post/view',
									'/flag/sighting/index',
									'/flag/sighting/view',
									'/flag/article/index',
									'/flag/article/view',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/flag/operator/index',
												'/flag/operator/view',
												'/flag/share-safari/index',
												'/flag/share-safari/view',
												'/flag/package/index',
												'/flag/package/view',
												'/flag/untraced-flag/index',
												'/flag/user-post/index',
												'/flag/user-post/view',
												'/flag/sighting/index',
												'/flag/sighting/view',
												'/flag/article/index',
												'/flag/article/view',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Flag</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Flag</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/operator/index',
													'/flag/operator/view',
												)) ? 'active' : '' ?>" href="/flag/operator/index">Operator Comments</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/package/index',
													'/flag/package/view',
												)) ? 'active' : '' ?>" href="/flag/package/index">Package Comments</a></li>

					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/share-safari/index',
													'/flag/share-safari/view',
												)) ? 'active' : '' ?>" href="/flag/share-safari/index">Share Safari Comments</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/user-post/index',
													'/flag/user-post/view',
												)) ? 'active' : '' ?>" href="/flag/user-post/index">Post Comments</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/sighting/index',
													'/flag/sighting/view',
												)) ? 'active' : '' ?>" href="/flag/sighting/index">Sighting Comments</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/article/index',
													'/flag/article/view',
												)) ? 'active' : '' ?>" href="/flag/article/index">Article Comments</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/flag/untraced-flag/index',
												)) ? 'active' : '' ?>" href="/flag/untraced-flag/index">Untraced Flags</a></li>


				</ul>
			</li>
		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator): ?>
			<!-- <li class="slide <?= str_starts_with($active_url, '/operatordashboard') ? 'is-expanded' : '' ?>">
						<a class="side-menu__item <?= str_starts_with($active_url, '/operatordashboard') ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Operator</span><i class="angle fe fe-chevron-right"></i></a>
						<ul class="slide-menu">
							<li class="side-menu__label1"><a href="javascript:void(0);">Operator</a></li>
							<li class="sub-slide <?= in_array($active_url, array(
														'/operatordashboard/safari'
													)) ? 'is-expanded' : '' ?>">
								<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Safari Tour Operator</span><i class="sub-angle fe fe-chevron-right"></i></a>
								<ul class="sub-slide-menu <?= in_array($active_url, array(
																'/operatordashboard/safari',
																'/operatordashboard/safari/index',
																'/operatordashboard/safari/quote',
																'/operatordashboard/safari/sharedsafari',
																'/operatordashboard/safari/review',
																'/operatordashboard/safari/follower',
															)) ? 'open' : '' ?>" style="<?= in_array($active_url, array(
																							'/operatordashboard/safari',
																							'/operatordashboard/safari/index',
																							'/operatordashboard/safari/quote',
																							'/operatordashboard/safari/sharedsafari',
																							'/operatordashboard/safari/review',
																							'/operatordashboard/safari/follower',
																						)) ? 'display: block;' : 'display: none;' ?>">
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/index') ? 'active' : '' ?>" href="/operatordashboard/safari/index">Overview</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/quote') ? 'active' : '' ?>" href="/operatordashboard/safari/quote">Get a Free Quote</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/sharedsafari') ? 'active' : '' ?>" href="/operatordashboard/safari/sharedsafari">Shared Safari</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/review') ? 'active' : '' ?>" href="/operatordashboard/safari/review">User Review</a></li>
									<li><a class="slide-item <?= str_starts_with($active_url, '/operatordashboard/safari/follower') ? 'active' : '' ?>" href="/operatordashboard/safari/follower">Follower</a></li>


								</ul>
							</li>
							
							<li><a class="slide-item" href="#">Resort/Lodge/Homen Stay</a></li>
						</ul>
					</li> -->
		<?php endif; ?>


		<?php if (Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_safari_operator || Yii::$app->user->identity->is_birding_operator): ?>

			<li class="slide <?= in_array($active_url, array(
									'/sharesafari/default/index',
									'/sharesafari/default/view',
									// "/sharesafari/request/index",
									// "/sharesafari/request/view",
									'/sharesafari/share-safari-comment/index',
									'/sharesafari/default/fixed-departure',
									'/sharesafari/default/fixed-view',
									'/sharesafari/default/reject-list',
									'/sharesafari/default/chat-view',
									'/sharesafari/default/booked-user',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/sharesafari/default/index',
												'/sharesafari/default/view',
												// "/sharesafari/request/index",
												// "/sharesafari/request/view",
												'/sharesafari/share-safari-comment/index',
												'/sharesafari/default/fixed-departure',
												'/sharesafari/default/fixed-view',
												'/sharesafari/default/reject-list',
												'/sharesafari/default/chat-view',
												'/sharesafari/default/booked-user',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/mingcute_meta-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Share Safari</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Share Safari</a></li>
					<?php if (Yii::$app->user->identity->is_admin): ?>

						<!-- <li><a class="slide-item <?= in_array($active_url, array(
															'/sharesafari/request/index',
															'/sharesafari/request/view',
														)) ? 'active' : '' ?>" href="/sharesafari/request/index">Share Safari Request</a></li> -->
					<?php endif; ?>

					<li><a class="slide-item <?= in_array($active_url, array(
													'/sharesafari/default/fixed-departure',
													'/sharesafari/default/fixed-view',
													'/sharesafari/default/reject-list',
													'/sharesafari/default/chat-view',
													'/sharesafari/default/booked-user',
												)) ? 'active' : '' ?>" href="/sharesafari/default/fixed-departure">Fixed Departure</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/sharesafari/default/index',
													'/sharesafari/default/view',
												)) ? 'active' : '' ?>" href="/sharesafari/default/index">Share Safari</a></li>

					<!-- <li><a class="slide-item <?= in_array($active_url, array(
														'/sharesafari/share-safari-comment/index',
														'/sharesafari/share-safari-comment/view',
													)) ? 'active' : '' ?>" href="/sharesafari/share-safari-comment/index">Share Safari Comments</a></li> -->
				</ul>
			</li>
		<?php endif; ?>
		<?php if (Yii::$app->user->identity->is_admin) { ?>
			<li class="slide">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/sightings/default/index',
												'/sightings/default/view',
											)) ? 'active' : '' ?>" href="/sightings/default/index"><img src="<?= $this->params['baseurl'] ?>/img/sighting.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Sightings</span></a>
			</li>
		<?php } ?>
		<?php if (Yii::$app->user->identity->is_admin) { ?>


			<li class="slide"><a class="side-menu__item <?= in_array($active_url, array(
															'/posts/default/index',
															'/posts/default/view',
														)) ? 'active' : '' ?>" href="/posts/default/index"><img src="<?= $this->params['baseurl'] ?>/img/post.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Posts</span></a>
			</li>
		<?php } ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide <?= in_array($active_url, array(
									'/package/default/index',
									'/package/default/create',
									'/package/default/reject-list',
									'/package/profile',
									'/package/profile/itinerary',
									'/package/profile/inclusion',
									'/package/profile/exclusion',
									'/package/profile/term-condition',
									'/package/profile/create-term-condition',
									'/package/profile/update-term-condition',
									'/package/profile/faq',
									'/package/profile/create-faq',
									'/package/profile/faq-update',
									'/package/preview/index',
									'/packageapproval/default/index',
									'/packageapproval/default/view',
									'/package/preview/index',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/package/default/index',
												'/package/default/create',
												'/package/default/reject-list',
												'/package/profile',
												'/package/profile/itinerary',
												'/package/profile/inclusion',
												'/package/profile/exclusion',
												'/package/profile/term-condition',
												'/package/profile/create-term-condition',
												'/package/profile/update-term-condition',
												'/package/profile/faq',
												'/package/profile/create-faq',
												'/package/profile/faq-update',
												'/package/preview/index',
												'/packageapproval/default/index',
												'/packageapproval/default/view',
												'/package/preview/index',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Package</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Package</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/package/default/index',
													'/package/default/create',
													'/package/default/reject-list',
													'/package/profile',
													'/package/profile/itinerary',
													'/package/profile/inclusion',
													'/package/profile/exclusion',
													'/package/profile/term-condition',
													'/package/profile/create-term-condition',
													'/package/profile/update-term-condition',
													'/package/profile/faq',
													'/package/profile/create-faq',
													'/package/profile/faq-update',
													'/package/preview/index',
												)) ? 'active' : '' ?>" href="/package/default/index">Package List</a></li>
					<!-- <li><a class="slide-item <?= in_array($active_url, array(
														'/packageapproval/default/index',
														'/packageapproval/default/view',
													)) ? 'active' : '' ?>" href="/packageapproval/default/index">Package Approval</a></li> -->

				</ul>
			</li>

		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide <?= in_array($active_url, array(
									'/user',
									'/user/default/index',
									'/user/default/create',
									'/user/default/update',
									'/user/default/profile',
									'/user/login-user',
									'/user/login-user/index',
									'/userdeleterequest/default/index',
									'/userprivacypolicyacknowledgement',
									'/userprivacypolicyacknowledgement/default/index',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/user',
												'/user/default/index',
												'/user/default/create',
												'/user/default/update',
												'/user/default/profile',
												'/user/login-user',
												'/user/login-user/index',
												'/userdeleterequest/default/index',
												'/userprivacypolicyacknowledgement',
												'/userprivacypolicyacknowledgement/default/index',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/iconoir_safari.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">User</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">User</a></li>
					<li><a class="slide-item <?= in_array($active_url, array(
													'/user',
													'/user/default/index',
													'/user/default/create',
													'/user/default/update',
													'/user/default/profile',
												)) ? 'active' : '' ?>" href="/user/default/index">User List</a></li>

					<li><a class="slide-item <?= in_array($active_url, array(
													'/user/login-user',
													'/user/login-user/index',
												)) ? 'active' : '' ?>" href="/user/login-user/index">Login Users</a></li>


					<li><a class="slide-item <?= in_array($active_url, array(
													'/userdeleterequest/default/index',
												)) ? 'active' : '' ?>" href="/userdeleterequest/default/index">User Delete Request</a></li>

					<li><a class="slide-item  <?= in_array($active_url, array(
													'/userprivacypolicyacknowledgement',
													'/userprivacypolicyacknowledgement/default/index',
												)) ? 'active' : '' ?>" href="/userprivacypolicyacknowledgement/default/index">User Privacy Policy Ackmowledgement</a></li>

				</ul>
			</li>

		<?php endif; ?>


		<?php if (Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_report_manager): ?>
			<li class="slide <?= in_array($active_url, array(
									'/log/default/index',
									'/log/default/view',
									'/log/default/front-index',
									'/log/transaction/view',
									'/trierror/default/index',
									'/log/sms-log/index',
									'/log/call-log/index',
									'/trierror/site-pages',
									'/trierror/site-pages/view',
									'/trierror/default/front-index',
									'/portalsetting/log/index',
									'/portalsetting/log/front',
									'/portalsetting/log/console-log',
									'/log/notification-log/index',
									'/trierror/api-request-log/index',
									'/trierror/api-request-log/view',
									'/log/transaction',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/log/default/index',
												'/log/default/view',
												'/log/transaction',
												'/log/transaction/view',
												'/trierror',
												'/log/default/front-index',
												'/trierror/site-pages',
												'/trierror/site-pages/view',
												'/log/sms-log/index',
												'/log/call-log/index',
												'/trierror/default/front-index',
												'/portalsetting/log/index',
												'/portalsetting/log/front',
												'/portalsetting/log/console-log',
												'/log/notification-log/index',
												'/trierror/api-request-log/index',
												'/trierror/api-request-log/view',
												'/log/transaction',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Log</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/log/transaction', '/log/transaction/view')) ? 'active' : '' ?>" href="/log/transaction">Transaction Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/trierror/api-request-log/index', '/trierror/api-request-log/view')) ? 'active' : '' ?>" href="/trierror/api-request-log/index">Api Request Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/log/index')) ? 'active' : '' ?>" href="/portalsetting/log/index">Backend Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/log/call-log/index')) ? 'active' : '' ?>" href="/log/call-log/index">Call Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/log/console-log')) ? 'active' : '' ?>" href="/portalsetting/log/console-log">Console Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/log/front')) ? 'active' : '' ?>" href="/portalsetting/log/front">Frontend Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/trierror/default/front-index')) ? 'active' : '' ?>" href="/trierror/default/front-index">Frontend Request Error</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/log/default/index', '/log/default/view')) ? 'active' : '' ?>" href="/log/default/index">Mail Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/log/notification-log/index')) ? 'active' : '' ?>" href="/log/notification-log/index">Notification Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/log/sms-log/index')) ? 'active' : '' ?>" href="/log/sms-log/index">SMS Log</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/trierror/site-pages', '/trierror/site-pages/view')) ? 'active' : '' ?>" href="/trierror/site-pages">Site Pages</a></li>
					<!-- <li><a class="slide-item <?= in_array($active_url, array('/trierror/default/index')) ? 'active' : '' ?>" href="/trierror/default/index">Backend Error Log</a></li> -->

				</ul>
			</li>
		<?php endif; ?>


		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide <?= in_array($active_url, array(
									'/transactioninfo/default/index',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/transactioninfo/default/index',
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Transaction Info</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Transaction</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/transactioninfo/default/index')) ? 'active' : '' ?>" href="/transactioninfo/default/index">Transaction Details</a></li>
				</ul>
			</li>
		<?php endif; ?>


		<?php if (Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_report_manager): ?>
			<li class="slide <?= in_array($active_url, array(
									'/portalsetting/default/index',
									'/portalsetting/default/params',
									'/portalsetting/default/clear-assets',
									'/portalsetting/default/clear-cache',
									'/portalsetting/default/clear-assets?type=frontend'
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/portalsetting/default/index',
												'/portalsetting/default/params',
												'/portalsetting/default/clear-assets',
												'/portalsetting/default/clear-cache',
												'/portalsetting/default/clear-assets?type=frontend'
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Portal Settings</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Portal Settings</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/default/clear-assets')) ? 'active' : '' ?>" href="/portalsetting/default/clear-assets" data-method="post">Clear Backend Assets</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/default/clear-assets')) ? 'active' : '' ?>" href="/portalsetting/default/clear-assets?type=frontend" data-method="post">Clear Frontend Assets</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/default/clear-cache')) ? 'active' : '' ?>" href="/portalsetting/default/clear-cache" data-method="post">Clear Cache</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/default/index')) ? 'active' : '' ?>" href="/portalsetting/default/index">Php Info</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/portalsetting/default/params')) ? 'active' : '' ?>" href="/portalsetting/default/params">Params</a></li>
				</ul>
			</li>
		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide <?= in_array($active_url, array(
									'/reportsection/default/index',
									'/reportsection/operator-quote-request/index',
									'/reportsection/comment-report/index',
									'/reportsection/comment-report/reply',
									'/reportsection/share-safari-report/index',
								)) ? 'is-expanded' : '' ?>">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/reportsection/default/index',
												'/reportsection/operator-quote-request/index',
												'/reportsection/comment-report/index',
												'/reportsection/comment-report/reply',
												'/reportsection/share-safari-report/index'
											)) ? 'active' : '' ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Report Section</span><i class="angle fe fe-chevron-right"></i></a>
				<ul class="slide-menu">
					<li class="side-menu__label1"><a href="javascript:void(0);">Report Section</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/reportsection/comment-report/index')) ? 'active' : '' ?>" href="/reportsection/comment-report/index">Comment Report</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/reportsection/default/index')) ? 'active' : '' ?>" href="/reportsection/default/index">Joined Report</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/reportsection/operator-quote-request/index')) ? 'active' : '' ?>" href="/reportsection/operator-quote-request/index">Operator Quote Report</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/reportsection/comment-report/reply')) ? 'active' : '' ?>" href="/reportsection/comment-report/reply">Reply Report</a></li>
					<li><a class="slide-item <?= in_array($active_url, array('/reportsection/share-safari-report/index')) ? 'active' : '' ?>" href="/reportsection/share-safari-report/index">Share Safari Report</a></li>

				</ul>
			</li>
		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_admin) { ?>

			<li class="slide">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/moderation/default/index',
												'/moderation/default/create',
												'/moderation/default/view',
											)) ? 'active' : '' ?>" href="/moderation/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Moderation</span></a>
			</li>
		<?php } ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/compliancedocuments',
												'/compliancedocuments/default/index',
												'/compliancedocuments/default/view',
												'/compliancedocuments/default/update',
											)) ? 'active' : '' ?>" href="/compliancedocuments/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Compliance Documents</span></a>
			</li>
		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/urlshortner',
												'/urlshortner/default/index',
												'/urlshortner/default/create',
											)) ? 'active' : '' ?>" href="/urlshortner/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Url Shortner</span></a>
			</li>
		<?php endif; ?>

		<?php if (Yii::$app->user->identity->is_admin): ?>
			<li class="slide">
				<a class="side-menu__item <?= in_array($active_url, array(
												'/contact',
												'/contact/default/index',
											)) ? 'active' : '' ?>" href="/contact/default/index"><img src="<?= $this->params['baseurl'] ?>/img/carbon_workspace.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Contacts</span></a>
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