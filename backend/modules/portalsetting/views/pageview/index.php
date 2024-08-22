<?php

use yii\grid\GridView;

$this->title = 'Page View';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Portal Setting', 'url' => '#'];
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
                    'user.name',
                    [
                        'label' => 'IP Address',
                        'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ip_address;
                        }
                    ],
                    [
                        'label' => 'Platform/OS',
                        'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_platform;
                        }
                    ],
                    [
                        'label' => 'Device',
                        'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_device;
                        }
                    ],
                    [
                        'label' => 'Browser',
                        'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_browser;
                        }
                    ],
                    'created_at:dateTime:View at',
                    [
                        'label' => 'Page Title',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->title;
                        }
                    ],
                    [
                        'label' => 'Action Url',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->action_url;
                        }
                    ],
                    [
                        'label' => 'Page Url',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->url;
                        }
                    ],

                    [
                        'label' => 'User Agent',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_agent;
                        }
                    ],
                    [
                        'label' => 'Query Params',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->query_params;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>