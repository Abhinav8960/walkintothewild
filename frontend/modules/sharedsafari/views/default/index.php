<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\interfaces\StatusInterface;
use common\models\park\SafariPark;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Shared Safari';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
// $recentposts = BlogSearch::recentpost();


?>

<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Join or Organize a Shared Safari </h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => FALSE,
]);
?>
<section class="articals_wrapper py-3  margin_bottomfooter  paddiinTop_add">
    <div class="container-fluid">
        <!-- <div class="advertisment pt-md-2 pt-5" style ="display: none" >
            <div class="google-ad-box  mb-5" style="border:none">
                
            </div>
        </div> -->
    </div>
    <div class="row my-4 justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <!-- <div class="row">
                <div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 ">
                    <div class="right_button ">
                        <?php if (Yii::$app->user->identity) { ?>
                            <?php
                            if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one()) {
                                if (Yii::$app->user->identity->is_safari_operator == 1 && $operator) {
                                    if ($operator->category_id == 1) {  ?>

                                        <button class="btn_newsafari  departureBtn newbg mt-2 " value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/create-fixed-departure']) ?>">+ Create Fixed Departure</button>
                                    <?php } else { ?>
                                        <button class="btn_newsafari ChoiceOrganizeSafariBtn newbg mt-3" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                                        <button style="display:none;" class="btn_newsafari organizeBtn newbg" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                                        <button style="display:none;" class="btn_newsafari  departureBtn newbg mt-2 " value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/create-fixed-departure']) ?>">+ Create Fixed Departure</button>
                                <?php }
                                }
                            } else { ?>
                                <button class="btn_newsafari organizeBtn newbg" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                            <?php } ?>
                        <?php } else {  ?>
                            <a class="btn_newsafari organizeBtn newbg d-block text-center" href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/sharedsafari/default/index']) ?>" data-pjax="0">+ Organize a Shared Safari</a>
                        <?php } ?>

                    </div>
                </div>
            </div> -->
            <?php $form = ActiveForm::begin([
                'options' => [
                    'data-pjax' => true,
                    'id' => 'side-search-form'
                ],
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="row">
                <div class="col-lg-3 col-xl-3 col-xxl-2  ps-lg-0 mb-4 pt-3">
                    <div class="right_button mb-4">
                        <?php if (Yii::$app->user->identity) { ?>
                            <?php
                            $operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->limit(1)->one();
                            if ($operator) {
                                if (Yii::$app->user->identity->is_safari_operator == 1 && $operator && $operator->status == SafariOperator::STATUS_ACTIVE) {
                                    if ($operator->category_id == 1) {  ?>

                                        <button data-pjax="0" class="btn_newsafari  departureBtn newbg mt-2 " value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/create-fixed-departure']) ?>">+ Create Fixed Departure</button>
                                    <?php } else { ?>
                                        <button data-pjax="0" class="btn_newsafari ChoiceOrganizeSafariBtn newbg mt-3" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                                        <button data-pjax="0" style="display:none;" class="btn_newsafari organizeBtn newbg" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                                        <button data-pjax="0" style="display:none;" class="btn_newsafari  departureBtn newbg mt-2 " value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/create-fixed-departure']) ?>">+ Create Fixed Departure</button>
                                <?php }
                                }
                            } else { ?>
                                <button data-pjax="0" class="btn_newsafari organizeBtn newbg" value="<?= \yii\helpers\Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a Shared Safari</button>
                            <?php } ?>
                        <?php } else {  ?>
                            <a class="btn_newsafari organizeBtn newbg d-block text-center" href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/sharedsafari/default/index']) ?>" data-pjax="0">+ Organize a Shared Safari</a>
                        <?php } ?>

                    </div>
                    <div id="targetDiv">
                        <?= $this->render('filter_search', [
                            'form' => $form,
                            'searchModel' => $searchModel,
                            'device' => $device,

                        ]) ?>
                    </div>
                    <!-- <div class="advertisment pt-md-2 pt-5" style="display: none !important" >
                            <div class="google-ad-box  mb-5" style="border:none">
                                
                            </div>
                        </div> -->

                </div>
                <div class="col-lg-9 col-xl-9 col-xxl-10 pe-lg-0 pt-3">
                    <div class="row ">
                        <div class="col-12">
                            <div class="topfilter d-lg-flex d-none justify-content-between align-items-center flex-wrap w-100 mb-2">
                                <div class="left_text">
                                    <p class="mb-0">There are currently <strong><?= count($models) ?> </strong> active shared safaris</p>
                                </div>
                                <?= $this->render('sort_by_month', ['form' => $form, 'searchModel' => $searchModel]) ?>
                            </div>
                            <div class="top_mobilefilter mb-3 d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
                                <div class="left_text">
                                    <p class="mb-0">There are currently <strong><?= $dataProvider->totalcount ?></strong> active shared safaris</p>
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
                        <div class="col-12 ">
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

                                <?php if ($searchModel->type) {
                                    foreach ($searchModel->type as  $type) {
                                        $selected_type = GeneralModel::sharedsafaritype()[$type];
                                        if ($selected_type) {
                                ?>
                                            <div class="tag"><?= $selected_type ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $type ?>" data-attribute="type">×</span></div>

                                <?php }
                                    }
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

                                <?php if ($searchModel->estimated_price_filter) {
                                    foreach ($searchModel->estimated_price_filter as  $estimated_price_filter) {
                                        $selected_price = GeneralModel::estimatedpriceoption()[$estimated_price_filter];
                                        if ($selected_price) {
                                ?>
                                            <div class="tag">Rs. <?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $estimated_price_filter ?>" data-attribute="estimated_price_filter">×</span></div>

                                <?php }
                                    }
                                } ?>

                                <?php if ($searchModel->host_type) {
                                    foreach ($searchModel->host_type as  $host_type) {
                                        $selected_price = GeneralModel::hostoption()[$host_type];
                                        if ($selected_price) {
                                ?>
                                            <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $host_type ?>" data-attribute="host_type">×</span></div>

                                <?php }
                                    }
                                } ?>


                                <?php if ($searchModel->share_safari_agenda_id) {
                                    foreach ($searchModel->share_safari_agenda_id as  $share_safari_agenda_id) {
                                        $selected_price = GeneralModel::agendaoption()[$share_safari_agenda_id];
                                        if ($selected_price) {
                                ?>
                                            <div class="tag"><?= $selected_price ?> <span class="close-btn remove_checkbox_filter" data-id="<?= $share_safari_agenda_id ?>" data-attribute="share_safari_agenda_id">×</span></div>

                                <?php }
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-4 pt-1">

                        <?php if ($models = $dataProvider->models) {
                            $count = 0;
                            $r = -1;
                            foreach ($models as $share_safari) {
                                $count++;
                        ?>
                                <div class="col mb-xl-2 mb-md-3 mb-4">
                                    <?= $this->render('_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                </div>
                                <?php if ($count == 5 or ($count > 5 && $count % 4 == 0)) $r = rand(0, 3);
                                if ($count % 4 == $r) {  //echo $count; 
                                ?>
                                    <!-- <ins class="adsbygoogle"
                                                style="display:block"
                                                data-ad-format="fluid"
                                                data-ad-layout-key="-6d+ep+q-5u+9i"
                                                data-ad-client="ca-pub-6116324330184807"
                                                data-ad-slot="1569517052"></ins>
                                    </div>
                                    <div class="col mb-xl-2 mb-md-3 mb-4">
                                        <script>
                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                        </script> -->
                                <?php  } ?>
                                <?php // $this->render('_shared_safari_card', ['share_safari' => $share_safari]) 
                                ?>
                                <!-- </div> -->
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <script>
                var mobileSearchDivShared = document.getElementById('mobileSearchDiv');
                var targetDivShared = document.getElementById('targetDiv');
                var formSelectShared = document.querySelector('.form-select');

                if (mobileSearchDivShared && targetDivShared) {
                    mobileSearchDivShared.addEventListener('click', function(event) {
                        event.stopPropagation(); // Prevent the default behavior
                        targetDivShared.style.display = targetDivShared.style.display === 'none' ? 'block' : 'block';
                    });

                    if (formSelectShared) {
                        formSelectShared.addEventListener('click', function(event) {
                            event.stopPropagation();
                        });
                    }
                }
            </script>

            <div class="modal fade _standard-text" id="update-organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h2 class="modal-title fs-5" id="exampleModalLabel">Update Safari</h2>
                            <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
                        </div>
                        <div class="modal-body pt-0">
                            <div id='updatesafarimodalContent'></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $script = <<< JS
        function updateorganizefunction() {
            $('.updateSafariBtn').on('click', function () {
                $('#update-organize-modal').modal('show')
                .find('#updatesafarimodalContent')
                .load($(this).attr('value'));
            });
        }
        updateorganizefunction();
             
    JS;
            $this->registerJs($script);
            ?>


        </div>

    </div>

    </div>

</section>


<?php
$script = <<< JS

    function departurefunction() {
        $('.departureBtn').on('click', function () {
            $('#departure-modal').modal('show')
            .find('#departuremodalContent')
            .load($(this).attr('value'));
        });
    }
    departurefunction();
             
JS;
$this->registerJs($script);
?>




<?php
$script = <<< JS
function organizefunction() {
	$('.organizeBtn').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#sharedsafarimodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();

JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS
function choiceorganizefunction() {
	$('.ChoiceOrganizeSafariBtn').on('click', function () {
        $('#choice-organize-modal').modal('show');
	});
}
choiceorganizefunction();

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
<?php Pjax::end(); ?>




<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Organize a Shared Safari</h2>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='sharedsafarimodalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="departure-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Organize a Fixed Departure</h2>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body ">
                <div id='departuremodalContent'></div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade _standard-text" id="choice-organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h2 class="modal-title" style="font-size:15px;" id="exampleModalLabel">Is it a shared safari or a fixed departure</h2>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body p-3">
                <div id='choicemodalContent'>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="Modal_label pb-2">Select a Shared Safari Type <span class="necessary">*</span></label>
                            <div class="mb-3 field-shared_safari_choice">
                                <select id="shared_safari_choice" class="form-select form-select-lg mb-3"
                                    name="shared_safari_choice"
                                    onchange="
                                        $('#choice-organize-modal').modal('hide');
                                        $('#departure-modal').modal('hide');
                                        $('#organize-modal').modal('hide');
                                        $('.'+$(this).val()).trigger('click');
                                        $('#shared_safari_choice').prop('selectedIndex', 0);
                                    "
                                    aria-required="true" aria-invalid="true">
                                    <option style="display:none;" value="">Select Safari Type</option>
                                    <option value="organizeBtn">Organize a Shared Safari </option>
                                    <option value="departureBtn">Organize a Fixed Departure</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>