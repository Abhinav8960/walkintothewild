<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'TERMS & CONDITIONS';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/cms/termscondition'];
$this->params['breadcrumbs'][] = "View";
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-10">
                <div class="text-box">
                    <p>
                        <span>Type: </span><?= $model->type ?>
                    </p>
                    
                    <p>
                        <span>Module Description: </span><?= $model->description ?>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>