<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rare Animal';
$this->params['breadcrumbs_home_url'] = '/master/rare-animal';
$this->params['breadcrumbs'][] =  ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/master/rare-animal'];
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
                        <span class="font-weight-bold">Animal Name: </span><?= $model->animal_name ?>
                    </p>
                    <p>
                        <span class="font-weight-bold">Short Description: </span><?= $model->short_description ?>
                    </p>

                    <p>
                        <span class="font-weight-bold">Assigned Park:</span>
                        <?php $rareparkanimals = $model->getRareparkanimals()->where(['status' => 1])->all();
                        $park_names = '';
                        if ($rareparkanimals) {
                            foreach ($rareparkanimals as $rareparkanimal) {
                                if ($safaripark = $rareparkanimal->safaripark) {

                                    $park_names .= $safaripark->title;
                                }
                            }
                            $park_names = substr($park_names, 0, -1);
                        }
                        echo $park_names;
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>