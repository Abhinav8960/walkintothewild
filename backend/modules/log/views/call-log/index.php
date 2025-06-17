<?php

use Google\Api\ResourceDescriptor\Style;
use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Call Log';
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
                        'label' => 'Caller 1 ',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str =  '<a class="bg-primary ml-1 m-3" href="/user/default/profile?user_id=' . $model->callerUser1->id . '">' . $model->callerUser1->name . '</a>';
                            $str .= "<br>";
                            return $str .= $model->request_caller_1_no;
                        }
                    ],
                    [
                        'label' => 'Caller 2',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "";
                            if(!empty($model->partner)){

                                $str =  '<a class="bg-info ml-1 m-3" href="/operator/safari-operator/view?id=' . $model->partner->id . '">' . $model->partner->business_name . '</a>';
                                $str .= "<br>";
                            }
                            return $str .= $model->request_caller_2_no;                       
                        }
                    ],
                    [
                        'label' => 'Recording',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->recording_url)) {
                                $url = $model->recording_url;
                                return '<audio controls>
                                <source src="'.$url.'" type="audio/ogg" style="width:20px">
                                <source src="'.$url.'" type="audio/mpeg" style="width:20px">
                                audio not supported.
                              </audio>';                             
                            } else {
                                if ($model->file_path) {
                                    return $model->file_path;
                                }
                            }
                            return 'No Recording Available';
                        }
                    ],
                    [
                        'label' => 'Dial Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->dial_status) ? $model->dial_status : '';
                        }
                    ],
                    [
                        'label' => 'Recording Duration',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->rec_duration) ? $model->rec_duration : '';
                        }
                    ],
                    [
                        'label' => 'Call Type',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_type) ? $model->call_type : '';
                        }
                    ],
                    [
                        'label' => 'Call Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_status) ? $model->call_status : '';
                        }
                    ],
                    [
                        'label' => 'DateTime',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->datetime) ? Yii::$app->formatter->asDatetime($model->datetime, 'php:d-m-Y H:i:s') : '';
                        }
                    ],
                    [
                        'label' => 'Duration',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->duration) ? $model->duration : '';
                        }
                    ],
                    [
                        'label' => 'Call Request Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_request_status) ? $model->call_request_status : '';
                        }
                    ],
                    [
                        'label' => 'Call Request Message',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_request_message) ? $model->call_request_message : '';
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>