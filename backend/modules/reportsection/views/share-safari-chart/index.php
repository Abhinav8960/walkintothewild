<?php

use common\models\sharesafari\ShareSafari;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

$this->title = 'Share Safari Report';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$columnchart = 'column-chart';


$data = ShareSafari::find()
    ->alias('s')
    ->select([
        'p.title AS park_title',
        'SUM(CASE WHEN s.status = ' . ShareSafari::STATUS_ACTIVE . ' THEN 1 ELSE 0 END) AS active_count',
        'SUM(CASE WHEN s.status = ' . ShareSafari::STATUS_FULL_SEAT . ' THEN 1 ELSE 0 END) AS full_seat_count'
    ])
    ->leftJoin('safari_park p', 's.park_id = p.id')
    ->groupBy('s.park_id')
    ->asArray()
    ->all();

$categories = ArrayHelper::getColumn($data, 'park_title');
$activeSafaris = ArrayHelper::getColumn($data, 'active_count');
$fullSeatSafaris = ArrayHelper::getColumn($data, 'full_seat_count');

$categoriesJson = Json::encode($categories);
$activeJson = Json::encode(array_map('intval', $activeSafaris));
$fullSeatJson = Json::encode(array_map('intval', $fullSeatSafaris));

?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-6">
                <h6>Share Safari</h6>
                <div id="<?= $columnchart ?>"></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(function(){
    Highcharts.chart('$columnchart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Share Safari'
        },
        xAxis: {
            categories: $categoriesJson
        },
        yAxis: {
            title: {
                text: 'No. of Safaris'
            },
            stackLabels: {
                enabled: true
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'top',
            layout: 'vertical'
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Active Safaris',
            data: $activeJson,
            stack: 'safari'
        }, {
            name: 'Full Seat Safaris',
            data: $fullSeatJson,
            stack: 'safari'
        }]
    });
});
JS;
$this->registerJs($script);
?>