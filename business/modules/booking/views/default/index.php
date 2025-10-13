<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Bookings';
$this->params['title'] = $this->title;
?>

<div class="row mb-2">

</div>
<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Source',
                        'contentOptions' => ['style' => 'width: 1%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->sourceLabelWithBadge;
                        }
                    ],
                    [
                        'label' => 'Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'label' => 'Email',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->email;
                        }
                    ],
                    [
                        'label' => 'Phone',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone;
                        }
                    ],

                    [
                        'label' => 'Quotation',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "Park: " . ($model->park->title ?? '');
                            $str .= "<br>";
                            $str .= "Safaris: " . $model->safaris;
                            $str .= "<br>";
                            $str .= "Travelers: " . $model->travelers;
                            $str .= "<br>";
                            $str .= "Start date: " . date('Y-m-d', strtotime($model->start_date));
                            $str .= "<br>";
                            $str .= "End date: " . date('Y-m-d', strtotime($model->end_date));
                            return $str;
                        }
                    ],
                    [
                        'label' => 'Transaction Date',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i A', strtotime($model->transaction_datetime));
                        }
                    ],
                    [
                        'label' => 'Amount',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>'
                                . GeneralModel::number_format_indian($model->received_amount);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>