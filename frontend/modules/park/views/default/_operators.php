<?php


/* @var $this yii\web\View */

use common\models\GeneralModel;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="col-lg-4 col-xl-3 col-xxl-2 mb-4 position-relative">
<div id="targetDiv" >
<?= $this->render('_operator_side_search', [
        'model' => $operatorsearchModel,
        'safari_model' => $model
    ]) ?>
</div>
   
    <div class="advertisment pt-5">
        <p class="text-center">ADVERTISMENT</p>
        <div class="advertisment_box-2">

        </div>
    </div>
</div>
<div class="col-lg-8 col-xl-9 col-xxl-10 ps-lg-5 position-relative">
    <div class="col-12">
        <div class="topfilter d-lg-flex d-none justify-content-between align-items-center w-100">
            <div class="left_text">
                <p class="">There are currently <strong>0</strong> active shared safaris created by individuals</p>
            </div>
            <div class="right-select d-flex gap-2 align-items-center">
                <div class="input_check pb-0">

                    <select class="form-select mb-2" aria-label="Default select example">
                        <option selected>Sort By: Created Recently</option>
                        <option value="1">January</option>
                        <option value="2">Febraury</option>
                        <option value="3">March</option>
                    </select>
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
                            <a href="/operator/<?= $operator->id ?>" class="oprators_boxes">
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
                                            <a href="/operator/<?= $operator->id ?>" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php }
                } ?>

            </div>
        </div>
    </div>
</div>