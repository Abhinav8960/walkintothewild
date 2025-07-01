<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Operator Quote Report';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>


<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php echo $this->render('_card', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],

                    // [
                    //     'label' => 'User Name',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         if ($user = $model->user) {
                    //             return Html::a($user->name, ['/user/default/profile', 'user_id' => $user->id], ['style' => 'color:black !important;']);
                    //         }
                    //         return $model->full_name;
                    //     }
                    // ],
                    [
                        'label' => 'User Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($user = $model->user) {
                                $name = $user->name ?? '';
                                $imageUrl = $user->profile_display_image ?: $this->params['baseurl'] . '/img/dpmain.png';

                                return Html::a(
                                    Html::img($imageUrl, [
                                        'class' => "rounded profile-picture",
                                        'style' => "width:28px;"
                                    ]) . ' ' . Html::encode($name),
                                    ['/user/default/profile', 'user_id' => $user->id],
                                    ['style' => 'color:black !important;']
                                );
                            }


                            return '';
                        },
                    ],

                    [
                        'label' => 'User Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->email;
                        }
                    ],

                    [
                        'label' => 'Operator Business Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator) ? $model->operator->business_name : '';
                        }
                    ],

                    [
                        'label' => 'Park',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park) ? $model->park->title : '';
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
                        'label' => 'Start Date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->start_date;
                        }
                    ],

                    [
                        'label' => 'End Date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->end_date;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>