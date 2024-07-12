<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Users';
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
        <div class="mb-3">
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']) ?>
        </div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'mobile_no',

                    [
                        'label' => 'Profile Image',
                        'contentOptions' => ['style' => 'width: 50%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->profile_image) {
                                $imageUrl = Yii::$app->request->baseUrl . '/web/' . $model->profile_image;
                                return Html::img($imageUrl, ['style' => 'max-width: 200px;']);
                            } else {
                                return 'No image available';
                            }
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<img src="/img/view.png" alt="View" width="25" height="25">', ['view', 'id' => $model->id], ['class' => 'btn p-0 change-menuicon', 'title' => 'View']);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<img src="/img/update.png" alt="Update" width="25" height="25">', ['update', 'id' => $model->id], ['class' => 'btn p-0 change-menuicon', 'title' => 'Update']);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<img src="/img/delete.png" alt="Delete" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete ' . $model->name . '?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>