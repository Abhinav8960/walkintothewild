<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;

$query = Package::find()
    ->select("count(package.id) as total_data")
    ->where(['!=', 'package.status', Package::STATUS_DELETE])
    ->joinWith('safarioperator')
    ->andWhere(['safari_operator.status' => 1])
    ->andFilterWhere(['package.status' => $model->status])
    ->andFilterWhere(['like', 'package.package_name', $model->package_name]);
if (!empty($model->package_start_date) && !empty($model->package_end_date)) {
    $query->andFilterWhere(['between', 'package.created_at', $model->package_start_date, $model->package_end_date]);
}
$total_package = $query->asArray()->one();


$query1 = Package::find()
    ->select("COUNT(DISTINCT owned_by_id) as total_data")
    ->where(['!=', 'package.status', Package::STATUS_DELETE])
    ->joinWith('safarioperator')
    ->andWhere(['safari_operator.status' => 1])
    ->andFilterWhere(['package.status' => $model->status])
    ->andFilterWhere(['like', 'package.package_name', $model->package_name]);
if (!empty($model->package_start_date) && !empty($model->package_end_date)) {
    $query1->andFilterWhere(['between', 'package.created_at', $model->package_start_date, $model->package_end_date]);
}
$total_unique_host = $query1->asArray()->one();


?>

<div class="row ">
    <div class="col-md-12 d-flex">
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Package</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_package['total_data']) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px; border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Package Unique Host</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_unique_host['total_data']) ?></div>
                </div>
            </div>
        </div>

    </div>

</div>