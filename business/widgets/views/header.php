<!-- main-header -->
<div class="main-header side-header sticky nav nav-item" style="background: #09422D !important;color:#fff !important;">
    <div class=" main-container container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="/" class="header-logo">
                    <img src="<?= $this->params['baseurl'] ?>/img/partner_logo.png" class="mobile-logo logo-1" alt="logo">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo-white.png" class="mobile-logo dark-logo-1" alt="logo">
                </a>
            </div>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
            </div>
            <div class="logo-horizontal">
                <a href="/" class="header-logo">
                    <img src="<?= $this->params['baseurl'] ?>/img/partner_logo.png" class="mobile-logo logo-1" alt="logo">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo-white.png" class="mobile-logo dark-logo-1" alt="logo">
                </a>
            </div>
        </div>
        <div class="main-header-right">
            <?php if (\Yii::$app->params['environment']) { ?>
                <strong>
                    <span style="letter-spacing: 1.4px;font-weight: 900;font-size: 17px;text-transform: uppercase;margin-right: 20px;color: yellow;"><?= \Yii::$app->params['environment'] ?></span>
                </strong>
            <?php } ?>
            <button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fe fe-more-vertical "></span>
            </button>
            <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <ul class="nav nav-item header-icons navbar-nav-right ms-auto">
                        <li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
                            <a class="new nav-link profile-user d-flex" href="" data-bs-toggle="dropdown"><img alt="" src="<?= $this->params['baseurl'] ?>/img/Admin-Profile-Vector-PNG-Clipart.png" class=""></a>
                            <div class="dropdown-menu" style="left:-194px !important;">
                                <div class="menu-header-content p-3 border-bottom">
                                    <div class="d-flex wd-100p">
                                        <div class="main-img-user"><img alt="" src="/theme/img/Admin-Profile-Vector-PNG-Clipart.png" class=""></div>
                                        <div class="ms-3 my-auto">
                                            <h6 class="tx-15 font-weight-semibold mb-0"><?= Yii::$app->user->identity->name ?></h6></span>
                                        </div>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post"><i class="far fa-arrow-alt-circle-left"></i> Log Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->