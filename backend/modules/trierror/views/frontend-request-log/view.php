<?php

use common\models\trierror\FrontendRequestLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\trierror\FrontendRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Frontend Request';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Frontend Request Log', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
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
                            if(!empty($model->user_id)){
                                $user_row = $model->user->name." (".$model->user->mobile_no.")";
                            }
                            return $user_row;
                        }
                    ],
                    'user_ip',
                    'slug',
                    'route',
                    'request_url',
                    'request_type',
                    'request_parameter',
                    'request_data',
                    'request_code',
                    'response_error',
                    'is_server_error',
                    'is_client_error',
                    'isAjax',
                    'device',
                    'system',
                    'platform',
                    'browser',
                    'browser_version',
                    'is_count',
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
