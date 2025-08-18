<?php

/** @var yii\web\View $this */

use business\assets\AppAsset;
use common\models\GeneralModel;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Dashboard';
// $this->params['breadcrumbs'][] = $this->title;
// $this->params['title'] = $this->title;
?>

<div class="row">
  <div class="col-xxl-10 mb-3">
    <div class="row">
      <div class="col-xxl-12">
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <div class="mainCard py-3 px-3">
              <div class="cardChild">
                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                  <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                </div>
                <div class="text-card mb-2">
                  <p>Total Leads</p>
                </div>
                <div class="numbwrCount">
                  <h3><?= isset($leads) ? $leads : 0 ?></h3>
                </div>
              </div>
            </div>
          </div>
          <?php if (false) { ?>
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
          <?php } ?>
          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <div class="mainCard py-3 px-3">
              <div class="cardChild">
                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #FFEEEE;">
                  <img src="<?= $this->params['baseurl'] ?>/images/Icon feather-star.svg" alt="Lead">
                </div>
                <div class="text-card mb-2">
                  <p>Average Rating</p>
                </div>
                <div class="numbwrCount">
                  <h3><?= round($safari_operator->google_rating, 1) ?></h3>
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
              <div class="topHead d-flex justify-content-between align-items-center mx-4">
                <p>Recent Posts</p>
                <?php if (false) { ?>
                  <a href="<?= Url::toRoute(['posts/default/index']) ?>">See All</a>
                <?php } ?>
              </div>
              <div class="row">
                <?php if ($posts) { ?>
                  <?php foreach ($posts as $post) { ?>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                      <div class="mainParent ">
                        <div class="card border-0 h-100 d-flex">
                          <img class="w-100" style="height: 170px; object-fit: cover;" src="<?= isset($post->full_image_path) ? $post->full_image_path : $this->params['baseurl'] . "/images/Article-7.jpg" ?>" alt="Post">
                          <div class="card-body border-0 p-2">
                            <div class="cardBodyTitle">
                              <div class="subtitle pb-2">
                                <p><?= isset($post->caption) ? mb_strimwidth($post->caption, 0, 30, "...") : '' ?></p>
                              </div>
                              <div class="coLike d-flex justify-content-between">
                                <a href=""><?= isset($post->comment_count) ? $post->comment_count : '' ?> Comments</a>
                                <a href=""><?= isset($post->like_count) ? $post->like_count : '' ?> Likes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 col-xl-12 col-12 mb-3">
            <div class="h-100">
              <div class="topHead d-flex justify-content-between align-items-center mx-4">
                <p>Recent Sightings</p>
                <?php if (false) { ?>
                  <a href="<?= Url::toRoute(['sightings/default/index']) ?>">See All</a>
                <?php } ?>

              </div>
              <div class="row">
                <?php if ($sightings) { ?>
                  <?php foreach ($sightings as $sighting) { ?>
                    <div class="col-xl-4 col-md-6 col-12 h-100">
                      <div class="mainParent ">
                        <div class="card h-100 border-0 d-flex">

                          <img class="w-100" style="height: 145px; object-fit: cover;" src="<?= isset($sighting->thumbnail) ? $sighting->thumbnail : $this->params['baseurl'] . "/images/Article-2.jpg" ?>" alt="Sighting">

                          <div class="card-body border-0 p-2">
                            <div class="cardBodyTitle">
                              <div class="subtitle pb-2">
                                <p><?= isset($sighting->description) ? mb_strimwidth($sighting->description, 0, 20, "...") : '' ?></p>
                              </div>
                              <div class="coLike d-flex flex-column">
                                <a href="" class="pb-2"><?= isset($sighting->comment_count) ? $sighting->comment_count : '' ?> Comments</a>
                                <a href=""><?= isset($sighting->like_count) ? $sighting->like_count : '' ?> Likes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if (false) { ?>
        <div class="col-xxl-12">
          <div class="row">
            <div class="col-xxl-6 col-xl-12 col-12 mb-3">
              <div class="h-100">
                <div class="topHead d-flex justify-content-between align-items-center pb-2 mx-4">
                  <p>Most Requested Packages</p>
                  <a href="/package/default/index">See All</a>
                </div>
                <div class="row">
                  <?php if (!empty($packages)) { ?>
                    <?php foreach ($packages as $package) { ?>
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                        <div class="mainParent ">
                          <div class="card h-100 d-flex">

                            <img class="w-100" style="height: 170px; object-fit: cover;" src="<?= isset($package->package_image) ? $package->package_image : $this->params['baseurl'] . "/images/Article-7.jpg" ?>" alt="Card image cap">

                            <div class="card-body p-2">
                              <div class="cardBodyTitle">
                                <div class="subtitle pb-2">
                                  <p><?= isset($package->package_name) ? $package->package_name : '' ?></p>
                                </div>
                                <div class="coLike d-flex justify-content-between">
                                  <a href=""><?= isset($package->total_view) ? $package->total_view : '' ?> Interests</a>
                                  <a href="">Rs.<?= isset($package->cost_per_person) ? $package->cost_per_person : '' ?>/-</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } ?>
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
                  <?php if (!empty($demanding_parks)) { ?>
                    <?php foreach ($demanding_parks as $parks) { ?>
                      <div class="col-xxl-6 col-xl-6 col-lg-6 col-12 h-100">
                        <div class="mainParent ">
                          <div class="card h-100 d-flex">
                            <img src="assets/images/Article-7.jpg" alt="" class="w-100"
                              style="height: 170px; object-fit: cover;">
                            <div class="card-body p-2">
                              <div class="cardBodyTitle">
                                <div class="subtitle pb-2">
                                  <p><?= isset($parks->title) ? $parks->title : '' ?></p>
                                </div>
                                <div class="coLike d-flex justify-content-between">
                                  <?php if (!empty($operator_quotes)) { ?>
                                    <a href=""><?= isset($operator_quotes['quote_count']) ? $operator_quotes['quote_count'] : '' ?></a> <!--not rendering properly-->
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="col-xxl-2 mb-3">
    <div class="row">
      <div class="col-xl-12 mb-3">
        <div class="rightSidebar">
          <div class="cadplaform">
            <p class="mb-2 headbg">New Feature Unlocked! 🔥</p>
            <p class="mb-3">Now create safari packages and photo album directly from your partner panel.</p>
            <div class="d-flex flex-column gap-2">
              <a href="<?= Url::toRoute(['/package/default/index']) ?>" class="rounded text-center">Package</a>
              <a href="<?= Url::toRoute(['/gallery/default/index']) ?>" class="rounded text-center">Gallery</a>
            </div>
            <!-- <a href="">Read Partner Handbook</a> -->
            <!-- <a href="">Coming Soon</a> -->
          </div>
        </div>
      </div>
      <div class="col-xl-12 mb-3">
        <div class="progressBar">
          <div class="qout">
            <!-- <div class="montlyQouteHeader mb-2 px-4 pt-3">
              <p>Monthly Quote Requests</p>
            </div> -->
            <img src="<?= $this->params['baseurl'] ?>/images/Learning Hours Container.png" alt="" class="w-100 object-fit-cover">

            <div class="bodySectionParent">
              <?php if (false) { ?>
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
              <?php } ?>
            </div>

          </div>
        </div>
      </div>

      <div class="col-xl-12 mb-3">

        <img src="<?= $this->params['baseurl'] ?>/images/Leaderboard Container.png" alt="" class="w-100 object-fit-cover">

        <?php if (false) { ?>

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
        <?php } ?>

      </div>

    </div>
  </div>
</div>