<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;



$this->title = 'Article Comment';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Article', 'url' => '/cms/article'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>


<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'comment',

                    'statusvalue:raw',
                    'created_at:dateTime:Created at',
                    [
                        'label' => 'Approved Action',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('Approved', ['approved', 'id' => $model->id], ['class' => 'btn btn-success']);
                        }
                    ],
                    [
                        'label' => 'Reject Action',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('Reject', ['disapproved', 'id' => $model->id], ['class' => 'btn btn-danger']);
                        }
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>