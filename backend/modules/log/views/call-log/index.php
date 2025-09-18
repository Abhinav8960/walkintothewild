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
        <?php echo $this->render('_card', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Call Initiater',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "";
                            if (!empty($model->chatSource)) {
                                $str .= $model->chatSource;
                                $str .= "<br>";
                            }

                            if ($model->c_type == 'IBD') {
                                if ($model->first_attended == 'customer') {
                                return $str .= $model->request_caller_2_no;

                                }else{
                                    $str .= '<a href="/operator/safari-operator/view?id=' . $model->partner->id . '" class="text-primary" style="color: green !important;">' . $model->partner->business_name . ' (partner)</a>';
                                    $str .= "<br>";
                                    return $str .= $model->request_caller_1_no;
                                }

                            }elseif (!empty($model->partner)) {

                                $str .= '<a href="/operator/safari-operator/view?id=' . $model->partner->id . '" class="text-primary" style="color: green !important;">' . $model->partner->business_name . ' (partner)</a>';
                                $str .= "<br>";
                            } elseif(isset($model->callerUser2->id)) {
                                $str .= '<a href="/user/default/profile?user_id=' . $model->callerUser2->id . '" class="text-primary" style="color: green !important;">' . $model->callerUser2->name . '</a>';
                                $str .= "<br>";
                            }

                            return $str .= $model->request_caller_2_no;
                        }
                    ],
                    [
                        'label' => 'Call Receiver',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = '';
                            if ($model->c_type == 'IBD') {
                                if ($model->first_attended == 'customer') {
                                    if(isset($model->partner->id)){

                                        $str .= '<a href="/operator/safari-operator/view?id=' . $model->partner->id . '" class="text-primary" style="color: green !important;">' . $model->partner->business_name . ' (partner)</a>';
                                        $str .= "<br>";
                                    }
                                    return $str .= $model->request_caller_1_no;
                                    
                                }else{
                                    return $str .= $model->request_caller_2_no;
                                }

                            }elseif(isset($model->callerUser1->id)){

                                $str = '<a href="/user/default/profile?user_id=' . $model->callerUser1->id . '" class="text-primary" style="color: green !important;">' . $model->callerUser1->name . '</a>';
                                $str .= "<br>";
                            }
                            return $str .= $model->request_caller_1_no;
                        }
                    ],

                    [
                        'label' => 'Recording',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {


                            $url = !empty($model->file_path) ? Yii::$app->params['s3_endpoint'] . '/' . $model->file_path : $model->recording_url;
                            if ($url != '' || $url != NULL) {
                                return '<audio controls>
                                <source src="' . $url . '" type="audio/ogg" style="width:20px">
                                <source src="' . $url . '" type="audio/mpeg" style="width:20px">
                                audio not supported.
                              </audio>';
                            } elseif ($model->service == \common\models\CallLog::SERVICE_AIR_PHONE && ($model->call_status == 'caller_no_answer' || $model->call_status == 'agent_no_answer')) {
                                return '<p class="text-warning" style="color: red !important;">Call Not Received</p>';
                            } elseif ($model->service == \common\models\CallLog::SERVICE_DEEP_CALL) {
                                return \common\models\CallLog::callStatusList()[$model->call_status] ?? '';
                            }
                            return '';
                        }
                    ],
                    // [
                    //     'label' => 'Dial Status',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->dial_status) ? $model->dial_status : '';
                    //     }
                    // ],


                    // [
                    //     'label' => 'Recording Duration',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->rec_duration) ? $model->rec_duration : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Call Type',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->call_type) ? $model->call_type : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Call Status',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->call_status) ? $model->call_status : '';
                    //     }
                    // ],
                    [
                        'label' => 'DateTime',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($model->service == \common\models\CallLog::SERVICE_DEEP_CALL) {
                                return isset($model->ivr_s_time) ? $model->ivr_s_time : '';
                            }
                            return isset($model->datetime) ? date('Y-m-d h:i A', strtotime($model->datetime)) : '';
                        }
                    ],
                    [
                        'label' => 'Duration',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->service == \common\models\CallLog::SERVICE_DEEP_CALL) {
                                return isset($model->talk_duration) ? $model->talk_duration . ' Seconds' : '';
                            }
                            return isset($model->duration) ? $model->duration : '';
                        }
                    ],
                    [
                        'label' => 'Call Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($model->service == \common\models\CallLog::SERVICE_DEEP_CALL) {
                                return \common\models\CallLog::callStatusList()[$model->call_status] ?? '';
                            }
                            return isset($model->call_status) ? ucwords(str_replace('_', ' ', $model->call_status))  : '';
                        }
                    ],
                    [
                        'label' => 'Is Dedicated',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            return $model->is_dedicated == 1 ? 'Dedicated No' : 'Non Dedicated No';
                        }
                    ],
                    // [
                    //     'label' => 'Call Request Status',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->call_request_status) ? $model->call_request_status : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Call Request Message',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->call_request_message) ? $model->call_request_message : '';
                    //     }
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>