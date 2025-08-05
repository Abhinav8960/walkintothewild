<?php
$active_url = '/' . Yii::$app->requestedRoute;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<nav class="side_bar sidebar-offcanvas d-flex justify-content-center">
    <ul class="nav">
        <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item mb-5">
            <div class="profile-ditails d-flex justify-content-around align-items-center">
                <div class="pro-img me-3">
                    <a href="/">
                        <img src="<?= $this->params['baseurl'] ?>/images/sp.jpg" alt="">
                        <span class="success-online"></span>
                    </a>
                </div>
            </div>
            <button class="navbar-toggler navbar-toggler align-self-center d-lg-block d-none" type="button"
                data-toggle="minimize" id="hider-sidebar">
                <span class="mdi mdi-menu"></span>
            </button>
        </li>
        <div class="scroll-custom">
        <li class="navItems mb-2">
            <a href="/" class="navLinks d-flex align-items-center <?= in_array($active_url, ['/']) ? 'active' : '' ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/',
                                                                                                )) ? 'Home2.svg' : 'home.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Dashboard</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                '/leads/default/index',
                                                                '/leads/default/create',
                                                                '/leads/default/view',
                                                            )) ? 'active' : '' ?>" href="/leads/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/leads/default/index',
                                                                                                    '/leads/default/create',
                                                                                                    '/leads/default/view',
                                                                                                )) ? 'Frame_new.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Leads</span>
            </a>
        </li>


        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                '/sightings/default/index',
                                                                '/sightings/default/create',
                                                            )) ? 'active' : '' ?>" href="/sightings/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/sightings/default/index',
                                                                                                    '/sightings/default/create',
                                                                                                    '/sightings/default/view',
                                                                                                )) ? 'Sighting_active.svg' : 'Sighting.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu"> Sightings</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                '/posts/default/index',
                                                                '/posts/default/create',
                                                            )) ? 'active' : '' ?>" href="/posts/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/posts/default/index',
                                                                                                    '/posts/default/create',
                                                                                                    '/posts/default/view',
                                                                                                )) ? 'Post_active.svg' : 'Post.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu"> Posts</span>
            </a>
        </li>


        <li class="navItems mb-2 position-relative <?= in_array($active_url, array(
                                                        "/operator/safari-operator/index",
                                                        "/operator/safari-operator/view",
                                                        "/operator/safari-operator/index/view",
                                                        "/gallery/default/index",
                                                        "/galleryapproval/default/index",
                                                        "/gallery/default/view",
                                                        "/operatorapproval/default/index",
                                                        "/operatorapproval/default/view",
                                                        "/externaloperator/default/index",
                                                        "/externaloperator/default/create",
                                                        "/externaloperator/default/update"
                                                    )) ? "is-expanded" : "" ?>">

            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/operator/safari-operator/index",
                                                                "/operator/safari-operator/view"
                                                            )) ? "active" : "" ?>"
                data-bs-toggle="collapse"
                href="#operatorMenu"
                role="button"
                aria-expanded="<?= in_array($active_url, array(
                                    "/operator/safari-operator/index",
                                    "/operator/safari-operator/view",
                                    "/operator/safari-operator/index/view",
                                    "/gallery/default/index",
                                    "/galleryapproval/default/index",
                                    "/gallery/default/view",
                                    "/operatorapproval/default/index",
                                    "/operatorapproval/default/view",
                                    "/externaloperator/default/index",
                                    "/externaloperator/default/create",
                                    "/externaloperator/default/update",
                                )) ? "true" : "false" ?>"
                aria-controls="operatorMenu">

                <span class="nav-icon me-1 "><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/operator/safari-operator/index',
                                                                                                    '/operator/safari-operator/create',
                                                                                                    '/operator/safari-operator/view',
                                                                                                )) ? 'operator_active.png' : 'operator.png' ?>" alt="" width="17" height="20"></span> <span class="side-menu__label hide-slide-menu">Operator <a href="" class="drop_imagesCC">
                        <img src="<?= $this->params['baseurl'] ?>/images/dropdownicon.png" class="card-img-top" alt="">
                    </a></span>
                <!-- <i class="angle fe fe-chevron-right"></i> -->

            </a>

            <ul class="slide-menu collapse pt-2 <?= in_array($active_url, array(
                                                    "/operator/safari-operator/index",
                                                    "/operator/safari-operator/view",
                                                    "/operator/safari-operator/index/view",
                                                    "/gallery/default/index",
                                                    "/galleryapproval/default/index",
                                                    "/gallery/default/view",
                                                    "/operatorapproval/default/index",
                                                    "/operatorapproval/default/view",
                                                    "/externaloperator/default/index",
                                                    "/externaloperator/default/create",
                                                    "/externaloperator/default/update"
                                                )) ? "show" : "" ?>" id="operatorMenu">
                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/operator/safari-operator/index",
                                                                                    "/operator/safari-operator/index/view"
                                                                                )) ? "active" : "" ?>" href="/operator/safari-operator/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                                    "/operator/safari-operator/index",
                                                                                                                                                                                                    "/operator/safari-operator/index/view",
                                                                                                                                                                                                )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Operator List</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/galleryapproval/default/index",
                                                                                    "/galleryapproval/default/view"
                                                                                )) ? "active" : "" ?>" href="/galleryapproval/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                                    "/galleryapproval/default/index",
                                                                                                                                                                                                    "/galleryapproval/default/view"
                                                                                                                                                                                                )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Pending Gallery Approval</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/gallery/default/index",
                                                                                    "/gallery/default/view"
                                                                                )) ? "active" : "" ?>" href="/gallery/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                            "/gallery/default/index",
                                                                                                                                                                                            "/gallery/default/view"
                                                                                                                                                                                        )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Gallery List</span></a>
                </li>


                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/externaloperator/default/index",
                                                                                    "/externaloperator/default/create",
                                                                                    "/externaloperator/default/update"
                                                                                )) ? "active" : "" ?>" href="/externaloperator/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                                    "/externaloperator/default/index",
                                                                                                                                                                                                    "/externaloperator/default/create",
                                                                                                                                                                                                    "/externaloperator/default/update"
                                                                                                                                                                                                )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">External Operator List</span></a>
                </li>

            </ul>

        </li>




        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                '/package/default/index',
                                                                '/package/default/create',
                                                            )) ? 'active' : '' ?>" href="/package/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/package/default/index',
                                                                                                    '/package/default/create',
                                                                                                    '/package/default/view',
                                                                                                )) ? 'package_active.svg' : 'package.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu">Packages</span>
            </a>

        </li>


        <li class="navItems mb-2 position-relative <?= in_array($active_url, array(
                                                        "/sharesafari/default/index",
                                                        "/sharesafari/default/view",
                                                        "/sharesafari/share-safari-comment/index",
                                                        "/sharesafari/default/fixed-departure",
                                                        "/sharesafari/default/fixed-view",
                                                    )) ? "is-expanded" : "" ?>">

            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/sharesafari/default/fixed-departure",
                                                                "/sharesafari/default/fixed-view",
                                                            )) ? "active" : "" ?>"
                data-bs-toggle="collapse"
                href="#safariMenu"
                role="button"
                aria-expanded="<?= in_array($active_url, array(
                                    "/sharesafari/default/index",
                                    "/sharesafari/default/view",
                                    "/sharesafari/share-safari-comment/index",
                                    "/sharesafari/default/fixed-departure",
                                    "/sharesafari/default/fixed-view",
                                )) ? "true" : "false" ?>"
                aria-controls="safariMenu">

                <span class="nav-icon me-1 "><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/sharesafari/default/index",
                                                                                                    "/sharesafari/default/view",
                                                                                                    "/sharesafari/share-safari-comment/index",
                                                                                                    "/sharesafari/default/fixed-departure",
                                                                                                    "/sharesafari/default/fixed-view",
                                                                                                )) ? 'safari_active.png' : 'safari.png' ?>" alt="" width="17" height="20"></span> <span class="side-menu__label hide-slide-menu">Safari<a href="" class="drop_imagesCC">
                        <img src="<?= $this->params['baseurl'] ?>/images/dropdownicon.png" class="card-img-top" alt="">
                    </a></span>
            </a>

            <ul class="slide-menu collapse pt-2 <?= in_array($active_url, array(
                                                    "/sharesafari/default/index",
                                                    "/sharesafari/default/view",
                                                    "/sharesafari/share-safari-comment/index",
                                                    "/sharesafari/default/fixed-departure",
                                                    "/sharesafari/default/fixed-view",
                                                )) ? "show" : "" ?>" id="safariMenu">
                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/sharesafari/default/fixed-departure",
                                                                                    "/sharesafari/default/fixed-view",
                                                                                )) ? "active" : "" ?>" href="/sharesafari/default/fixed-departure"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                                        "/sharesafari/default/fixed-departure",
                                                                                                                                                                                                        "/sharesafari/default/fixed-view",
                                                                                                                                                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Fixed Departure</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/sharesafari/default/index",
                                                                                    "/sharesafari/default/view",
                                                                                )) ? "active" : "" ?>" href="/sharesafari/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                                "/sharesafari/default/index",
                                                                                                                                                                                                "/sharesafari/default/view",
                                                                                                                                                                                            )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Share Safari</span></a>
                </li>
            </ul>

        </li>


        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                '/user/default/index',
                                                                '/user/default/create',
                                                                '/user/default/view',
                                                            )) ? 'active' : '' ?>" href="/user/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/user/default/index',
                                                                                                    '/user/default/create',
                                                                                                    '/user/default/view',
                                                                                                )) ? 'user_active.png' : 'userIcon.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> User List</span>
            </a>
        </li>


        <!-- flag -->
        <li class="navItems mb-2 position-relative <?= in_array($active_url, array(
                                                        "/flag/article/index",
                                                        "/flag/article/view",
                                                        "/flag/article/flagview",
                                                        "/flag/blog/index",
                                                        "/flag/blog/view",
                                                        "/flag/blog/flagview",
                                                        "/flag/operator/index",
                                                        "/flag/operator/view",
                                                        "/flag/operator/flagview",
                                                        "/flag/package/index",
                                                        "/flag/package/view",
                                                        "/flag/package/flagview",
                                                        "/flag/share-safari/index",
                                                        "/flag/share-safari/view",
                                                        "/flag/share-safari/flagview",
                                                        "/flag/sighting/index",
                                                        "/flag/sighting/view",
                                                        "/flag/sighting/flagview",
                                                        "/flag/untraced-flag/index",
                                                        "/flag/untraced-flag/view",
                                                        "/flag/untraced-flag/flagview",
                                                        "/flag/user-post/index",
                                                        "/flag/user-post/view",
                                                        "/flag/user-post/flagview",

                                                    )) ? "is-expanded" : "" ?>">

            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/flag/default/fixed-departure",
                                                                "/flag/default/fixed-view",
                                                            )) ? "active" : "" ?>"
                data-bs-toggle="collapse"
                href="#flagMenu"
                role="button"
                aria-expanded="<?= in_array($active_url, array(
                                    "/flag/article/index",
                                    "/flag/article/view",
                                    "/flag/article/flagview",
                                    "/flag/blog/index",
                                    "/flag/blog/view",
                                    "/flag/blog/flagview",
                                    "/flag/operator/index",
                                    "/flag/operator/view",
                                    "/flag/operator/flagview",
                                    "/flag/package/index",
                                    "/flag/package/view",
                                    "/flag/package/flagview",
                                    "/flag/share-safari/index",
                                    "/flag/share-safari/view",
                                    "/flag/share-safari/flagview",
                                    "/flag/sighting/index",
                                    "/flag/sighting/view",
                                    "/flag/sighting/flagview",
                                    "/flag/untraced-flag/index",
                                    "/flag/untraced-flag/view",
                                    "/flag/untraced-flag/flagview",
                                    "/flag/user-post/index",
                                    "/flag/user-post/view",
                                    "/flag/user-post/flagview",
                                )) ? "true" : "false" ?>"
                aria-controls="flagMenu">

                <span class="nav-icon me-1 "><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/flag/article/index",
                                                                                                    "/flag/article/view",
                                                                                                    "/flag/article/flagview",
                                                                                                    "/flag/blog/index",
                                                                                                    "/flag/blog/view",
                                                                                                    "/flag/blog/flagview",
                                                                                                    "/flag/operator/index",
                                                                                                    "/flag/operator/view",
                                                                                                    "/flag/operator/flagview",
                                                                                                    "/flag/package/index",
                                                                                                    "/flag/package/view",
                                                                                                    "/flag/package/flagview",
                                                                                                    "/flag/share-safari/index",
                                                                                                    "/flag/share-safari/view",
                                                                                                    "/flag/share-safari/flagview",
                                                                                                    "/flag/sighting/index",
                                                                                                    "/flag/sighting/view",
                                                                                                    "/flag/sighting/flagview",
                                                                                                    "/flag/untraced-flag/index",
                                                                                                    "/flag/untraced-flag/view",
                                                                                                    "/flag/untraced-flag/flagview",
                                                                                                    "/flag/user-post/index",
                                                                                                    "/flag/user-post/view",
                                                                                                    "/flag/user-post/flagview",
                                                                                                )) ? 'operator_active.png' : 'operator.png' ?>" alt="" width="17" height="20"></span> <span class="side-menu__label hide-slide-menu">Flag<a href="" class="drop_imagesCC">
                        <img src="<?= $this->params['baseurl'] ?>/images/dropdownicon.png" class="card-img-top" alt="">
                    </a></span>
            </a>

            <ul class="slide-menu collapse pt-2 <?= in_array($active_url, array(
                                                    "/flag/article/index",
                                                    "/flag/article/view",
                                                    "/flag/article/flagview",
                                                    "/flag/blog/index",
                                                    "/flag/blog/view",
                                                    "/flag/blog/flagview",
                                                    "/flag/operator/index",
                                                    "/flag/operator/view",
                                                    "/flag/operator/flagview",
                                                    "/flag/package/index",
                                                    "/flag/package/view",
                                                    "/flag/package/flagview",
                                                    "/flag/share-safari/index",
                                                    "/flag/share-safari/view",
                                                    "/flag/share-safari/flagview",
                                                    "/flag/sighting/index",
                                                    "/flag/sighting/view",
                                                    "/flag/sighting/flagview",
                                                    "/flag/untraced-flag/index",
                                                    "/flag/untraced-flag/view",
                                                    "/flag/untraced-flag/flagview",
                                                    "/flag/user-post/index",
                                                    "/flag/user-post/view",
                                                    "/flag/user-post/flagview",
                                                )) ? "show" : "" ?>" id="flagMenu">
                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/flag/operator/index",
                                                                                    "/flag/operator/view",
                                                                                    "/flag/operator/flagview",
                                                                                )) ? "active" : "" ?>" href="/flag/operator/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                        "/flag/operator/index",
                                                                                                                                                                                        "/flag/operator/view",
                                                                                                                                                                                        "/flag/operator/flagview",
                                                                                                                                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Operator Comment</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/flag/package/index",
                                                                                    "/flag/package/view",
                                                                                    "/flag/package/flagview",
                                                                                )) ? "active" : "" ?>" href="/flag/package/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                        "/flag/package/index",
                                                                                                                                                                                        "/flag/package/view",
                                                                                                                                                                                        "/flag/package/flagview",
                                                                                                                                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Package Comment</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/flag/user-post/index",
                                                                                    "/flag/user-post/view",
                                                                                    "/flag/user-post/flagview",
                                                                                )) ? "active" : "" ?>" href="/flag/user-post/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                            "/flag/user-post/index",
                                                                                                                                                                                            "/flag/user-post/view",
                                                                                                                                                                                            "/flag/user-post/flagview",
                                                                                                                                                                                        )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Post Comment</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/flag/sighting/index",
                                                                                    "/flag/sighting/view",
                                                                                    "/flag/sighting/flagview",
                                                                                )) ? "active" : "" ?>" href="/flag/sighting/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                        "/flag/sighting/index",
                                                                                                                                                                                        "/flag/sighting/view",
                                                                                                                                                                                        "/flag/sighting/flagview",
                                                                                                                                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Sighting Comment</span></a>
                </li>

                <?php if(false){ ?>
                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                                    "/flag/blog/index",
                                                                                    "/flag/blog/view",
                                                                                    "/flag/blog/flagview",
                                                                                )) ? "active" : "" ?>" href="/flag/blog/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                    "/flag/blog/index",
                                                                                                                                                                                    "/flag/blog/view",
                                                                                                                                                                                    "/flag/blog/flagview",
                                                                                                                                                                                )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Blog Comment</span></a>
                </li>
                <?php } ?>
            </ul>

        </li>

        <!-- logs -->
        <li class="navItems mb-2 position-relative <?= in_array($active_url, array(
                                                        "/log/default/index",
                                                        "/log/default/view",
                                                        "/log/call-log/index",
                                                        "/log/call-log/view",
                                                    )) ? "is-expanded" : "" ?>">

            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/log/default/index",
                                                                "/log/default/view",
                                                                "/log/call-log/index",
                                                                "/log/call-log/view",
                                                            )) ? "active" : "" ?>"
                data-bs-toggle="collapse"
                href="#logMenu"
                role="button"
                aria-expanded="<?= in_array($active_url, array(
                                    "/log/default/index",
                                    "/log/default/view",
                                    "/log/call-log/index",
                                    "/log/call-log/view",
                                )) ? "true" : "false" ?>"
                aria-controls="logMenu">

                <span class="nav-icon me-1 "><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/log/default/index",
                                                                                                    "/log/default/view",
                                                                                                    "/log/call-log/index",
                                                                                                    "/log/call-log/view",
                                                                                                )) ? 'log_active.png' : 'log.png' ?>" alt="" width="17" height="20"></span> <span class="side-menu__label hide-slide-menu">Log<a href="" class="drop_imagesCC">
                        <img src="<?= $this->params['baseurl'] ?>/images/dropdownicon.png" class="card-img-top" alt="">
                    </a></span>
            </a>

            <ul class="slide-menu collapse pt-2 <?= in_array($active_url, array(
                                                    "/log/call-log/index",
                                                    "/log/call-log/view",
                                                )) ? "show" : "" ?>" id="logMenu">
                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(

                                                                                    "/log/call-log/index",
                                                                                    "/log/call-log/view",
                                                                                )) ? "active" : "" ?>" href="/log/call-log/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                                                                                                        "/log/default/index",
                                                                                                                                                                                        "/log/default/view",
                                                                                                                                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Call Log</span></a>
                </li>
            </ul>

        </li>
</div>
        <li class="navItems navitemLogout mb-2 ms-0">
            <a class="navLinks  d-flex align-items-center" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/Icon_material-twotone-logout.svg" alt="" width="25" height="25"></span>
                <span class="hide-slide-menu"> Logout</span>
            </a>
        </li>
    </ul>
</nav>