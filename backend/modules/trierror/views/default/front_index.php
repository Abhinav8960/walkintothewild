<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Frontend Error Log';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
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
                //'layout' => '{items}',
                'columns' => [

                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->created_at;
                        }
                    ],
                    [
                        'label' => 'Error Type',
                        'contentOptions' => ['style' => 'width: 15;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->error_type;
                        }
                    ],
                    [
                        'label' => 'Request Type',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->request_type;
                        }
                    ],
                    [
                        'label' => 'Request Url',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->request_url;
                        }
                    ],
                    [
                        'label' => 'Reference Url',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->reference_url;
                        }
                    ],
                    [
                        'label' => 'Ip Address',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ip_address;
                        }
                    ],
                    [
                        'label' => 'Message',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->error_msg;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>