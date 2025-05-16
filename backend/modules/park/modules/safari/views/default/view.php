<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Safari Park';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/park/safari/default/index'];
$this->params['breadcrumbs'][] = "Safari Park View";
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Edit Profile', ['/park/safari/profile', 'safari_park_id' => $model->id], ['class' => 'btn btn-orange me-2', 'title' => 'Create']);
$this->params['buttons'][] = Html::button('Operator List', ['value' => Url::toRoute(['operator-list', 'safari_park_id' => $model->id]), 'class' => 'btn btn-orange operator-popup', 'title' => 'Create']);

?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-2">
                <img src="<?= $model->featureimagepath ?>">
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Park Name:</span><?= $model->title ?>
                    </p>
                    <p>
                        <span>Address: </span><?= isset($model->state) ? $model->state->state_name : '' ?>, <?= isset($model->location) ? $model->location->title : '' ?>
                    </p>
                    <p>
                        <span>Vehicle: </span> <?php if ($model->vehicles) {

                                                    foreach ($model->vehicles as $vehicle) {
                                                        echo isset($vehicle->mastervehicle) ? $vehicle->mastervehicle->vehicle_name . ' ,' : '' ?>
                        <?php }
                                                } ?>
                    </p>
                    <p>
                        <span>Railway Station: </span><?= isset($model->railwaystation) ? $model->railwaystation->title . ' , ' : '' ?><?= isset($model->railwaystationtwo) ? $model->railwaystationtwo->title : '' ?>
                    </p>

                    <p>
                        <span>Airport: </span><?= isset($model->airport) ? $model->airport->name : '' ?>
                    </p>


                </div>
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Website Url: </span><a href="<?= $model->official_website ?>"><?= $model->official_website ?></a>
                    </p>
                    <p>
                        <span>Animals: </span> <?php if ($model->animals) {
                                                    $temp = [];
                                                    foreach ($model->animals as $animal) {
                                                        if (!empty($animal->safariparkanimalinfo->name)) {
                                                            $temp[] = $animal->safariparkanimalinfo->name;
                                                        }
                                                    }
                                                    echo implode(", ", $temp);
                                                } ?>
                    </p>
                    <p>
                        <span>Average Safari Price: </span><?= isset($model->avg_safari_price_min) ? GeneralModel::numberformat($model->avg_safari_price_min) . ' - ' : '' ?><?= GeneralModel::numberformat($model->avg_safari_price_max) ?>
                    </p>
                    <p>
                        <span>Safari Session: </span><?php if ($model->sessions) {

                                                            foreach ($model->sessions as $session) {
                                                                echo isset($session->metasession) ? $session->metasession->title . ',' : '' ?>
                        <?php }
                                                        } ?>
                    </p>
                    <p>
                        <span>Month: </span><?= isset($first_month) ? $first_month->mastermonth->month_name . ' - ' : '' ?><?= isset($last_month) ? $last_month->mastermonth->month_name : '' ?> <?= isset($model->month_note) ? '(' . $model->month_note . ')' : '' ?>

                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-box">
                <p>
                    <span>Short Description: </span><?= $model->short_description ?>
                </p>
                <p>
                    <span>Long Description: </span><?= $model->long_description ?>
                </p>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="operatorAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Operator List
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='operatorContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.operator-popup').on('click', function () {
        $('#operatorAction').modal('show')
		.find('#operatorContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>