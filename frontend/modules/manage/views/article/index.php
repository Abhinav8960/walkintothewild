<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center flex-wrap">
        <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
            <div class="d-flex justify-content-between mt-xl-0 mt-3">
                <a href="<?= Url::toRoute(['/manage/article/create']) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2"><i class="fa fa-plus"></i> Create Article</a> &nbsp;
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'article']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        [
                                            'label' => 'Article title',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->title;
                                            }
                                        ],
                                        [
                                            'label' => 'Created At',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'dateTime',
                                            'value' => function ($model) {
                                                return $model->created_at;
                                            }
                                        ],
                                        [
                                            'label' => 'Update',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'value' => function ($model) {
                                                return  Html::a('<i class="fa fa-edit"></i> Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-info join_btn py-2', 'title' => 'Edit Article']);
                                            }
                                        ],
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>