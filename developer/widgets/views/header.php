 <nav class="navbar fixed-top d-flex flex-row">
   <div class="navbar-menu-wrapper d-flex ">
     <div class="sidebar-brand-wrapper  px-3 py-3 d-lg-none d-block">
       <a href="/" class="header-logo">
         <img src="<?= $this->params['baseurl'] ?>/images/logo.png" alt="logo">
       </a>
     </div>


     <ul class="nav-right d-flex align-items-center justify-content-center gap-4">
     
       <li class="nav-item " id="dropdown-pro">
         <div class="d-flex align-items-center">
           <div class="dorpdown-profile me-2">
             <img src="<?= isset($user) && $user->profile_display_image ? $user->profile_display_image : $this->params['baseurl'] . '/images/default_witw.png' ?>" alt="logo">
           </div>
           <div class="d-lg-block d-none">
             <div class="dropdoen-detail-profile d-flex ">
               <p class="pt-1"><?= isset($user) ? $user->name : '' ?>&nbsp;</p>
               
             </div>
           </div>
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