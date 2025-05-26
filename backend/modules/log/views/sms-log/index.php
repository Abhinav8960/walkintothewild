<?php


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
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Message Id',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->message_id;
                        }
                    ],
                    [
                        'label' => 'Template',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->template != null){
                            return isset($model->template_id) ? $model->template->name : '';
                            }
                        }
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
                        'label' => 'User Id',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_id;
                        }
                    ],
                    [
                        'label' => 'Is Deliver',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_deliver == 1 ? 'Yes' : 'No';
                        }
                    ],
                    [
                        'label' => 'Send Date Time',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->sms_send_time;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],                    

                ],
            ]); ?>
        </div>
    </div>
</div>