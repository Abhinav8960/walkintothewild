<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Operator Approval';
$this->params['breadcrumbs'][] =  ['label' => 'Operator Approval', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;


?>
<div class="card">

    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
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
                            return $model->phone_no;
                        }
                    ],
                    [
                        'label' => 'Business Registration Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->business_registration_name;
                        }
                    ],
                    [
                        'label' => 'Business Phone No',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->business_phone_no;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '&nbsp{update} &nbsp{suspend}',
                        'buttons' => [

                            // 'update' => function ($url, $model) {

                            //     return Html::a(
                            //         '<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">',
                            //         ['update', 'id' => $model->id],
                            //         [
                            //             'class' => 'btn p-0 change-menuicon',
                            //             'title' => 'Update',
                            //         ]
                            //     );
                            // },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>