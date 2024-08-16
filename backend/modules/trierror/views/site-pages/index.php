<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\trierror\FrontendRequestLog;
use common\models\trierror\SitePages;
use common\models\trierror\SearchSitePages;


/** @var yii\web\View $this */
/** @var common\models\trierror\FrontendRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Site Pages';
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
        <?php echo $this->render('_search', ['model' => $searchModel, 'content_type' => $content_type]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Category',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->category;
                        }
                    ],
                    [
                        'label' => 'Sub-Category',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return ucwords($model->sub_category);
                        }
                    ],
                    [
                        'label' => 'Type',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return ucwords($model->url_type);
                        }
                    ],
                    [
                        'label' => 'URL',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            $short_url = $model->url;
                            $temp = "<a target='_blank' href='" . Yii::$app->params['frontend_url'] . $model->url . "'>" . $short_url . "</a>";
                            return $temp;
                        }
                    ],
                    [
                        'label' => 'Last Updated',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime($model->last_update_at));
                        }
                    ],
                    [
                        'label' => 'Views',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->counter;
                        }
                    ],/*
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                if ($model->content_type == 'category') {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Delete',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this record ?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            },
                        ]
                    ],*/
                ],
            ]); ?>
        </div>
    </div>
</div>