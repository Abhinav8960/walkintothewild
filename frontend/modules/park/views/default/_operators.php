<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="col-lg-4 col-xl-3 col-xxl-2 mb-4 position-relative">
    <div id="targetDiv">
        <?= $this->render('_operator_side_search', [
            'model' => $operatorsearchModel,
            'safari_model' => $model,
            'device' => $device,
        ]) ?>
    </div>

    <div class="advertisment pt-5 d-lg-block d-none">
        <p class="text-center">ADVERTISMENT</p>
        <div class="advertisment_box-2">

        </div>
    </div>
</div>
<div class="col-lg-8 col-xl-9 col-xxl-10 position-relative">

    <div class="topfilter d-lg-flex d-none justify-content-between align-items-center w-100 pe-xl-5">
        <div class="left_text">
            <p class="">There are currently <strong>0</strong> active shared safaris created by individuals</p>
        </div>
        <div class="right-select d-flex gap-2 align-items-center pe-xl-2">
            <div class="input_check pb-0">
                <?php if ($device == 'desktop') {  ?>
                    <select class="form-select mb-2" aria-label="Default select example" id="custom_sort_by">
                        <option value="name_az" <?= $operatorsearchModel->custom_sort_by == 'name_az' || $operatorsearchModel->custom_sort_by == '' ? 'selected' : '' ?>>Sort By: Name A-Z</option>
                        <option value="name_za" <?= $operatorsearchModel->custom_sort_by == 'name_za' ? 'selected' : '' ?>>Name Z-A</option>
                        <option value="rating_high" <?= $operatorsearchModel->custom_sort_by == 'rating_high' ? 'selected' : '' ?>>Rating High</option>
                        <option value="rating_low" <?= $operatorsearchModel->custom_sort_by == 'rating_low' ? 'selected' : '' ?>>Rating Low</option>
                    </select>
                <?php } ?>
            </div>
            <!-- <div class="gridListview">
                  <a href="#" id="toggleViewBtn"><i class="fas fa-list"></i></a>
                </div> -->
        </div>
    </div>
    <div class="top_mobilefilter d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
        <div class="left_text">
            <p class="">There are currently <strong>0</strong> active shared safaris created by individuals</p>
        </div>
        <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
            <div class="input_check pb-0">
                <div class="filter_searchbox">
                    <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                </div>
            </div>

        </div>
    </div>
    <div class="gridview mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-2 g-xl-4 gx-lg-4">
            <?php if ($operators) {
                foreach ($operators as $operator) {
            ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xl-4 col-xxl-3 mb-3">
                        <a href="<?= Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]) ?>" class="oprators_boxes">
                            <div class="listingSafari ">
                                <?php if ($operator->is_highlighted) { ?>
                                    <div class="higlighted">
                                        <p>Highlighted</p>
                                    </div>
                                <?php } ?>
                                <div class="card-body ">
                                    <div class="logo_provide2">
                                        <img src="<?= isset($operator->logo) ? $operator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                        <!-- <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100" loading="lazy"> -->
                                    </div>
                                    <div class="provider_details  px-2">
                                        <h6 class="pname py-3 border-top"><?= $operator->register_comapany_name ?></h6>
                                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                            <div class="ratings">

                                                <p class="mb-0"><?= $operator->google_rating ?>
                                                    <?= GeneralModel::ratiing_views($operator->google_rating); ?>
                                                </p>
                                            </div>
                                            <div class="googlerating">
                                                <p class="mb-0"><?= isset($operator->google_review_count) ? $operator->google_review_count . 'Reviews' : '0 Reviews' ?> </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="footer_provider ">
                                    <div class="slect_safricound d-flex justify-content-around">
                                        <div class="parks_text text-center">
                                            <p><?= $operator->getPark()->andWhere(['status' => 1])->count() ?></p>
                                            <p>Parks</p>
                                        </div>
                                        <div class="parks_text text-center">
                                            <p>0</p>
                                            <p>Resorts</p>
                                        </div>
                                        <div class="parks_text text-center">
                                            <p>0</p>
                                            <p>Shared Safari</p>
                                        </div>
                                    </div>
                                    <div class="get_quote text-center">
                                        <a href="<?= Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]) ?>" class="get_quote_btn">GET A FREE QUOTE</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php }
            } ?>

        </div>
        <div class="padding_right">
            <div class="backgroud_oprator">
                <div class="title_safari JoinPadding d-flex justify-content-between align-items-center flex-wrap">
                    <h4>Join Shared Safaris in Bandhavgarh Tiger Reserve</h4>
                    <div class="joinshareView mt-xl-0 mt-3">
                        <a href="" class="btn_shareView">View All</a>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 gx-xxl-2 g-xl-4 gx-lg-4 justify-content-center">
                    <div class="col mb-xl-0 mb-3 pe-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                            </div>
                            <div class="card_body">
                                <div class="top_seats">
                                    <div class="safari d-flex justify-content-between ">
                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                            <p class="text_safari">SAFARI</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                            <p class="text_safari">SEATS</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="titleDate">
                                    <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                    <div class="orgnizer">
                                        <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                    </div>
                                </div>
                                <div class="footer_card row pb-2 px-2 align-items-center">
                                    <div class="col-6">
                                        <div class="users">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <div class="roundes_countuser">
                                                15+
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="safari text-center">
                                            <div class="joinsafari">
                                                <a href="/sharesafari">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-xl-0 mb-3 pe-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                            </div>
                            <div class="card_body">
                                <div class="top_seats">
                                    <div class="safari d-flex justify-content-between ">
                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                            <p class="text_safari">SAFARI</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                            <p class="text_safari">SEATS</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="titleDate">
                                    <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                    <div class="orgnizer">
                                        <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                    </div>
                                </div>
                                <div class="footer_card row pb-2 px-2 align-items-center">
                                    <div class="col-6">
                                        <div class="users">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <div class="roundes_countuser">
                                                15+
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="safari text-center">
                                            <div class="joinsafari">
                                                <a href="/sharesafari">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-xl-0 mb-3 pe-4">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                            </div>
                            <div class="card_body">
                                <div class="top_seats">
                                    <div class="safari d-flex justify-content-between ">
                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                            <p class="text_safari">SAFARI</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                            <p class="text_safari">SEATS</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="titleDate">
                                    <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                    <div class="orgnizer">
                                        <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                    </div>
                                </div>
                                <div class="footer_card row pb-2 px-2 align-items-center">
                                    <div class="col-6">
                                        <div class="users">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <div class="roundes_countuser">
                                                15+
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="safari text-center">
                                            <div class="joinsafari">
                                                <a href="/sharesafari">Join Safari</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col  pe-4 pe-xl-0">
                        <div class="sharesafri-card">
                            <div class="flotingdate">
                                <div class="icons text-center">
                                    <p class="mb-0">OCT</p>
                                    <p class="mb-0">3</p>
                                </div>
                            </div>
                            <div class="shareimg">
                                <a href="/sharesafari"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                            </div>
                            <div class="card_body">
                                <div class="top_seats">
                                    <div class="safari d-flex justify-content-between ">
                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                            <p class="text_safari">SAFARI</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                            <p class="text_safari">SEATS</p>
                                            <h6 class="number-safari">5</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="titleDate">
                                    <h6><a href="/sharesafari">Bandhavgarh Tiger Reserve</a></h6>
                                    <div class="orgnizer">
                                        <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                    </div>
                                </div>
                                <div class="footer_card row pb-2 px-2 align-items-center">
                                    <div class="col-6">
                                        <div class="users">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                            <div class="roundes_countuser">
                                                15+
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="safari text-center">
                                            <div class="joinsafari">
                                                <a href="/sharesafari">Join Safari</a>
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


<?php
$script = <<< JS
    $('#custom_sort_by').on('change', function(){
        $('#safarioperatorsearch-custom_sort_by').val(this.value);
        $('#safarioperatorsearch').submit();
    });
JS;
$this->registerJs($script);
?>