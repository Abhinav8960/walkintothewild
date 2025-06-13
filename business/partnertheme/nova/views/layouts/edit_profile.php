<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pannel</title>
    <!-- ======favicon ======-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
     <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <!-- css===styles -->
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css" integrity="sha512-fXnjLwoVZ01NUqS/7G5kAnhXNXat6v7e3M9PhoMHOTARUMCaf5qNO84r5x9AFf5HDzm3rEZD8sb/n6dZ19SzFA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="container-scroller">
    <!-- ===sidebar===== -->
   <nav class="side_bar sidebar-offcanvas ">
    <div class="top-sidebar-head px-3 py-4 fixed-top">
        <a href="" class="hide-slide-menu">
            <img src="./assets/images/logo.svg" alt="">
        </a>
        <a href="" class="mini-logo">
          <img src="./assets/images/logo-mini.svg" alt="">
      </a>
    </div>
    <ul class="nav">
    <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item">
      <div class="profile-ditails d-flex justify-content-around align-items-center">
        <div class="pro-img me-3">
             <img src="./assets/images/face15.jpg" alt="">
             <span class="success-online"></span>
        </div>
        <div class="profilename hide-slide-menu">
            <h5>Gufran Ahmad</h5>
            <p>Gold Member</p>
          
        </div>
      </div>
      <div class="profile-dropdown">
        <a href="">
            <i class="mdi mdi-dots-vertical"></i>
        </a>
      </div>
    </li>
    <li class="navcatogiri pt-4 nav-item hide-slide-menu">
        Navigation
    </li>
    <li class="active color-item mt-4 mb-3">
        <a href="" class="nav-link d-flex align-items-center">
            <span class="nav-icon me-3">
                <i class="mdi mdi-speedometer"></i>
            </span>
            <span class="hide-slide-menu">Dashboard</span>
        </a>
    </li>
    <li class="color-item mb-3">
        <a href="" class="nav-link d-flex align-items-center">
            <span class="nav-icon me-3">
                <i class="mdi mdi-laptop"></i>
            </span>
            <span class="hide-slide-menu">Basic UI Element</span>
        </a>
    </li>
    <li class="color-item mb-3">
        <a href="" class="nav-link d-flex align-items-center">
            <span class="nav-icon me-3">
                <i class="mdi mdi-playlist-play"></i>
            </span>
            <span class="hide-slide-menu">Dashboard</span>
        </a>
    </li>
    <li class="color-item mb-3">
        <a href="" class="nav-link d-flex align-items-center">
            <span class="nav-icon me-3">
                <i class="mdi mdi-table-large"></i>
            </span>
            <span class="hide-slide-menu">Table</span>
        </a>
    </li>
    </ul>
   </nav>
   <!-- ===sidebar===== -->
   <header class=" container-fluid main-header">
    <nav class="navbar fixed-top d-flex flex-row">
     <div class="navbar-menu-wrapper d-flex ">
        <div class="sidebar-brand-wrapper  px-3 py-3 d-lg-none d-block">
            <a href="">
                <img src="./assets/images/logo-mini.svg" alt="">
            </a>
        </div>
        <button class="navbar-toggler navbar-toggler align-self-center d-lg-block d-none" type="button" data-toggle="minimize" id="hider-sidebar">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav ">
            <li class="nav-item ">
              <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                <input type="text" class="form-control search-input" placeholder="Search products" >
              </form>
            </li>
          </ul>
          <ul class="nav-right d-flex align-items-center justify-content-center">
            <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator ">
                <i class="mdi mdi-email"></i>                
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator ">
                  <i class="mdi mdi-bell"></i>                
                </a>
              </li>
              <li class="nav-item " id="dropdown-pro">
                <a href="#" class="d-flex align-items-center">
                    <div class="dorpdown-profile me-2" >
                        <img src="./assets/images/face15.jpg" alt="" > 
                      
                    </div>
                    <div class="d-lg-block d-none">
                      <div class="dropdoen-detail-profile d-flex ">
                        <p>Gufran Ahmad </p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                    </div>
                    <div class="profile-dropdown-navigate">
                      <ul class="profile-listing">
                        <li class="pb-2">
                          <a href="#">Profile</a>
                        </li>
                        <div class="dvider"></div>
                        <li>
                          <a href="" class="d-flex align-items-center">
                          <div class="icons-pro rounded-circle">
                            <i class="mdi mdi-grease-pencil"></i>
                          </div>
                          Edit
                        </a></li>
                        <div class="dvider"></div>
                      
                        <li>
                          <a href="" class="d-flex align-items-center">
                          <div class="icons-pro rounded-circle">
                            <i class="mdi mdi-multiplication"></i>
                          </div>
                          Settings
                        </a></li>
                        <div class="dvider"></div>
                        <li><a href="" class="d-flex align-items-center">
                          <div class="icons-pro rounded-circle">
                            <i class="mdi mdi-logout text-danger"></i>
                          </div>
                          Logout
                        </a></li>
                        <div class="dvider"></div>
                        <li><a href="">Advance Settings</a></li>
                      </ul>
                    </div>
                </a>
              </li>
              <li class="d-lg-none d-block nav-item">
                <button class="navbar-toggler navbar-toggler align-self-center menutoggle" type="button" data-toggle="minimize" >
                  <span class="mdi mdi-menu"></span>
                </button>
              </li>
          </ul>
     </div>
    </nav>

    <div class="main-pannel mt-4">
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
            <div class="edit_Profile_box">
                  <div class="profile-change text-center mb-2">
                    <div class="profile-pic-wrapper">
                        <div class="pic-holder">
                          <!-- uploaded pic shown here -->
                          <img id="profilePic" class="pic" src="./assets/images/face15.jpg">                          <Input class="uploadProfileInput" type="file" name="profile_pic" id="newProfilePhoto" accept="image/*" style="opacity: 0;" />
                          <label for="newProfilePhoto" class="upload-file-block">
                            <div class="text-center">
                              <div class="mb-2">
                                <i class="fa fa-camera fa-2x"></i>
                              </div>
                              <div class="text-uppercase">
                                Update <br /> Profile Photo
                              </div>
                            </div>
                          </label>
                        </div>

                  </div>
                </div>
                <div class="profile-form">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <form>
                                <div class="form-group mb-4">
                                    <label > User Name<span>*</span></label>
                                  <input type="text" class="form-control mt-2" placeholder="Gufran Ahmad" >
                                </div>
                                <div class="form-group">
                                    <label > Login Email<span>*</span></label>
                                    <input type="password" class="form-control disabled mt-2" placeholder="gufran2307@gmail.com" disabled>                           
                                </div>
                                <div class="save-btn mt-5 d-flex justify-content-between">
                                    <button type="button" class="btn save-btn px-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Reset Password</button>
                                    <button class="btn save-btn px-4">Save</button>
                                </div>
                             </form>
                        </div>
                    </div>
                
                </div>
            </div>
           
        </div>
      </div>
    </div>
    </div>
   </header>  
  </div> 
  
  <!-- modalll -->
  <div class="row">
    <div class="col-lg-5">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="mb-3">
                      <label>New Password <span>*</span></label>
                      <input type="password" class="form-control mt-2" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label>Confirm New Password<span>*</span></label>
                        <input type="password" class="form-control mt-2" id="recipient-name">
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
 
  <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
  <script src="./assets/js/custom.js"></script>
</body>
</html>