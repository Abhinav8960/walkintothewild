<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Walk Into Wild Partner Pannel</title>
  <!-- ======favicon ======-->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/site.webmanifest">
  <!-- css===styles -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css"
    integrity="sha512-fXnjLwoVZ01NUqS/7G5kAnhXNXat6v7e3M9PhoMHOTARUMCaf5qNO84r5x9AFf5HDzm3rEZD8sb/n6dZ19SzFA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container-scroller">
    <nav class="side_bar sidebar-offcanvas d-flex justify-content-center">
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
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Dashboard</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks  d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Leads</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> My Packages</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks  d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> My Fixed Departures</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Sightings</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks  d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Posts</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks  d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Gallery</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
            <span class="hide-slide-menu"> Reports</span>
          </a>
        </li>
        <li class="navItems mb-2">
          <a href="" class="navLinks  d-flex align-items-center">
            <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
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
          <button class="navbar-toggler navbar-toggler align-self-center d-lg-block d-none" type="button"
            data-toggle="minimize" id="hider-sidebar">
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
                    <p>Operator Name </p>
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
              <button class="navbar-toggler navbar-toggler align-self-center menutoggle" type="button"
                data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
              </button>
            </li>
          </ul>
        </div>
      </nav>

      <div class="main-pannel mt-4">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xxl-10 mb-3">
              <div class="row">
                <div class="col-xxl-12">
                  <div class="row">
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                      <div class="mainCard py-3 px-3">
                        <div class="cardChild">
                          <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-clone"></i>
                          </div>
                          <div class="text-card mb-2">
                            <p>Total Leads</p>
                          </div>
                          <div class="numbwrCount">
                            <h3>300</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                      <div class="mainCard py-3 px-3">
                        <div class="cardChild">
                          <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-clone"></i>
                          </div>
                          <div class="text-card mb-2">
                            <p>Converted Leads</p>
                          </div>
                          <div class="numbwrCount">
                            <h3>90</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                      <div class="mainCard py-3 px-3">
                        <div class="cardChild">
                          <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-clone"></i>
                          </div>
                          <div class="text-card mb-2">
                            <p>Revenue</p>
                          </div>
                          <div class="numbwrCount">
                            <h3>45 Lakh</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                      <div class="mainCard py-3 px-3">
                        <div class="cardChild">
                          <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-clone"></i>
                          </div>
                          <div class="text-card mb-2">
                            <p>Average Rating</p>
                          </div>
                          <div class="numbwrCount">
                            <h3>4.5</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 mb-4">
                  <div class="row">
                    <div class="col-xxl-6 col-xl-12 col-12 mb-3">
                      <div class="h-100">
                        <div class="topHead d-flex justify-content-between align-items-center pb-2 mx-4">
                          <p>Recent Posts</p>
                          <a href="">See All</a>
                        </div>
                        <div class="row">
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Post description</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">12 Comments</a>
                                      <a href="">25 Likes</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Post description</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">12 Comments</a>
                                      <a href="">25 Likes</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-xl-12 col-12 mb-3">
                      <div class="h-100">
                        <div class="topHead d-flex justify-content-between align-items-center pb-2 mx-4">
                          <p>Recent Sightings</p>
                          <a href="">See All</a>
                        </div>
                        <div class="row">
                          <div class="col-xl-4 col-md-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-2.jpg" alt="" class="w-100"
                                  style="height: 145px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Sightings description</p>
                                    </div>
                                    <div class="coLike d-flex flex-column">
                                      <a href="" class="pb-2">12 Comments</a>
                                      <a href="">25 Likes</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-4 col-md-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 145px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Sightings description</p>
                                    </div>
                                    <div class="coLike d-flex flex-column">
                                      <a href="" class="pb-2">12 Comments</a>
                                      <a href="">25 Likes</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-4 col-md-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 145px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Sightings description</p>
                                    </div>
                                    <div class="coLike d-flex flex-column">
                                      <a href="" class="pb-2">12 Comments</a>
                                      <a href="">25 Likes</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-12">
                  <div class="row">
                    <div class="col-xxl-6 col-xl-12 col-12 mb-3">
                      <div class="h-100">
                        <div class="topHead d-flex justify-content-between align-items-center pb-2 mx-4">
                          <p>Most Requested Packages</p>
                          <a href="">See All</a>
                        </div>
                        <div class="row">
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>2 Night, 3 Days Pench Tiger</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">90 Interests</a>
                                      <a href="">Rs.60,000/-</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>2 Night, 3 Days Pench Tiger</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">90 Interests</a>
                                      <a href="">Rs.60,000/-</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-xl-12 col-12 mb-3">
                      <div class="h-100">
                        <div class="topHead d-flex justify-content-between align-items-center pb-2 mx-4">
                          <p>Most Demanded Park</p>
                          <a href="">See All</a>
                        </div>
                        <div class="row">
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Gir National Park</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">100 Quote Requests</a>
                    
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                            <div class="mainParent ">
                              <div class="card h-100 d-flex">
                                <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                                  style="height: 170px; object-fit: cover;">
                                <div class="card-body p-2">
                                  <div class="cardBodyTitle">
                                    <div class="subtitle pb-2">
                                      <p>Kaziranga National Park</p>
                                    </div>
                                    <div class="coLike d-flex justify-content-between">
                                      <a href="">90 Quote Requests</a>
                                  
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="col-xxl-2 mb-3">
              <div class="row">
                <div class="col-xl-12 mb-3">
                  <div class="rightSidebar">
                    <div class="cadplaform">
                      <p class="mb-2 headbg">Platform Usage & Ethics</p>
                      <p class="mb-3">The platform must be used strictly for genuine bookings. Direct...</p>
                      <a href="">Read Partner Handbook</a>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 mb-3">
                  <div class="progressBar">
                    <div class="qout">
                      <div class="montlyQouteHeader mb-2 px-4 pt-3">
                        <p>Monthly Quote Requests</p>
                      </div>
                      <div class="bodySectionParent">
                        <!-- <div class="sideNumbers">
                          <p class="sideQuteno pb-3">300</p>
                          <p class="sideQuteno pb-3">300</p>
                          <p class="sideQuteno pb-3">300</p>
                          <p class="sideQuteno pb-3">300</p>
                          <p class="sideQuteno pb-3">300</p>
                        </div> -->
                        <div class="quote-chart">
                        
                          
                          <div class="chart-area">
                            <div class="y-axis-labels">
                              <span style="bottom: 25px;">0</span>
                              <span style="bottom: 70px;">50</span>
                              <span style="bottom: 115px;">100</span>
                              <span style="bottom: 170px;">200</span>
                              <span style="bottom: 220px;">300</span>
                            </div>
                            <div class="bars">
                              <div class="bar">
                                <div class="fill" style="height: 100px;"></div>
                                <span>Jan</span>
                              </div>
                              <div class="bar">
                                <div class="fill" style="height: 160px;"></div>
                                <span>Feb</span>
                              </div>
                              <div class="bar">
                                <div class="fill" style="height: 120px;"></div>
                                <span>Mar</span>
                              </div>
                              <div class="bar">
                                <div class="fill active" style="height: 240px;"></div>
                                <span>Apr</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-12 mb-3">
                  <div class="boradUserParent">
                    <div class="topHead d-flex justify-content-between align-items-center pt-3 px-3">
                      <p>Recent Requests</p>
                      <a href="">See All</a>
                    </div>
                    <div class="userMain d-flex Flex-1 gap-2  py-3 px-4">
                      <div class="userProfile">

                      </div>
                      <div class="userName">
                        <a href="">Username 1</a>
                        <p>Interested in Pench Tiger...</p>
                      </div>
                    </div>
                    <div class="userMain d-flex Flex-1 gap-2  py-3 px-4">
                      <div class="userProfile">

                      </div>
                      <div class="userName">
                        <a href="">Username 1</a>
                        <p>Interested in Pench Tiger...</p>
                      </div>
                    </div>
                    <div class="userMain d-flex Flex-1 gap-2  py-3 px-4">
                      <div class="userProfile">

                      </div>
                      <div class="userName">
                        <a href="">Username 1</a>
                        <p>Interested in Pench Tiger...</p>
                      </div>
                    </div>
                    <div class="userMain d-flex Flex-1 gap-2  py-3 px-4">
                      <div class="userProfile">

                      </div>
                      <div class="userName">
                        <a href="">Username 1</a>
                        <p>Interested in Pench Tiger...</p>
                      </div>
                    </div>
                    <div class="userMain d-flex Flex-1 gap-2  py-3 px-4">
                      <div class="userProfile">

                      </div>
                      <div class="userName">
                        <a href="">Username 1</a>
                        <p>Interested in Pench Tiger...</p>
                      </div>
                    </div>
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

  <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/custom.js"></script>
</body>

</html>