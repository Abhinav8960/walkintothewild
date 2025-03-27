<?php

/** @var yii\web\View $this */
/** @var common\models\trierror\ApiRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Activity';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => 'Api Request Log', 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-bordered">
                <thead>
                    <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Date</th>
                    <th scope="col">GET Data</th>
                    <th scope="col">Post Data</th>
                    <th scope="col">Device</th>
                    </tr>
                </thead>
                <tbody><?php 
                    foreach($model as $row){
                        if($row['route'] == 'site/auth'){ ?>
                            <tr>
                                <td>Login</td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td><?= $row['request_parameter']; ?></td>
                                <td><?= $row['request_data']; ?></td>
                                <td><?= $row['system'] ?></td>
                            </tr><?php
                        }else if($row['route'] == 'site/logout'){ ?>
                            <tr>
                                <td>Log Out</td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td><?= $row['request_parameter']; ?></td>
                                <td><?= $row['request_data']; ?></td>
                                <td><?= $row['system'] ?></td>
                            </tr><?php
                        }else if($row['route'] == 'profile/article/create'){ ?>
                            <tr>
                                <td>Create Article</td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td><?= $row['request_parameter']; ?></td>
                                <td><?= $row['request_data']; ?></td>
                                <td><?= $row['system'] ?></td>
                            </tr><?php
                        }else if($row['route'] == 'profile/article/update'){ ?>
                            <tr>
                                <td>Update Article</td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td><?= $row['request_parameter']; ?></td>
                                <td><?= $row['request_data']; ?></td>
                                <td><?= $row['system'] ?></td>
                            </tr><?php
                        }else if($row['route'] == 'user/update'){ ?>
                            <tr>
                                <td>Update Pfofile </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                <td><?= $row['request_parameter']; ?></td>
                                <td><?= $row['request_data']; ?></td>
                                <td><?= $row['system'] ?></td>
                            </tr><?php
                        }
                    }?>
                </body>
            </table>
        </div>
    </div>
</div>
