<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'User Post Comment';
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

?>
<div class="card">
    <div class="card-body">
       
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Comment',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->comment;
                        }
                    ],
                    [
                        'label' => 'Creator Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->name : '';
                        }
                    ],

                    [
                        'label' => '#Flags',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $counter = $model->getReports()->where(['status' => 1])->count();
                            return $counter;
                        }
                    ],

                    [
                        'label' => 'Action',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->flaged == 1) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'name' => 'View',
                                ]);
                            } else {
                                return "";
                            }
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Action
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS
    /*
        $('.choose-option').on('click', function () {
            $('#modalAction').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        });
    */
JS;
$this->registerJs($script);
?>