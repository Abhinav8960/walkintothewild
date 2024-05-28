<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BillActsStateActsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Error Log';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">

        <div class="box card-2" style="border-radius:10px;">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-left">
                            <span style="font-size:20px;color:maroon"><?= Html::encode($this->title) ?></span>
                        </div>
                    </div>

                </div><br />
            </div>

            <?php
            Pjax::begin([
                'id' => 'grid-data',
                'enablePushState' => FALSE,
                'enableReplaceState' => FALSE,
                'timeout' => false,
            ]);
            ?>
            <div class="row">
                <div class="col-md-12 text-right" style="margin-right: 15px;padding-bottom:15px">
                    <a href="/errorlog/missingpdf"><button class="btn btn-secondary">Only Missing pdf</button></a>
                    <a href="/errorlog/google"><button class="btn btn-secondary">From Google</button></a>
                    <a href="/errorlog/prsindia"><button class="btn btn-secondary">From PrsIndia</button></a>
                </div>
               
                <div class="col-md-12" style="margin-left: 15px;">
                    <div class="text-left"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
                </div>
                <div class="col-md-12" style="padding: 15px 15px;">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Count</th>
                            <!-- <th>User Id</th> -->
                            <th>Date</th>
                            <th>Error Type</th>
                            <th>Request Type</th>
                            <th style="width: 30%;">Request Url</th>
                            <th style="width: 30%;">Reference Url</th>
                            <th>Ip Address</th>
                            <th>Message</th>

                        </tr>
                        <tbody class="row_position">
                            <?php
                            $sn = 1;
                            foreach ($dataProvider->models as $model) {
                                ?>
                            <tr id="<?php echo $model->id; ?>">
                                <th><?= $sn ?></th>
                                <?php
                            if(isset($model->cnt) && !empty($model->cnt))
                            { ?>
                                <td><?=$model->cnt?></td>
                                <?php }else{ ?>
                                    <td>1</td>
                            <?php    }
                            ?>
                                <!-- <td><?= $model->user_session_id ?></td> -->
                                <td><?=$model->created_at ?></td>
                                <td><?= $model->error_type ?></td>
                                <td><?= $model->request_type ?></td>
                                <td><?= $model->request_url ?></td>
                                <td><?= $model->reference_url ?></td>
                                <td><?= $model->ip_address ?></td>
                                <td><?= $model->error_msg ?></td>
                            </tr>
                            <?php
                                $sn++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                    ]);
                    ?>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>


<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    word-break: break-word;
}

tr:nth-child(even) {
    background-color: #fff;
}
</style>