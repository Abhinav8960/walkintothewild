<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'user_review']) ?>
    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                <div class="table-wrapper shadow-none rounded-0">
                    <div class="table-responsive">
                        <div class="min-width-table">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                                            <div class='col-md-4'></div>
                                            </div>",
                                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'headerOptions' => ['style' => 'width: 1%;'],
                                    ],
                                    [
                                        'label' => 'User',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($user = $model->user) {
                                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                                            }
                                            return $model->user_id;
                                        }
                                    ],

                                    [
                                        'label' => 'Safari Operator',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  isset($model->safari_operator_id) ? GeneralModel::safariparkoperatoroption()[$model->safari_operator_id] : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Park',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  isset($model->park_id) ? GeneralModel::safariparkoption()[$model->park_id] : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Rating',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->rating;
                                        }
                                    ],
                                    [
                                        'label' => 'Review',
                                        'contentOptions' => [
                                            'style' => 'white-space: normal; word-wrap: break-word; max-width: 600px;',
                                        ],

                                        // 'contentOptions' => ['style' => 'width: 50%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->review;
                                        }
                                    ],
                                    [
                                        'label' => 'Flaged',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return ($model->flaged == 1) ? 'Yes' : 'No';
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .text-box p span {
        color: brown !important;
    }
</style>



<!-- <div class="tab-pane fade" id="eighttcont" role="tabpanel" aria-labelledby="contact-tab">
    <div class="table-wrapper shadow-none rounded-0 pb-4">
        <div class="table-responsive">
            <div class="min-width-table">
                <div id="w0" class="grid-view">
                    <table class="table tablecustoms table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 1%;">#</th>
                                <th>User Name</th>
                                <th>Safari Operator</th>
                                <th>Park</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Flaged</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-key="838">
                                <td>1</td>
                                <td><img class="rounded profile-picture"
                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                        alt="" style="width:28px;"> Sahil Modi</td>
                                <td>Kanha National Park</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>2</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>Lorem ipsum</td>
                            </tr>
                            <tr data-key="838">
                                <td>1</td>
                                <td><img class="rounded profile-picture"
                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                        alt="" style="width:28px;"> Sahil Modi</td>
                                <td>Kanha National Park</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>2</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>Lorem ipsum</td>
                            </tr>
                            <tr data-key="838">
                                <td>1</td>
                                <td><img class="rounded profile-picture"
                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                        alt="" style="width:28px;"> Sahil Modi</td>
                                <td>Kanha National Park</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>2</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>Lorem ipsum</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->