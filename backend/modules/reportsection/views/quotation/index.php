<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Quotations';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;
// $this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);
?>


<div class="card">

    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php echo $this->render('_card', ['model' => $searchModel]); ?>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    // Ensure the attribute exists and is properly set
                    return [
                        'data-is-seen-by-admin' => $model->is_seen_by_admin ? 1 : 0,
                        'data-id' => $model->id,
                        'class' => 'quotation-row', // Add a class for targeting rows
                    ];
                },
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Quote User',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                return Html::a($user->name, ['/user/default/profile', 'user_id' => $user->id], ['style' => 'color:black !important;']);
                            }
                        }
                    ],
                    [
                        'label' => 'Traveler info',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str =  $model->name;
                            $str .=  "<br>";
                            $str .=  $model->email;
                            $str .=  "<br>";
                            $str .=  $model->phone;
                            return $str;
                        }
                    ],

                    [
                        'label' => 'Looking For',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->destination;
                        }
                    ],
                    [
                        'label' => 'In date Between',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = $model->from_date . ' - ' . $model->to_date;
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Is dates flexible',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_date_flexible == 1 ? 'Yes' : 'No';
                        }
                    ],
                    [
                        'label' => 'Budget',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->budget;
                        }
                    ],
                    [
                        'label' => 'Addional Notes',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->addional_notes;
                        }
                    ],

                    [
                        'label' => 'Are you looking for yourself',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->is_booking_for_login_user     == 1 ? 'Yes' : 'No';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                            ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php
$markSeenUrl = \yii\helpers\Url::to(['quotation/mark-seen']);
$script = <<<JS
$(document).ready(function() {
    $('.quotation-row').each(function() {

        console.log('test');
        var row = $(this);
        var isSeen = row.data('is-seen-by-admin');
        var id = row.data('id');

        if (isSeen == 0) {
            $.ajax({
                url: '$markSeenUrl',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    // Update the row attribute to mark it as seen
                    row.data('is-seen-by-admin', 1);
                    row.css('background-color', '#d4edda'); // Optional: Change row color to indicate it's seen
                },
                error: function() {
                    console.error('Failed to mark row with ID ' + id + ' as seen.');
                }
            });
        }
    });
});
JS;
$this->registerJs($script);
?>