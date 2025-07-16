 <nav class="navbar fixed-top d-flex flex-row">
   <div class="navbar-menu-wrapper d-flex ">
     <div class="sidebar-brand-wrapper  px-3 py-3 d-lg-none d-block">
       <a href="/" class="header-logo">
         <img src="<?= $this->params['baseurl'] ?>/images/logo-mini.svg" alt="logo">
       </a>
     </div>


     <ul class="nav-right d-flex align-items-center justify-content-center gap-4">
       <!-- <li class="nav-item dropdown">
             <a class="nav-link count-indicator ">
               <i class="mdi mdi-email"></i>
             </a>
           </li>
           <li class="nav-item dropdown">
             <a class="nav-link count-indicator ">
               <i class="mdi mdi-bell"></i>
             </a>
           </li> -->
            <li class="nav-item " id="dropdown-pro">
         <div class="d-flex align-items-center gap-4">
           <div class="ed-du-img">
               <a href=""><img src="<?= $this->params['baseurl'] ?>/images/inbox.png" class="card-img-top" alt=""></a>
           </div>
           <div class="ed-du-img">
            
            <a href=""><img src="<?= $this->params['baseurl'] ?>/images/bell.png" class="card-img-top" alt=""></a>
           </div>
          </div>
       </li>
       <li class="nav-item " id="dropdown-pro">
         <div class="d-flex align-items-center">
           <div class="dorpdown-profile me-2">
             <img src="<?= isset($safarioperator) && $safarioperator->imagepath ? $safarioperator->imagepath : $this->params['baseurl'] . '/images/default_witw.png' ?>" alt="logo">
           </div>
           <div class="d-lg-block d-none">
             <div class="dropdoen-detail-profile d-flex ">
               <p class="pt-1"><?= isset($safarioperator) ? $safarioperator->business_name : '' ?>&nbsp;</p>
               <!-- <i class="mdi mdi-menu-down d-none d-sm-block"></i> -->
             </div>
           </div>
           <!-- <div class="profile-dropdown-navigate">
                 <ul class="profile-listing">
                   <li class="pb-2">
                     <a href="/settings/default/index">Profile</a>
                   </li>
                   <div class="dvider"></div>
                   <li><a href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post" class="d-flex align-items-center">
                       <div class="icons-pro rounded-circle">
                         <i class="mdi mdi-logout text-danger"></i>
                       </div>
                       Logout
                     </a></li>
                 </ul>
               </div> -->
         </div>
       </li>
       <li class="d-lg-none d-block nav-item">
         <button class="navbar-toggler navbar-toggler align-self-center menutoggle" type="button"
           data-toggle="minimize">
           <span class="mdi mdi-menu"></span>
         </button>
       </li>
     </ul>
   </div>
 </nav>