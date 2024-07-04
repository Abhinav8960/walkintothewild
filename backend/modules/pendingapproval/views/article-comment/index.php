<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;



$this->title = 'Article Comment';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Pending Approvals', 'url' => '/pendingapproval/article-comment/index'];
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
                    'comment',
                    'statusvalue:raw',
                    'created_at:dateTime:Created at',

                    [
                        'label' => 'View',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('View', ['view', 'id' => $model->article_id], ['class' => 'btn btn-danger']);
                        }
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>