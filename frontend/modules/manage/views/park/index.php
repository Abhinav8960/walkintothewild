<?php

use yii\helpers\Url;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'park']); ?>
        </div>
        <div class="col-md-10">
            <div class="card account-settingside">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">#</th>
                                            <th>Park Name</th>
                                            <th>Loaction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $srn = 1;
                                        foreach ($operator_parks as $operator_park) {
                                            $park_detail = $operator_park->park;
                                        ?>
                                            <tr>
                                                <td><?= $srn ?></td>
                                                <td><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $park_detail->slug]) ?>"> <img src="<?= isset($park_detail->logo) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" style="height:30px;"> <?= $park_detail->title ?></a></td>
                                                <td><?= isset($park_detail->state) ? $park_detail->state->state_name . ', ' : '' ?> <?= isset($park_detail->location) ? $park_detail->location->title : '' ?></td>
                                            </tr>
                                        <?php $srn++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>