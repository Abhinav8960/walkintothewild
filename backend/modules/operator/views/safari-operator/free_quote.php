<?php

use common\models\GeneralModel;
use yii\grid\GridView;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;


?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'quote']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'User Name',
                                        // 'contentOptions' => ['style' => 'width: 20%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->full_name;
                                        }
                                    ],
                                    'park.title:raw:Park',
                                    'safaris',
                                    'travelers',
                                    'staycatgory.title:raw:Stay Category',
                                    // [
                                    //     'label' => 'Email',
                                    //     'contentOptions' => ['style' => 'width: 20%;'],
                                    //     'format' => 'raw',
                                    //     'value' => function ($model) {
                                    //         return $model->email;
                                    //     }
                                    // ],
                                    // [
                                    //     'label' => 'Phone Number',
                                    //     'contentOptions' => ['style' => 'width: 15%;'],
                                    //     'format' => 'raw',
                                    //     'value' => function ($model) {
                                    //         return $model->phone_no;
                                    //     }
                                    // ],

                                    [
                                        'label' => 'Start Date',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->start_date;
                                        }
                                    ],
                                    [
                                        'label' => 'End Date',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->end_date;
                                        }
                                    ],

                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>