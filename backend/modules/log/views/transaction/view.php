<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Transaction';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>


<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <h2>Events</h2>
                <table class="table table-responsive">
                    <thead>
                        <th>Events</th>
                        <th>Date Time</th>

                    </thead>
                    <tbody>
                        <?php
                        if (count($model->transactionEvents) > 0) {
                            foreach ($model->transactionEvents as $event) {
                        ?>
                                <tr>
                                    <td>
                                        <?= $event->eventLabel ?>
                                    </td>
                                    <td>
                                        <?= date('d M, Y h:i A', strtotime($event->event_datetime)) ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>

    </div>

</div>