<?php


use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\trierror\ApiRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'API Request';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'API Request Log', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<style>
    .table a {
        color: #0000EE !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive"><?php /*
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p> */ ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    [
                        'label' => 'User',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $user_row = '-';
                            if (!empty($model->user_id)) {
                                $user_mob = '';
                                if (!empty($model->user->mobile_no)) {
                                    $user_mob = " (" . $model->user->mobile_no . ")";
                                }
                                $user_row = $model->user->name . $user_mob;
                            }
                            return $user_row;
                        }
                    ],
                    // [
                    //     'label' => 'Module',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return ucwords($model->request_group);
                    //     }
                    // ],
                    'user_ip',
                    'slug',
                    'route',
                    [
                        'label' => 'Full URL',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            $temp = "<a target='_blank' href='" . $model->request_full_url . "'>" . mb_strimwidth($model->request_full_url, 0, 100, ' ...') . "</a>";
                            return $temp;
                        }
                    ],
                    'request_type',
                    'request_parameter',
                    'request_data',
                    'request_code',
                    // [
                    //     'label' => 'Refer URL',
                    //     'format' => 'raw',
                    //     'contentOptions' => ['style' => 'color:#000;'],
                    //     'value' => function ($model) {

                    //         $temp = "<a target='_blank' href='" . $model->refer_url . "'>" . mb_strimwidth($model->refer_url, 0, 100, ' ...') . "</a>";
                    //         return $temp;
                    //     }
                    // ],
                    [
                        'label' => 'Refer History',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            return \common\models\GeneralModel::getreferhistory($model->route);;
                        }
                    ],
                    'response_error',
                    'is_server_error',
                    'is_client_error',
                    'isAjax',
                    'device',
                    'system',
                    'platform',
                    'browser',
                    'browser_version',
                    // 'is_count',
                    [
                        'label' => 'created_at',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d/m/Y H:i', strtotime($model->created_at));
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>