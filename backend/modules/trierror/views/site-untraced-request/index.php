<?php

use common\models\trierror\FrontendRequestLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\trierror\FrontendRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Untraced URL';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
//$this->params['buttons'][] = Html::a('+ Add New URL', ['create'], ['class' => 'btn btn-orange', 'title' => 'Add New URL', 'style' => 'margin-right: 2px;']);
?>
<style>
    .table a {
        color: #0000EE !important;
    }
</style>

<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]);
        ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'URL',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            $temp = "<a target='_blank' href='" . $model->url . "'>" . mb_strimwidth($model->url, 0, 100, ' ...') . "</a>";
                            return $temp;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "",
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="/img/red_delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this record ?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>