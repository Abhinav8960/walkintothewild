<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Pannel</title>
        <!-- ======favicon ======-->
        <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="assets/favicon/favicon-32x32.png"
        >
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="assets/favicon/favicon-16x16.png"
        >
        <link rel="manifest" href="assets/favicon/site.webmanifest">
        <!-- css===styles -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/core.css">
        <link rel="stylesheet" href="assets/css/custom.css">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        >
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css"
            integrity="sha512-fXnjLwoVZ01NUqS/7G5kAnhXNXat6v7e3M9PhoMHOTARUMCaf5qNO84r5x9AFf5HDzm3rEZD8sb/n6dZ19SzFA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        >
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container-scroller">
            <nav class="side_bar sidebar-offcanvas d-flex justify-content-center border border-start-0">
                <ul class="nav">
                    <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item mb-5">
                        <div class="profile-ditails d-flex justify-content-around align-items-center">
                            <div class="pro-img me-3">
                                <img src="./assets/images/default_witw.png" alt="">
                                <span class="success-online"></span>
                            </div>
                        </div>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks active d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Dashboard</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks  d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Leads</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> My Packages</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks  d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> My Fixed</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Sightings</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks  d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Posts</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks  d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Gallery</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Reports</span>
                        </a>
                    </li>
                    <li class="navItems mb-2">
                        <a href="" class="navLinks  d-flex align-items-center">
                            <span class="nav-icon me-3">
                                <i class="fa-solid fa-house-chimney"></i>
                            </span>
                            <span class="hide-slide-menu"> Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <header class=" container-fluid main-header">
                <nav class="navbar fixed-top d-flex flex-row">
                    <div class="navbar-menu-wrapper d-flex ">
                        <div class="sidebar-brand-wrapper  px-3 py-3 d-lg-none d-block">
                            <a href="">
                                <img src="./assets/images/logo-mini.svg" alt="">
                            </a>
                        </div>
                        <button
                            class="navbar-toggler navbar-toggler align-self-center d-lg-block d-none"
                            type="button"
                            data-toggle="minimize"
                            id="hider-sidebar"
                        >
                            <span class="mdi mdi-menu"></span>
                        </button>
                        <ul class="nav-right d-flex align-items-center justify-content-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link count-indicator ">
                                    <i class="mdi mdi-email"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link count-indicator ">
                                    <i class="mdi mdi-bell"></i>
                                </a>
                            </li>
                            <li class="nav-item " id="dropdown-pro">
                                <a href="#" class="d-flex align-items-center">
                                    <div class="dorpdown-profile me-2">
                                        <img src="./assets/images/default_witw.png" alt="">
                                    </div>
                                    <div class="d-lg-block d-none">
                                        <div class="dropdoen-detail-profile d-flex ">
                                            <p>Operator Name</p>
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
                                                <a href="editprofile.html" class="d-flex align-items-center">
                                                    <div class="icons-pro rounded-circle">
                                                        <i class="mdi mdi-grease-pencil"></i>
                                                    </div>
                                                    Edit
                                                </a>
                                            </li>
                                            <div class="dvider"></div>
                                            <li>
                                                <a href="" class="d-flex align-items-center">
                                                    <div class="icons-pro rounded-circle">
                                                        <i class="mdi mdi-multiplication"></i>
                                                    </div>
                                                    Settings
                                                </a>
                                            </li>
                                            <div class="dvider"></div>
                                            <li>
                                                <a href="" class="d-flex align-items-center">
                                                    <div class="icons-pro rounded-circle">
                                                        <i class="mdi mdi-logout text-danger"></i>
                                                    </div>
                                                    Logout
                                                </a>
                                            </li>
                                            <div class="dvider"></div>
                                            <li>
                                                <a href="">Advance Settings</a>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li class="d-lg-none d-block nav-item">
                                <button class="navbar-toggler navbar-toggler align-self-center menutoggle" type="button" data-toggle="minimize">
                                    <span class="mdi mdi-menu"></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="main-pannel mt-4">
                    <div class="container-fluid">
                      <div class="table-wrapper">
                        <div class="table-responsive">
                          <table
                            class="table tablecustoms table-striped align-middle w-100"
                          >
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Source</th>
                                <th>Park Name</th>
                                <th>Package Name</th>
                                <th>Safaris</th>
                                <th>Travelers</th>
                                <th>Days</th>
                                <th>Travel Date</th>
                                <th>Lead Received</th>
                                <th>Payment Info</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <!-- Repeat this row as needed -->
                              <tr>
                                <td>1</td>
                                <td>
                                  <div class="source-icon">
                                    <span class="circle package"></span> Package
                                  </div>
                                </td>
                                <td>Pench Tiger Reserve</td>
                                <td>Package Name</td>
                                <td>10</td>
                                <td>10</td>
                                <td>10</td>
                                <td>25 May 2025</td>
                                <td>12 April 2025</td>
                                <td><span class="badge badge-paid">PAID</span></td>
                                <td>
                                  <div class="action-icon">👁️</div>
                                </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>
                                  <div class="source-icon">
                                    <span class="circle park"></span> Park
                                  </div>
                                </td>
                                <td>Pench Tiger Reserve</td>
                                <td>Package Name</td>
                                <td>10</td>
                                <td>10</td>
                                <td>10</td>
                                <td>25 May 2025</td>
                                <td>12 April 2025</td>
                                <td><span class="badge badge-pending">PENDING</span></td>
                                <td>
                                  <div class="action-icon">👁️</div>
                                </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>
                                  <div class="source-icon">
                                    <span class="circle park"></span> Park
                                  </div>
                                </td>
                                <td>Pench Tiger Reserve</td>
                                <td>Package Name</td>
                                <td>10</td>
                                <td>10</td>
                                <td>10</td>
                                <td>25 May 2025</td>
                                <td>12 April 2025</td>
                                <td><span class="badge badge-pending">PENDING</span></td>
                                <td>
                                  <div class="action-icon">👁️</div>
                                </td>
                              </tr>
                              <!-- More rows... -->
                            </tbody>
                          </table>
                        </div>
          
                        <div class="d-flex justify-content-between mt-3">
                          <div>
                            Showing <strong>1-15</strong> of <strong>45</strong> Items
                          </div>
                          <nav>
                            <ul class="pagination mb-0">
                              <li class="page-item disabled">
                                <span class="page-link">Prev</span>
                              </li>
                              <li class="page-item active">
                                <span class="page-link">1</span>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">2</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">3</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                              </li>
                            </ul>
                          </nav>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
             </div>
          </header>
       </div>
<script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="./assets/js/main.js"></script>
<script src="./assets/js/custom.js"></script>
</body>
</html>
