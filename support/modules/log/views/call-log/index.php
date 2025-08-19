<?php

use Google\Api\ResourceDescriptor\Style;
use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Call Log';
$this->params['breadcrumbs_home_url'] = '/log/call-log';
$this->params['breadcrumbs'][] =  ['label' => 'Call Log', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<?php echo $this->render('_card', ['model' => $searchModel]); ?>


<div class="table-wrapper mt-4">
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
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Operator',
                        // 'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "";
                            if (!empty($model->partner)) {

                                $str = '<a href="/operator/safari-operator/view?id=' . $model->partner->id . '" class="text-primary" style="color: #171725 !important; font-size: 13px; font-weight:500;">' . $model->partner->business_name . '</a>';
                                $str .= "<br>";
                            }
                            return $str .= $model->request_caller_2_no;
                        }
                    ],
                    [
                        'label' => 'User',
                        // 'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = '<a href="/user/default/profile?user_id=' . $model->callerUser1->id . '" class="text-primary" style="color: #171725 !important; font-size: 13px; font-weight:500;">' . $model->callerUser1->name . '</a>';
                            $str .= "<br>";
                            return $str .= $model->request_caller_1_no;
                        }
                    ],

                    [
                        'label' => 'Recording',
                        'contentOptions' => ['style' => 'width: 25%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            $url = !empty($model->file_path) ? Yii::$app->params['s3_endpoint'] . '/' . $model->file_path : $model->recording_url;
                            if ($url != '' || $url != NULL) {
                                return '<audio controls>
                                <source src="' . $url . '" type="audio/ogg" style="width:20px">
                                <source src="' . $url . '" type="audio/mpeg" style="width:20px">
                                audio not supported.
                              </audio>';
                            } elseif ($model->call_status == 'caller_no_answer' || $model->call_status == 'agent_no_answer') {
                                return '<p class="text-warning" style="color: red !important;">Call Not Received</p>';
                            }
                            return '';
                        }
                    ],

                    [
                        'label' => 'Call Status',
                        // 'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_status) ? ucwords(str_replace('_', ' ', $model->call_status))  : '';
                        }
                    ],
                    [
                        'label' => 'DateTime',
                        // 'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->datetime) ? date('Y-m-d h:i A', strtotime($model->datetime)) : '';
                        }
                    ],
                    [
                        'label' => 'Duration',
                        // 'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->duration) ? $model->duration : '';
                        }
                    ],
                    [
                        'label' => 'Call Request Status',
                        // 'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->call_request_status) ? $model->call_request_status : '';
                        }
                    ],
                    [
                        'label' => 'Call Request Message',
                        // 'contentOptions' => ['style' => 'width: 10%;'],
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