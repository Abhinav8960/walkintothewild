<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Leads';
// $this->params['title'] = $this->title;
?>



<?php echo $this->render('_search', ['model' => $searchModel, 'safari_operator' => $safari_operator]); ?>
<div class="table-wrapper">
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}\n{summary}",
            'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style' => 'width: 5%;'],
                ],
                [
                    'label' => 'Source',
                    'headerOptions' => ['style' => 'width: 15%;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->sourceLabel;
                    }
                ],

                [
                    'label' => 'Safaris',
                    'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return !empty($model->safaris) ? $model->safaris : '';
                    }
                ],
                [
                    'label' => 'Travelers',
                    'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return !empty($model->travelers) ? $model->travelers : '';
                    }
                ],

                [
                    'label' => 'Accomodation',
                    'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return !empty($model->staycatgory) ? $model->staycatgory->title : '';
                    }
                ],
                [
                    'label' => 'Travel Date looking For',
                    'headerOptions' => ['style' => 'width: 15%;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $str =  date('d M, Y', strtotime($model->from_date));
                        if (!empty($model->to_date)) {
                            $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                        }
                        return $str;
                    }
                ],

                [
                    'label' => 'Lead Received Date',
                    'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return date('d M, Y h:i A', $model->created_at);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => "Actions",
                    'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    'template' => '{view}',
                    'buttons' => [

                        'view' => function ($url, $model) {
                            return  Html::a('<i class="mdi mdi-eye"></i>', ['/leads/default/view', 'id' => $model->id], [
                                'class' => 'action-icon',
                                'title' => 'View',
                            ]);
                        },


                    ]
                ],
            ],
        ]); ?>
    </div>
</div>