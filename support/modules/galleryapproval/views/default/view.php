<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;



$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Collection ' . '(' . $model->title . ')';
$this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('Approved', [Url::toRoute(['approved', 'id' => $model->id])], ['class' => 'btn btn-orange me-2', 'title' => 'Approved']);
// $this->params['buttons'][] = Html::button('Rejection', ['value' => Url::toRoute(['reject', 'id' => $model->id]), 'class' => 'btn btn-danger reject-popup', 'title' => 'Reject']);
?>



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
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->title) ? $model->title : '';
                        }
                    ],
                    [
                        'label' => 'Caption',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->caption) ? $model->caption : '';
                        }
                    ],

                    [
                        'label' => 'Gallery',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model) {
                            return Html::tag('div', Html::img($model->gallery_image, [
                                'alt' => 'Uploaded Image',
                                'style' => 'width:20%; height: 20%;',
                            ]), ['style' => 'text-align: center;']);
                        }
                    ],
                    [
                        'label' => 'Set as Thumbnail',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 15%; text-align: left;'],
                        'value' => function ($model) {
                            return $model->set_as_thumbnail == 1 ? 'Yes' : 'No';
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 15%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="rejectAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Gallery Rejection Remark
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='rejectContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.reject-popup').on('click', function () {
        $('#rejectAction').modal('show')
		.find('#rejectContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>