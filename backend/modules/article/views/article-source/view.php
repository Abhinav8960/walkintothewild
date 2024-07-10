<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Article Source';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Article', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/article/article-source'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;
?>

<div class="test-view">

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>




    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Article Source',
                'contentOptions' => ['style' => 'width: 30%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->article_source;
                }
            ],

            [
                'label' => 'Publisher',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->publisher;
                }
            ],
            [
                'label' => 'Category',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->category_id) ? GeneralModel::categoryoption()[$model->category_id] : '';
                }
            ],

            [
                'label' => 'Frequency',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->frequency_id) ? GeneralModel::frequencyoption()[$model->frequency_id] : '';
                }
            ],

            [
                'label' => 'Link',
                'contentOptions' => ['style' => 'width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->web_link, $model->web_link, [
                        'target' => '_blank',
                        'style' => 'color: blue !important; display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;',
                    ]);
                }
            ],
            



            [
                'label' => 'Status',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return 'Active';
                    } elseif ($model->status == 2) {
                        return 'Suspended';
                    }
                    return '';
                }
            ],
        ],
    ]) ?>

</div>