<?php



use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package';
$this->params['title'] = $this->title;
$page_constant = Constants::PACKAGE_LIST;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $page_constant])->limit(1)->one();
?>



<section class="banner_section-inner packagebnner position-relative">
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

<section class="articals_wrapper  py-3 ">
  <?php if (FALSE && $package_banner_model) { ?>
    <div class="container-fluid px-slider">
      <div class="custom-row pt-4">
        <div class="custom-col">
          <div class="topSlider_tour owl-carousel owl-theme">
            <?php
            foreach ($package_banner_model as $package_banner) { ?>
              <div class="items_slider">

                <a href="<?= $package_banner->url ?>">
                  <img src="<?= isset($package_banner->imagepath) ? $package_banner->imagepath : $this->params['baseurl'] . '/img/Eagle-Safarisnew.jpg' ?>" alt="" class="custom-image">
                </a>

              </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <div class="container-fluid ">

        <div class="advertisment pt-md-2 pt-5" >
            <div class="google-ad-box  mb-5" style="border:none">
                <ins class="adsbygoogle"
                    style="display:inline-block;width:728px;height:90px"
                    data-ad-client="ca-pub-6116324330184807"
                    data-ad-slot="1321270892"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    <?php
    Pjax::begin([
      'id' => 'grid-data',
      'enablePushState' => FALSE,
      'enableReplaceState' => FALSE,
      'timeout' => false,
    ]);
    ?>
    <?php $form = ActiveForm::begin([
      'options' => [
        'data-pjax' => true,
        'id' => 'side-search-form'
      ],
      'action' => ['index'],
      'method' => 'get',
    ]); ?>
    <div class="row justify-content-center mb-4 pt-lg-5 margin_bottomfooter">
      <div class="col-xl-11 col-lg-12">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4 pt-3">
            <div id="targetDiv">

              <?= $this->render('_select_filter', [
                'form' => $form,
                'searchModel' => $searchModel,
                'device' => $device,
              ]) ?>
            </div>

                <div class="advertisment d-lg-block d-none mt-5">
                    <div class="google-ad300  mb-5" style="border:none">
                        <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-client="ca-pub-6116324330184807"
                        data-ad-slot="5518372486"
                        data-ad-format="auto"
                        data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                <div class="advertisment d-lg-block d-none" style="display:none !important;">
                    <div class="google-add600hight  mb-5">

                    </div>
                </div>

          </div>
          <div class="col-lg-9 col-xl-9 col-xxl-10  px-lg-5">
            <div class="row ">
              <div class="col-12">
                <div class="topfilter d-lg-flex d-none justify-content-between align-items-center  w-100 mb-2 ">
                  <div class="left_text">
                    <p class="mb-0">There are currently <strong><?= count($models) ?></strong> active packages</p>
                  </div>
                  <?php if ($device == 'desktop') { ?>
                    <?= $this->render('_sort_by_form', ['form' => $form, 'searchModel' => $searchModel]) ?>
                  <?php } ?>
                </div>
                <div class="top_mobilefilter d-flex gap-2 d-lg-none justify-content-between align-items-center w-100 mb-4">
                  <div class="left_text">
                    <p class="mb-0">There are currently <strong><?= count($models) ?></strong> active packages</p>
                  </div>
                  <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
                    <div class="input_check pb-0">
                      <div class="filter_searchbox">
                        <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                      </div>
                    </div>

                  </div>
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

            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-5">
              <?php if ($models) {
                $count = 0;
                $r = -1;
                foreach ($models as $model) {
                  $count++; ?>
                  <div class="col mb-xl-4 mb-md-3 mb-4 padding_righ">
                    <?php if ($count == 4 or ($count > 3 && $count % 3 == 0)) $r = rand(0, 2);
                    if ($count % 3 == $r) { //echo $count; 
                    ?>
                      <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-format="fluid"
                        data-ad-layout-key="-6s+e8+5t-6g-8m"
                        data-ad-client="ca-pub-6116324330184807"
                        data-ad-slot="1536893312"></ins>
                  </div>
                  <div class="col mb-xl-4 mb-md-3 mb-4 padding_righ">
                    <script>
                      (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                  <?php  } ?>
                  <?= $this->render('_package_card', ['model' => $model]) ?>
                  </div>
              <?php }
              } ?>

            </div>
            <div class="mt-3 table-footer d-flex justify-content-between align-items-center mb-3">
              <div class="col-md-12">
                <?php echo GridView::widget([
                  'dataProvider' => $dataProvider,
                  'layout' => '{pager}',
                  'columns' => [],
                ]); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
</section>

<script>
  var mobileSearchDivPackage = document.getElementById('mobileSearchDiv');
  var targetDivPackage = document.getElementById('targetDiv');
  var formSelectPackage = document.querySelector('.form-select');

  if (mobileSearchDivPackage && targetDivPackage) {
    mobileSearchDivPackage.addEventListener('click', function(event) {
      event.stopPropagation(); // Prevent the default behavior
      targetDivPackage.style.display = targetDivPackage.style.display === 'none' ? 'block' : 'block';
    });

    if (formSelectPackage) {
      formSelectPackage.addEventListener('click', function(event) {
        event.stopPropagation();
      });
    }
  }
</script>


<?php Pjax::end(); ?>



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