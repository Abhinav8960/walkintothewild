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
                <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" media="(max-width:576px)" type="image/webp">
                <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
            </picture>
            <div class="banner_searchBox">
                <div class="container-lg">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="tab-block" id="tab-block">
                                <ul class="tab-mnu d-md-flex d-none">
                                    <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="" class="me-2">Safari</li>
                                    <li> <img src="<?= $this->params['baseurl'] ?>/img/birdingicon.png" alt="" width="29" class="me-2">Birding</li>
                                    <!-- <li> <img src="<?= $this->params['baseurl'] ?>/img/resorticon.png" alt="" width="29" class="me-2"> Resort</li> -->
                                </ul>

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
        </section>
    </div>
<?php } else { ?>
    <section class="banner_section-inner position-relative">
        <picture class="position-relative">
            <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
            <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 " alt="banner">
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
<section class="articals_wrapper py-3 <?= $searchModel->master_rare_animal_id == '' ? 'margin-setposi' : '' ?>">
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
            <div class="col-xl-2 col-lg-3 col-12 mb-lg-0 mb-3 ps-xxl-5 pe-xl-2">
                <div id="targetDiv">
                    <?= $this->render('_park_side_search', [
                        'model' => $searchModel,
                        'device' => $device,
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-9 col-xl-10 col-12 paddingset_desktop ">
                <div class="topfilter d-lg-flex d-none justify-content-between align-items-center w-100">
                    <div class="left_text">
                        <p class="">We found <strong class="parklistcount"><?= count($models) ?> parks</strong> for you</p>
                    </div>
                    <div class="right-select mb-md-0 mb-4">
                        <div class="input_check pb-0">

                            <form id="custom_sort_by_form">
                                <select class="form-select mb-2" aria-label="Default select example" name="SafariParkSearch[custom_sort_by]" id="safariparksearch-custom_sort_by">
                                    <option value="" <?= !in_array($searchModel->custom_sort_by, ['most-demanding', 'shared-safari']) ? 'selected' : '' ?>>Sort By: Relevant</option>
                                    <option value="most-demanding" <?= $searchModel->custom_sort_by == 'most-demanding' ? 'selected' : '' ?>>Most Demanding</option>

                                </select>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="top_mobilefilter mb-3 d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
                    <div class="left_text">
                        <p class="mb-0">We found <strong class="parklistcount"><?= count($models) ?> parks</strong> for you</p>
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
                    $pjax = \yii\widgets\Pjax::begin();
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['class' => 'list-view-park row view-content mt-20 mla-mp-card-wrapper'],
                        'itemView' => function ($model) {
                            return $this->render('_item', ['model' => $model]);
                        },
                        'summary' => true,
                        'itemOptions' => [
                            'tag' => false //if you want to avoid extra div's
                        ],
                        'layout' => '{items}<div class="pagination-wrap" style="display:none">{pager}</div>',
                        'pager' => [],
                    ]);
                    \yii\widgets\Pjax::end();
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



<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>


<?php
$js = '
$(document).ready(function() {
    var win = $(window);
    win.scroll(function() {
        console.log($(document).height() , win.height() , win.scrollTop());
        if ($(document).height() - win.height() == win.scrollTop()) {
            $(".loader").show();
            if ($(".pagination .next a:first").attr("href")) {
                var timeDelay = 500;           // MILLISECONDS (5 SECONDS).
                setTimeout(loadPage, timeDelay);  // MAKE THE AJAX CALL AFTER A FEW SECONDS DELAY.
            }
        }
    });

    function loadPage() {
        $.ajax({
            url: $(".pagination .next a:first").attr("href"),
            beforeSend: function(xhr) {},
            success: function(text) {
                $(".loader").hide();
                var html = $(text);
                $("#w0").append(html.find(".list-view-park").html());
                $("body").find(".pagination").html(html.find(".pagination").html());
                $(".parklistcount").text($(".list-view-park .parking_Box").length);
            }
        });
    }
});
';
$this->registerJs($js);
?>
