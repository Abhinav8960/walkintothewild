<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="row">
    <div class="col-lg-4 col-xl-3 col-xxl-2 mb-4 ">
        <div id="targetDiv">
            <?= $this->render('_operator_side_search', [
                'model' => $operatorsearchModel,
                'safari_model' => $model,
                'device' => $device,
            ]) ?>
        </div>
        <div id="targetDiv">
            <?= $this->render('_park_review', [
                'model' => $operatorsearchModel,
                'safari_model' => $model,
                'device' => $device,
            ]) ?>
        </div>
        <div id="targetDiv">
            <?= $this->render('_park_contribution', [
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
        <div class="topfilter d-lg-flex d-none justify-content-between  w-100 mb-2">
            <div class="left_text">
                <p class="mb-0">There are currently <strong><?= count($operators) ?></strong> safari tour operator</p>
            </div>
            <div class="right-select d-flex gap-2 align-items-center pe-xl-2">
                <div class="input_check pb-0">
                    <?php if ($device == 'desktop') {  ?>
                        <select class="form-select mb-2" aria-label="Default select example" id="custom_sort_by">
                            <option value="" <?= $operatorsearchModel->custom_sort_by == '' ? 'selected' : '' ?>>Short By: Rating High</option>
                            <option value="rating_low" <?= $operatorsearchModel->custom_sort_by == 'rating_low' ? 'selected' : '' ?>>Short By: Rating Low</option>
                            <option value="name_az" <?= $operatorsearchModel->custom_sort_by == 'name_az' || $operatorsearchModel->custom_sort_by == '' ? 'selected' : '' ?>>Short By: Name A-Z</option>
                            <option value="name_za" <?= $operatorsearchModel->custom_sort_by == 'name_za' ? 'selected' : '' ?>>Short By: Name Z-A</option>
                        </select>
                    <?php } ?>
                </div>
                <!-- <div class="gridListview">
                  <a href="#" id="toggleViewBtn"><i class="fas fa-list"></i></a>
                </div> -->
            </div>
        </div>
        <div class="top_mobilefilter d-flex gap-2 d-lg-none justify-content-between align-items-center w-100 mb-4">
            <div class="left_text">
                <p class="mb-0">There are currently <strong>0</strong> active shared safaris created by individuals</p>
            </div>
            <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
                <div class="input_check pb-0">
                    <div class="filter_searchbox">
                        <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="gridview mt-2">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-4">
                <?php
                $counter = 0; // Initialize counter variable

                if ($operators) {
                    foreach ($operators as $operator) {
                        if ($counter >= 4) {
                            break; // Exit the loop if counter reaches 4
                        }
                ?>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xl-4 col-xxl-3 mb-3">
                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" class="oprators_boxes">
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
                                            <h6 class="pname py-3 border-top"><?= $operator->businessname ?></h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">

                                                    <p class="mb-0"><?= round($operator->google_rating, 1) ?>
                                                        <?= GeneralModel::ratiing_views($operator->google_rating); ?>
                                                    </p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0"><?= isset($operator->google_review_count) ? $operator->google_review_count . ' Reviews' : '0 Reviews' ?> </p>
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
                                                <p>Packages</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>0</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                        $counter++; // Increment the counter after each operator
                    }
                } ?>

            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-4">
                <?php
                $counter = 0; // Initialize counter variable

                if ($operators) {
                    foreach ($operators as $operator) {
                        if ($counter < 4) {
                            // Skip the first 4 operators
                            $counter++;
                            continue;
                        }
                ?>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xl-4 col-xxl-3 mb-3">
                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" class="oprators_boxes">
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
                                            <h6 class="pname py-3 border-top"><?= $operator->businessname ?></h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">

                                                    <p class="mb-0"><?= $operator->google_rating ?>
                                                        <?= GeneralModel::ratiing_views($operator->google_rating); ?>
                                                    </p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0"><?= isset($operator->google_review_count) ? $operator->google_review_count . ' Reviews' : '0 Reviews' ?> </p>
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
                                                <p>Packages</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>0</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                        $counter++; // Increment the counter after each operator
                    }
                } ?>

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