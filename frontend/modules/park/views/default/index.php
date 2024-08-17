<?php


use common\interfaces\Constants;
use common\models\cms\banner\Banner;

/* @var $this yii\web\View */

$this->title = 'Park Search Result';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::PARK_LIST;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>

<?php if ($searchModel->master_rare_animal_id == '') { ?>

    <div class="fixedbanner">
        <section class="banner_section-inner  position-relative">
            <picture class="position-relative">
                <source srcset="<?= isset($banner->imagepath) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" media="(max-width:576px)" type="image/webp">
                <img src=" <?= isset($banner->imagepath) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
            </picture>
            <div class="banner_searchBox">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="tab-block" id="tab-block">
                                <div class="tab-cont">
                                    <div class="tab-pane">
                                        <div class="row gx-0">
                                            <?= $this->render('_advance_search', [
                                                'model' => $searchModel,
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php } else { ?>
    <section class="banner_section-inner position-relative">
        <picture class="position-relative">
            <source srcset="<?= isset($banner->imagepath) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
            <img src="<?= isset($banner->imagepath) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 " alt="banner">
        </picture>
        <div class="banner_searchBox">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="headingBnner_inner">
                            <h1>Rare and Exotic Animal Safaris</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section class="articals_wrapper margin_bottomfooter mb-5 py-3 <?= $searchModel->master_rare_animal_id == '' ? 'margin-setposi' : '' ?>">
    <div class="container-fluid">
        <!-- <div class="row justify-content-center">
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div> -->
        <div class="row mb-4 sticky_set e">
            <div class="col-xl-2 col-lg-3 col-12 mb-lg-0 mb-3 ps-xxl-5 pe-xl-2 pt-3">
                <div id="targetDiv">
                    <?= $this->render('_park_side_search', [
                        'model' => $searchModel,
                        'device' => $device,
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-9 col-xl-10 col-12 paddingset_desktop ">
                <div class="topfilter d-lg-flex d-none justify-content-between align-items-center w-100 mb-2">
                    <div class="left_text">
                        <p class="mb-0"> We found <strong class="parklistcount"> <?= $dataProvider->totalcount ?> Parks</strong> for you</p>
                    </div>
                    <div class="right-select mb-md-0 mb-4">
                        <div class="input_check pb-0">

                            <?php if ($device == 'desktop') { ?>
                                <form id="custom_sort_by_form">
                                    <select class="form-select mb-2 custom_sort_by_input" aria-label="Default select example" name="SafariParkSearch[custom_sort_by]" id="safariparksearch-custom_sort_by">
                                        <?php
                                        $sort_option = [1 => 'Most Demanding', 2 => 'A to Z', 3 => 'Z to A'];
                                        ?>
                                        <option value="" style="display:none;" <?= $searchModel->custom_sort_by == '' ? 'selected' : '' ?>>Sort by : <span class="font_colorSet "> <?= isset($sort_option[$searchModel->custom_sort_by]) ? $sort_option[$searchModel->custom_sort_by] : 'Most Demanding' ?></span></option>
                                        <option value="1" class="<?= $searchModel->custom_sort_by == '1' ? 'selected' : '' ?>">Most Demanding</option>
                                        <option value="2" class="<?= $searchModel->custom_sort_by == '2' ? 'selected' : '' ?>">A to Z</option>
                                        <option value="3" class="<?= $searchModel->custom_sort_by == '3' ? 'selected' : '' ?>">Z to A</option>

                                    </select>
                                </form>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="top_mobilefilter mb-3 d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
                    <div class="left_text">
                        <p class="mb-0"> We found <strong class="parklistcount"> <?= $dataProvider->totalcount ?> Parks</strong> for you</p>
                    </div>
                    <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
                        <div class="input_check pb-0">
                            <div class="filter_searchbox">
                                <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="ajaxSafariParkData" class="">
                    <?php
                    // $pjax = \yii\widgets\Pjax::begin();

                    // Retrieve models from data provider
                    $models = $dataProvider->getModels();

                    if (!empty($models)) {
                        // Render ListView if there are models
                        echo \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'list-view-park row view-content mt-20 mla-mp-card-wrapper'],
                            'itemView' => function ($model) {
                                return $this->render('_item', ['model' => $model]);
                            },
                            'summary' => false, // Disable summary (including "No results found")
                            'itemOptions' => [
                                'tag' => false // if you want to avoid extra div's
                            ],
                            'layout' => '{items}<div class="pagination-wrap" style="display:none">{pager}</div>',
                            'pager' => [],
                        ]);
                    } else {
                        // Handle case where no data is available
                        echo '<div class="no-results-found">No results found.</div>';
                    }

                    // \yii\widgets\Pjax::end();
                    ?>

                </div>
                <div class="col-md-12 loader text-center" style="display: none;">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>



<!-- <section class="safariduring_sesons innerpage pt-5 mb-4">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section> -->


<?php
// Assuming $models is passed as JSON-encoded data from your Yii controller or view
$js = <<<JS
$(document).ready(function() {
    var win = $(window);
    var isLoading = false; // Flag to prevent multiple simultaneous Ajax requests

    win.scroll(function() {
        if (!isLoading && ($(document).height() - win.height() <= win.scrollTop() + 1500)) {
            $(".loader").show();
            isLoading = true; // Set loading flag to true to prevent multiple requests

            var nextPageUrl = $(".pagination .next a:first").attr("href");
            if(nextPageUrl==undefined){
                isLoading = false;
                $(".loader").html('<div class="no-results-found">No more results found.</div>');
            }
            var tabindex = $(".pagination .next a:first").attr("tabindex");
            if(tabindex==undefined){
                if (nextPageUrl) { // Check if there are more pages and models exist
                    setTimeout(function() {
                        loadPage(nextPageUrl);
                    }, 500); // Delay for 500 milliseconds before making the Ajax call
                } else {
                    isLoading = false; // Reset loading flag if no more models to load
                }
            }else{
                isLoading = false;
                $(".loader").html('<div class="no-results-found">No more results found.</div>');
            }
        }
    });

    function loadPage(url) {
        $.ajax({
            url: url,
            beforeSend: function(xhr) {},
            success: function(response) {
                $(".loader").hide();
                var html = $(response);
                $("#w0").append(html.find(".list-view-park").html());
                $(".pagination").html(html.find(".pagination").html());
                $(".parklistcount").text($(".list-view-park .parking_Box").length);
                isLoading = false; // Reset loading flag after successful load
            },
            error: function(xhr, status, error) {
                console.error("Ajax request failed: " + error);
                isLoading = false; // Reset loading flag on error
            }
        });
    }
});
JS;

$this->registerJs($js);
?>