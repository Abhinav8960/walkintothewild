<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'SMS Log';
$this->params['breadcrumbs_home_url'] = '/log/sms-log';
$this->params['breadcrumbs'][] =  ['label' => 'SMS Log', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php echo $this->render('_card', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // [
                    //     'label' => 'Message Id',
                    //     'contentOptions' => ['style' => 'width: 20%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->message_id;
                    //     }
                    // ],
                    [
                        'label' => 'Template',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->template_id) ? $model->template->name : '';                        }
                    ],
                    [
                        'label' => 'Data',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->params;
                        }
                    ],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $name = isset($model->user->name) ? $model->user->name : '';
                            return Html::a($name, ['/user/default/profile', 'user_id' => $model->user_id], ['style' => 'color:black !important;']);
                        },
                    ],
                    
                    [
                        'label' => 'Send Date Time',
                        'contentOptions' => ['style' => 'width: 20%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 20%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date("F j, Y, g:i a", $model->sms_send_time);
                            // return Yii::$app->formatter->asDatetime($model->sms_send_time, 'php:d-m-Y H:i:s');
                        }
                    ],
                    [
                        'label' => 'Report Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->report_status ?? '';
                        }
                    ],   
                    [
                        'label' => 'Is Deliver',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_deliver == 2 ? 'Yes' : 'No';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabels;
                        }
                    ],                    
                ],
            ]); ?>
        </div>
    </div>
</div>