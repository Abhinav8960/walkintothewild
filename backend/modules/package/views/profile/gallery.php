<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::Button('+ Add New Gallery Image', ['value' => "/package/profile/create-gallery?package_id=$package_model->id", 'class' => 'btn popupButton btn-orange me-2', 'title' => 'Create Gallery']);
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'gallery_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                    ],
                                    [
                                        'label' => 'Image Caption',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->image_caption;
                                        }
                                    ],
                                    [
                                        'label' => 'Image',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Html::img($model->imagepath, ['alt' => 'Banner Photograph', 'style' => 'max-width:60px;']);
                                        }
                                    ],
                                    'created_at:dateTime:Created at',
                                    'updated_at:dateTime:Last Updated at',
                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->statuslabel;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'template' => '{update}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return Html::Button('+ Edit Gallery Image', ['value' => "/package/profile/create-gallery?package_id=$model->package_id&id=$model->id", 'class' => 'btn popupButton btn-orange me-2', 'title' => 'Create Gallery']);
                                            },
                                        ]
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