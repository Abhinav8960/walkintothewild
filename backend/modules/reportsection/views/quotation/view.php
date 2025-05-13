<?php

use common\models\GeneralModel;

$this->title = 'Quotation '. $model->user->name.', in Between ' . $model->from_date . ' and ' . $model->to_date;
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Operator Quote View";
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <div class="text-box">
                    <p>
                        <span>Park: </span><?= isset($model->safari_park_id) ? GeneralModel::safariparkoption()[$model->safari_park_id]  : '' ?>
                    </p>
                    <p>
                        <span>Full Name: </span><?= $model->full_name ?>
                    </p>
                    <p>
                        <span>Phone Number: </span><?= $model->phone_no ?>
                    </p>
                    <p>
                        <span>Email: </span><?= $model->email ?>
                    </p>
                    <p>
                        <span>Start Date: </span><?= $model->start_date ?>
                    </p>
                    <p>
                        <span>End Date: </span><?= $model->end_date ?>
                    </p>



                </div>
            </div>
            <div class="col-md-6">
                <div class="text-box">
                    <p>
                        <span>Stay Category: </span><?= isset($model->stay_category_id) ? GeneralModel::staycategoryoption()[$model->stay_category_id]  : '' ?>
                    </p>
                    <p>
                        <span>Safaris: </span><?= $model->safaris ?>
                    </p>
                    <p>
                        <span>Travelers: </span><?= $model->travelers ?>
                    </p>
                    <p>
                        <span>IP Address: </span><?= $model->ip_address ?>
                    </p>
                    <p>
                        <span>Operating System: </span><?= $model->os ?>
                    </p>
                    <p>
                        <span>Browser: </span><?= $model->browser ?>
                    </p>
                    <p>
                        <span>Device Type: </span><?= $model->device_type ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>