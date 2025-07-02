<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Sightings';
$this->params['breadcrumbs'][] = $this->title;
// $this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('Create',  ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']);
?>

<div class="">
    <div class="container-fluid">
        <div class="row pb-4">
            <div class="col-12">
                <div class="row filter-areaParent w-100">
                    <div class="col-xxl-8 col-xl-9">
                    </div>
                    <!-- <div class="col-xxl-4 col-xl-3">
                        <div>
                            <a class="button-created new float-xl-end float-start" href="" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Create</a>
                        </div>

                    </div> -->
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($dataProvider->getModels() as $model) { ?>
                <div class="col-xxl-3 col-xl-3 col-lg-4 md-6 col-12 mb-3">
                    <div class="sightings-parent-card">
                        <div class="card p-2 border-0">
                            <a href="<?= Url::toRoute(['view', 'id' => 1]) ?>"> <img src="<?= $model->thumbnail ?>"
                                    class="card-img-top" alt=""></a>
                            <div class="card-body">
                                <p class="mb-0"><?= $model->description ?></p>
                                <div class="liksMain pt-2 d-flex align-items-center justify-content-between">
                                    <div class="likes d-flex align-items-center gap-1">
                                        <a href=""><img src="<?= $this->params['baseurl'] ?>/images/like.png" alt=""></a>
                                        <a href="">
                                            <p class="mb-0"><span><?= $model->like_count ?></span> Likes</p>
                                        </a>
                                    </div>
                                    <div class="likes d-flex align-items-center gap-1">
                                        <a href="">
                                            <p class="mb-0"><span><?= $model->comment_count ?></span> Comments</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>


<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
    <div class=" modal-content">
        <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
            <p class="" id="">Create Sighting</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-4 py-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form_boxes mb-3">
                        <div class="form-group mt-2">
                            <label for="fileField" class="attachment">
                                <div class="row btn-file">
                                    <div class="btn-file__preview"></div>
                                    <div class="btn-file__actions">
                                        <div
                                            class="btn-file__actions__item btn-file__actions__item__dub col-xs-12 text-center border">
                                            <div class="btn-file__actions__item--shadow">
                                                <i class="fa-solid fa-image"></i>
                                                <div class="visible-xs-block"></div>
                                                Video File
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 field-fileField">
                                    <div class="form-group">
                                        <input type="hidden"
                                            name="PackageVersionForm[package_image]" value=""><input type="file"
                                            id="fileField" class="form-control" name="PackageVersionForm[package_image]"
                                            value="package_image-1731832346.jpg">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form_boxes mb-3">
                        <label for="">Caption <span>*</span></label>
                        <div class="field-packageversionform-package_itinerary_overview">
                            <div class="form-group"><textarea id="packageversionform-package_itinerary_overview"
                                    class="form-control" placeholder="Enter"></textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12  mb-4">
                    <div class="form_boxes">
                        <label for="">Safari Park <span>*</span></label>
                        <div class="field-packageversionform-master_vehicle_id">
                            <div class=" form-group"><select class="form-select form-select-lg ">
                                    <option value="">Open this select menu</option>
                                    <option value="5" selected="">Gypsy / Jeep</option>
                                    <option value="6">Canter / Bus</option>
                                    <option value="7">Other (Elephant, Boat)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12  mb-4">
                        <div class="form_boxes">
                            <label for="">Select Animal <span>*</span></label>
                            <div class="field-packageversionform-master_vehicle_id">
                                <div class=" form-group"><select class="form-select form-select-lg ">
                                        <option value="">Open this select menu</option>
                                        <option value="5" selected="">Gypsy / Jeep</option>
                                        <option value="6">Canter / Bus</option>
                                        <option value="7">Other (Elephant, Boat)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <div class="form_boxes">
                                <label for="">Sighting Date<span>*</span></label>
                                <div class="field-packageversionform-max_booking_date">
                                    <div class="form-group">
                                        <input type="date" class="form-control" min="2025-06-30">
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <div class="d-flex align-items-center gap-4">
                                <div class="form_boxes">
                                    <label for="">Sighting Date</label>
                                </div>
                                <div class="d-flex flex-column gap-4">
                                    <div class="d-flex gap-3">
                                        <input class="form-check-input" type="radio" id="1">
                                        <label for="1">Morning</label>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <input class="form-check-input" type="radio" id="2">
                                        <label for="2">Evening</label>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <input class="form-check-input" type="radio" id="3">
                                        <label for="3">Night</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="modalCrateButton">
                                <button type="btn" class="w-100">Create</button>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div> -->



<!-- <script>
    document.addEventListener('click', function(e) {
        document.querySelectorAll('details').forEach(function(details) {
            if (details.hasAttribute('open') && !details.contains(e.target)) {
                details.removeAttribute('open');
            }
        });
    });
</script> -->