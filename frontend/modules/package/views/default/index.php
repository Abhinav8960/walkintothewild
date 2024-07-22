<?php

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package';
$this->params['title'] = $this->title;
?>


<div class="fixedbanner">
  <section class="banner_section-inner  position-relative">
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
              <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                Their Adventures</p> -->
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<section class="articals_wrapper margin-setposi py-3">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="topSlider_tour owl-carousel owl-theme">
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/slideeee.png" alt="" class="w-100">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/soonbanner.jpg" alt="" class="w-100">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/slideeee.png" alt="" class="w-100">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="w-100">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="w-100">
          </div>
          <div class="items_slider">
            <img src="<?= $this->params['baseurl'] ?>/img/blog_details01.jpg" alt="" class="w-100">
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mb-4">
      <div class="col-xl-11 col-lg-12">
        <div class="row my-4 justify-content-center">
          <?= $this->render('_select_filter', [
            'searchModel' => $searchModel,
          ]) ?>
          <div class="col-lg-9 col-xl-9 col-xxl-10 pe-lg-0">
            <div class="row ">
              <div class="col-12  mb-xl-5 mb-3">
                <div class="row justify-content-between">
                  <div class="col-md-5">
                  </div>
                  <div class="col-md-6 mt-md-0 mt-3">
                    <div class="right_button float-md-end">
                      <?php if (Yii::$app->user->identity) {
                        if (Yii::$app->user->identity->is_safari_operator == 1 && Yii::$app->user->identity->account_type == 3) { ?>
                          <button class="btn_newsafari packageBtn" value="<?= \yii\helpers\Url::toRoute(['/package/default/create']) ?>">+ Create New Package</button>
                        <?php }
                      } else {  ?>
                        <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/site/auth?authclient=google">+ Create New Package</a>
                      <?php } ?>
                    </div>
                  </div>
                </div>


              </div>
              <div class="col-12">
                <div class="topfilter d-flex justify-content-between align-items-center flex-wrap w-100">
                  <div class="left_text">
                    <p>There are currently <strong><?= count($models) ?></strong> active shared safaris created by individuals</p>
                  </div>
                  <div class="right-select">
                    <div class="input_check pb-0">

                      <select class="form-select mb-3" aria-label="Default select example">
                        <option selected>Sort By: Created Recently</option>
                        <option value="1">January</option>
                        <option value="2">Febraury</option>
                        <option value="3">March</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">
              <?php if ($models) {
                foreach ($models as $model) { ?>
                  <div class="col mb-4">
                    <div class="col mb-4 padding_righ">
                      <div class="sharesafri-card tourpackage">
                        <div class="flotingdate">
                          <div class="icons text-center">
                            <p class="mb-0">Jul</p>
                            <p class="mb-0">06</p>
                          </div>
                        </div>
                        <div class="shareimg">
                          <a href="/package/<?= $model->package_slug ?>">
                            <img src="<?= $model->imagepath ?>" alt=""></a>
                        </div>
                        <div class="card_body">
                          <div class="top_seats">
                            <div class="safari d-flex justify-content-between ">
                              <div class="safarinum d-flex gap-2 align-items-center ">
                                <p class="text_safari">NIGHTS</p>
                                <h6 class="number-safari"><?= $model->no_of_night ?></h6>
                              </div>
                              <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                <p class="text_safari">SAFARIES</p>
                                <h6 class="number-safari"><?= $model->no_of_safari ?></h6>
                              </div>
                            </div>
                          </div>
                          <div class="titleDate">
                            <h6 class="pt-1"><a href=""><?= $model->package_name ?> </a></h6>
                            <div class="orgnizer_tour d-flex gap-3 pt-2">
                              <div class="icons_restro">
                                <i class="fa-solid fa-building"></i>
                              </div>
                              <div class="icons_restro">
                                <i class="fa-solid fa-car"></i>
                              </div>
                              <div class="icons_restro">
                                <i class="fa-solid fa-utensils"></i>
                              </div>
                            </div>
                          </div>
                          <div class="footer_card row pb-2 px-2 align-items-center">
                            <div class="col-6">
                              <div class="safaritourlogo">
                                <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="safari text-center">
                                <div class="joinsafari package">
                                  <h6 class=" titlePrice"><?= $model->cost_per_person ?> + GST </h6>
                                  <a href="/package/<?= $model->package_slug ?>">View Details</a>
                                </div>
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