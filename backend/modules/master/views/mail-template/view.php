<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mail Template';
$this->params['breadcrumbs_home_url'] = '/master/mail-template';
$this->params['breadcrumbs'][] =  ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/master/mail-template'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-md-10">
                <div class="text-box">
                    <p>
                        <span>Name: </span><?= $model->name ?>
                        <span>Subject: </span><?= $model->subject ?>
                        <span>Path: </span><?= $model->path ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>