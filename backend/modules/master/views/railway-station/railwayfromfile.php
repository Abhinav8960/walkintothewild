<?php

use common\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Railway Station';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = ['label' => 'Master', 'url' => '/master/railway-station'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Upload CSV";
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <div class="right-section-wrapper">
            <div class="col-md-12 mt-4">
                <div class="datatable-box-wrapper">
                    <div class="text-right">
                        <small class="text-danger float-left mb-2">All entries in the CSV file should be filled in the correct format. If data is not filled in the correct format, the railway station list will not get uploaded. </small>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mt-3">
                        <?= $this->render('file_form', [
                            'model' => $model
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .fileinput-cancel-button span,
    .btn-file span {
        color: #fff !important;
    }
</style>