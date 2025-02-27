<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package Quote Report';
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
                        'label' => 'User Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->email : '';
                        }
                    ],

                    [
                        'label' => 'Operator Business Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->package, $model->package->safarioperator)
                                ? $model->package->safarioperator->business_name
                                : '';
                        }
                    ],

                    [
                        'label' => 'Package',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->package) ? $model->package->packagename : '';
                        }
                    ],

                    [
                        'label' => 'Travellers',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->travelers;
                        }
                    ],

                    [
                        'label' => 'Date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->start_date;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>