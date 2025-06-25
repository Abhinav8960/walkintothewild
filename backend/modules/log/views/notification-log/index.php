<?php


use yii\grid\GridView;

$this->title = 'Notification Log';
$this->params['breadcrumbs_home_url'] = '/log/notification-log';
$this->params['breadcrumbs'][] =  ['label' => 'Notification Log', 'url' => '#'];
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
                        'label' => 'Title',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->title;
                        }
                    ],
                    [
                        'label' => 'Message',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->message;
                        }
                    ],
                    [
                        'label' => 'Data',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
<<<<<<< HEAD
                            return isset($model->sent_data) ? json_encode($model->sent_data) : '';
=======
                            return ($model->sent_data) ? json_encode($model->sent_data) : '';
>>>>>>> main
                        }
                    ],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (isset($model->reciever->name)) {
                                return '<a href="/user/default/profile?user_id=' . $model->user_id . '" class="text-primary" style="color: green !important;">' . $model->reciever->name . '</a>';
                            }
                            else{
                                return '';
                            }
                        }
                    ],
                    [
                        'label' => 'Is Send',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_send == 1 ? 'Yes' : 'No';
                        }
                    ],
                    [
                        'label' => 'Send Date Time',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->send_datetime;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>