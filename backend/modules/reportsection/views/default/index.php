<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Report Section';
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
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],

                    [
                        'label' => 'User Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->name : '';
                        }
                    ],

                    [
                        'label' => 'User Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->email : '';
                        }
                    ],

                    [
                        'label' => 'Share Safari Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->sharesafari) ? $model->sharesafari->share_safari_title : '';
                        }
                    ],

                    [
                        'label' => 'Park Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->sharesafari->park) ? $model->sharesafari->park->title : '';
                        }
                    ],

                    [
                        'label' => 'Joined At',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', $model->intrested_at);
                        }
                    ],


                ],
            ]); ?>
        </div>
    </div>
</div>