<?php


use common\models\GeneralModel;
use common\models\package\PackageQuote;

$query = PackageQuote::find()
    ->select('count(package_quote.id) as total, count(distinct(package_quote.created_by)) as total_distinct')
    ->where(['package_quote.status' => [PackageQuote::STATUS_ACTIVE, PackageQuote::STATUS_SUSPEND]])
    ->joinWith('package');
$query->andFilterWhere([
    'package_quote.start_date' => $model->start_date,
]);
$query->andFilterWhere(['like', 'package.package_name', $model->name]);
   

$total_quotes = $query->asArray()->one();

?>

<div class="row ">
    <div class="col-md-12 d-flex">
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Quotes</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_quotes['total']) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total distinct User for Quotes</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_quotes['total_distinct']) ?></div>
                </div>
            </div>
        </div>

    </div>

</div>