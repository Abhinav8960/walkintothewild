<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

$budget = [];
if ($model->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($model->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($model->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatorresquestactivties($model->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}

$html_park = '';
$park = GeneralModel::operatorresquestpark($model->id);
foreach ($park as $key => $role) {
    if (isset(GeneralModel::safariparkoption()[$key])) {
        $html_park .= GeneralModel::safariparkoption()[$key] . ', ';
    }
}
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'follower']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
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
                                        'label' => 'Follow Datetime',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  $model->follow_datetime;
                                        }
                                    ],
                                    [
                                        'label' => 'Unfollow Datetime',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  $model->unfollow_datetime;
                                        }
                                    ],
                                    [
                                        'label' => 'Unfollow Datetime',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  $model->unfollow_datetime;
                                        }
                                    ],
                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return ($model->status == 1) ? 'Following' : 'Unfollowed';
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