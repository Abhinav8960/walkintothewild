<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vehicle';
$this->params['breadcrumbs_home_url'] = '/master/vehicle';
$this->params['breadcrumbs'][] =  ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/master/vehicle'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-2">
                <img src="<?= $model->Imagepath ?>">
            </div>
            <div class="col-md-10">
                <div class="text-box">
                    <p>
                        <span>Name: </span><?= $model->vehicle_name ?>
                    </p>
                  
                </div>
            </div>
        </div>
    </div>
</div>