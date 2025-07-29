<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Share Safari Comment';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\support\assets\NovaAppAsset')->baseUrl;

?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Date',
                        //'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Share Safari Name',
                        //'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return   isset($model->share_safari_title) ? $model->share_safari_title : '';
                        }
                    ],
                    [
                        'label' => 'Comment',
                        //'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->comment;
                        }
                    ],
                    [
                        'label' => 'Creator Name',
                        //'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->name : '';
                        }
                    ],

                    [
                        'label' => '#Flags',
                        //'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $counter = $model->getReports()->where(['status' => 1])->count();
                            return $counter;
                        }
                    ],

                    [
                        'label' => 'Action',
                        //'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->flaged == 1) {
                                return  Html::a('<i class="mdi mdi-eye"></i>
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