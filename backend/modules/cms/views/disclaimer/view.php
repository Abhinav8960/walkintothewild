<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Disclaimer';
$this->params['breadcrumbs_home_url'] = '/cms/disclaimer';
$this->params['breadcrumbs'][] =  ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/cms/disclaimer'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            
            <div class="col-md-10">
                <div class="text-box">
                    <p>
                        <span>Name: </span><?= $model->title ?>
                    </p>
                  
                </div>
            </div>
        </div>
    </div>
</div>