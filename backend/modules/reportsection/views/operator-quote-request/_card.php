<?php


use common\models\GeneralModel;
use common\models\operator\OperatorQuote;

$query = OperatorQuote::find()
    ->select('count(id) as total, count(distinct(created_by)) as total_distinct')
    ->where(['operator_quote.status' => [OperatorQuote::STATUS_ACTIVE, OperatorQuote::STATUS_SUSPEND]])
    ->andFilterWhere([
        'operator_quote.safari_park_id' => $model->safari_park_id,
        'operator_quote.status' => $model->status,
    ]);
$query->andFilterWhere(['like', 'operator_quote.full_name', $model->full_name]);
if (!empty($model->start_date) && !empty($model->end_date)) {
    $query->andFilterWhere(['between', 'operator_quote.created_at', $model->start_date, $model->end_date]);
}

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