<?php


/* @var $this yii\web\View */

use common\assets\NotifyAsset;
use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIntrested;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

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
        'id' => 'safarioperatorsearch'
    ],
    'action' => ['/park/' . $model->slug . ''],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-lg-4 col-xl-3 col-xxl-2 mb-4 ">
        <div id="targetDiv">
            <?= $this->render('_operator_side_search', [
                'model' => $operatorsearchModel,
                'safari_model' => $model,
                'form' => $form,
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

        <div class="advertisment d-lg-block d-none mt-5" style="display:none !important;">
            <div class="google-ad300  mb-5">

            </div>
        </div>
        <div class="advertisment d-lg-block d-none " style="display:none !important;">
            <div class="google-add600hight  mb-5">

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
                        <?php
                        $sort_option = [1 => 'Rating High', 2 => 'Rating Low', 3 => 'Name A-Z', 4 => 'Name Z-A'];
                        ?>
                        <div class="form-group field-safarioperatorsearch-custom_sort_by">
                            <select id="safarioperatorsearch-custom_sort_by" class="form-select mb-2 custom_sort_by_input" name="SafariOperatorSearch[custom_sort_by]">
                                <option style="display:none;" selected value="">Sort by : <?= isset($sort_option[$operatorsearchModel->custom_sort_by]) ? $sort_option[$operatorsearchModel->custom_sort_by] : 'Rating High' ?></option>
                                <option value="1" class="<?= $operatorsearchModel->custom_sort_by == 1 ? 'selected' : '' ?>">Rating High</option>
                                <option value="2" class="<?= $operatorsearchModel->custom_sort_by == 2 ? 'selected' : '' ?>">Rating Low</option>
                                <option value="3" class="<?= $operatorsearchModel->custom_sort_by == 3 ? 'selected' : '' ?>">Name A-Z</option>
                                <option value="4" class="<?= $operatorsearchModel->custom_sort_by == 4 ? 'selected' : '' ?>">Name Z-A</option>
                            </select>
                        </div>
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
                ?>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xl-4 col-xxl-3 mb-3">
                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" data-pjax="0" class="oprators_boxes">
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
                                                    <p class="mb-0"><?= round($operator->google_rating, 1) ?> <?= GeneralModel::ratiing_views($operator->google_rating); ?></p>
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
                                                <p><?= $operator->parkcount ?></p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p><?= $operator->packagecount ?></p>
                                                <p>Packages</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p><?= $operator->sharedsafaricount ?></p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" class="get_quote_btn" data-pjax="0">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                        // Increment the counter after each operator
                    }
                } ?>

            </div>


        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>
<script>
    var mobileSearchDivOperator = document.getElementById('mobileSearchDiv');
    var targetDivOperator = document.getElementById('targetDiv');
    var formSelectOperator = document.querySelector('.form-select');

    if (mobileSearchDivOperator && targetDivOperator) {
        mobileSearchDivOperator.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the default behavior
            targetDivOperator.style.display = targetDivOperator.style.display === 'none' ? 'block' : 'block';
        });

        if (formSelectOperator) {
            formSelectOperator.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    }
</script>
<?php Pjax::end(); ?>


<?php
// $script = <<< JS
//     $('form').on('change', function(){
//         $("#safarioperatorsearch-custom_sort_by").attr("data-pjax", "true");    
//         $(this).closest('form').submit();
//     });
// JS;
// $this->registerJs($script);
?>