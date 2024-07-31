<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;


$this->title = 'Package';
$this->params['title'] = $this->title;
$page_constant = Constants::PACKAGE_LIST;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $page_constant])->limit(1)->one();
?>


<div class="fixedbanner">
  <section class="banner_section-inner packagebnner  position-relative">
    <picture class="position-relative">
      <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
      <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="headingBnner_inner">
              <h1>Wildlife Safari tour packages</h1>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<section class="articals_wrapper margin-setposi py-3 margin_bottomfooter" style="background-color: #fff; margin-top: 190px !important; padding-top:30px;">
  <div class="container-fluid ">
    <div class="custom-row pt-4">
      <div class="custom-col">
        <div class="topSlider_tour owl-carousel owl-theme">
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/slideeee.png" alt="" class="custom-image">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/soonbanner.jpg" alt="" class="custom-image">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/slideeee.png" alt="" class="custom-image">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="custom-image">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="custom-image">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="custom-image">
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-4 pt-5">
      <div class="col-xl-11 col-lg-12">
        <div class="row mb-5 justify-content-center">
          <?= $this->render('_select_filter', [
            'searchModel' => $searchModel,
          ]) ?>
          <div class="col-lg-9 col-xl-9 col-xxl-10  px-lg-5">
            <div class="row ">
              <div class="col-12">
                <div class="topfilter d-flex justify-content-between align-items-center mb-2 flex-wrap w-100 ">
                  <div class="left_text">
                    <p class="mb-0">There are currently <strong><?= count($models) ?></strong> active package.</p>
                  </div>
                  <?= $this->render('_sort_by_form', ['searchModel' => $searchModel]) ?>

                </div>
              </div>
              <div class="col-12">
                <div class="tag-container">
                  <?php if ($searchModel->park_id) {
                    $selected_park = $searchModel->parkoption[$searchModel->park_id];
                    if ($selected_park) { ?>
                      <div class="tag"><?= $selected_park ?> <span class="close-btn remove_dropdown_filter" data-attribute="park_id">×</span></div>
                  <?php }
                  } ?>

                  <?php if ($searchModel->month_id) {
                    $selected_month = GeneralModel::monthoption()[$searchModel->month_id];
                    if ($selected_month) { ?>
                      <div class="tag"><?= $selected_month ?> <span class="close-btn remove_dropdown_filter" data-attribute="month_id">×</span></div>
                  <?php }
                  } ?>

                  <?php if ($searchModel->stay_category_id) {
                    foreach ($searchModel->stay_category_id as  $stay_category_id) {
                      $selected_price = GeneralModel::budgetoption()[$stay_category_id];
                      if ($selected_price) {
                  ?>
                        <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $stay_category_id ?>" data-attribute="stay_category_id">×</span></div>

                  <?php }
                    }
                  } ?>


                  <?php if ($searchModel->package_feature) {
                    foreach ($searchModel->package_feature as  $package_feature) {
                      $selected_price = GeneralModel::packagefeatureoption()[$package_feature];
                      if ($selected_price) {
                  ?>
                        <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $package_feature ?>" data-attribute="package_feature">×</span></div>

                  <?php }
                    }
                  } ?>

                  <?php if ($searchModel->package_include) {
                    foreach ($searchModel->package_include as  $package_include) {
                      $selected_price = GeneralModel::packageincludeoption()[$package_include];
                      if ($selected_price) {
                  ?>
                        <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $package_include ?>" data-attribute="package_include">×</span></div>

                  <?php }
                    }
                  } ?>

                </div>
              </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-5">
              <?php if ($models) {
                foreach ($models as $model) { ?>
                  <div class="col mb-4 padding_righ">
                    <div class="sharesafri-card tourpackage">
                      <div class="flotingdate">
                        <div class="icons text-center">
                          <p class="mb-0"><?= isset($model->no_of_day) ? $model->packagedaynightlabels : " " ?> </p>
                        </div>
                      </div>
                      <div class="floating-watchlist">
                        <?php
                        if (false && Yii::$app->user->identity) { ?>
                          <div class="heart_bx">
                            <?php
                            $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $model->id, 'item_type_id' => 1, 'status' => 1])->limit(1)->one();
                            if ($wishlist) {
                            ?>
                              <a href="/package/unwishlist/<?= $model->package_slug ?>" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                            <?php } else { ?>
                              <a href="/package/wishlist/<?= $model->package_slug ?>" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                            <?php }
                            ?>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="shareimg">
                        <a href="/package/<?= $model->package_slug ?>">
                          <img src="<?= isset($model->package_image) ? $model->imagepath : $this->params['baseurl'] . '/img/blog_details01.jpg' ?>" alt=""></a>
                      </div>
                      <div class="card_body">
                        <div class="titleDate">
                          <h6 class="pt-1"><a href=""><?= $model->package_name ?> </a></h6>
                          <div class="orgnizer_tour d-flex justify-content-between pt-2">
                            <div class="icons_restro">
                              <i class="fa-solid fa-car-side"></i>
                              <p class="mb-0"><?= $model->no_of_safari ?> Safaris</p>
                            </div>
                            <div class="icons_restro">
                              <i class="fa-solid fa-car"></i>
                              <p class="mb-0"><?= $model->pickanddrop ?></p>
                            </div>
                            <div class="icons_restro">
                              <i class="fa-solid fa-utensils"></i>
                              <p class="mb-0"><?= $model->meals ?></p>
                            </div>
                            <div class="icons_restro">

                              <i class="fa-solid fa-building"></i>
                              <p class="mb-0"><?= isset($model->packagerange->title) ? $model->packagerange->title : "" ?></p>
                            </div>
                          </div>
                        </div>
                        <div class="footer_card row pb-2 px-2 align-items-center">
                          <div class="col-7">
                            <div class="safaritourlogo">
                              <img src="<?= isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="safari text-center">
                              <div class="joinsafari package">
                                <h6 class=" titlePrice">₹<?= $model->total_price ?> </h6>
                                <a href="/package/<?= $model->package_slug ?>">View Details</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

              <?php }
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="modal fade _standard-text" id="package-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create a New Package</h1>
        <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
      </div>
      <div class="modal-body px-2 pt-0">
        <div id='modalContent'></div>
      </div>
    </div>
  </div>
</div>

<?php
$script = <<< JS
function organizefunction() {
	$('.packageBtn').on('click', function () {
        $('#package-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
             
JS;
$this->registerJs($script);
?>

<script>
  document.querySelectorAll('.range-slider').forEach(slider => {
    slider.addEventListener('input', (event) => {
      const sliderEl = event.target;
      const valueEl = sliderEl.nextElementSibling.querySelector('.value');
      const tempSliderValue = sliderEl.value;
      const displayText = sliderEl.getAttribute('data-display-text');

      // Update the slider value text based on the display text attribute
      if (displayText === 'Nights') {
        valueEl.textContent = `${tempSliderValue} Nights`;
      } else {
        valueEl.textContent = tempSliderValue;
      }

      const progress = (tempSliderValue / sliderEl.max) * 100;

      // Update the background color to show the progress
      sliderEl.style.background = `linear-gradient(to right, #09422D ${progress}%, #919191 ${progress}%)`;
    });
  });
</script>

<?php
$script = <<< JS

       
JS;
$this->registerJs($script);
?>
<script>
  // JavaScript to add a class to the parent element based on the child element
  document.addEventListener('DOMContentLoaded', (event) => {
    const childElement = document.querySelector('.tag');
    if (childElement) {
      const parentElement = childElement.closest('.tag-container');
      if (parentElement) {
        parentElement.classList.add('mb-4');
      }
    }
  });
</script>