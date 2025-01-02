<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\notification\MasterNotificationTemplate $model */

$this->title = 'Notification Template';
$this->params['breadcrumbs_home_url'] = '/master/notification-template';
$this->params['breadcrumbs'][] =  ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-md-10">
                <div class="text-box">
                    <p>
                        <span>Message: </span><?= $model->message ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>