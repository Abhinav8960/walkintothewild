<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;

?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<div class="card">
    <div class="card-body">
        <?php echo $this->render('_comment_search', ['model' => $searchModel]); ?>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'comment',
                    'statusvalue:raw',
                    'created_at:dateTime:Created at',
                    [
                        'label' => 'Action',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status == 2) {
                                return Html::a('Approve', ['approved', 'id' => $model->id], ['class' => 'btn btn-success']);
                            } else {
                                return Html::a('Reject', ['disapproved', 'id' => $model->id], ['class' => 'btn btn-danger']);
                            }
                        }
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>