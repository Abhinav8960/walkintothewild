<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Collection ' . '(' . $model->title . ')';
$this->params['title'] = $this->title;
?>



<div class="card border-0">
    <div class="card-body border-0">
        <div id="w1-button" class="mb-3"></div>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <p>Current Images</p>
                
                <div class="table-wrapper">
                <div class="table-responsive">
                    <div class="min-width-table">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width: 5%;'],
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
                                'headerOptions' => ['style' => 'text-align: center;'],
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
            </div>
            <?php
            if ($model && !empty($model->live_images)) {
                $live_arr = json_decode($model->live_images, true);
                if ($live_arr['images']) {
            ?>
                    <div class="col-lg-6 col-md-6">
                        <p>Live Images</p>
                        <div class="table-responsive">
                            <table class="table tablecustoms table-striped align-middle w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Caption</th>
                                        <th>Gallery</th>
                                        <th>Set As <br>Thumbnail</br></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($live_arr['images'] as $index => $live) {  ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><?= isset($live['title']) ? $live['title'] : '' ?></td>
                                            <td><?= isset($live['caption']) ? $live['caption'] : '' ?></td>
                                            <td><img src="<?= isset($live['gallery_image_path']) ? $live['gallery_image_path'] : '' ?>" alt="Gallery" style = "width:50px; height: 50px; text-align: center;"></td>
                                            <td>
                                                <?php
                                                if ($live['set_as_thumbnail']) {
                                                    if ($live['set_as_thumbnail'] == 1) { ?>
                                                        Yes
                                                    <?php } else { ?>
                                                        No
                                                <?php }
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php $count++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            <?php
                }
            } ?>

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