<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\park\MasterParkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Park';
$this->params['breadcrumbs_home_url'] = '/park';
$this->params['breadcrumbs'][] = ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/park'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">

        <?= $this->render('@backend/modules/park/views/default/_parkdata', ['model' => $model,]); ?>

    </div>
</div>

<!-- <div class="example"> -->
<div class="panel panel-primary tabs-style-1">


    <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="park_gallery">

                <!-- <div class="card"> -->
                <?= $this->render('@backend/modules/park/views/parkgallery/index', [
                    'active_nav' => 'park_gallery',
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'park_id' => $model->id,
                ]); ?>
                <!-- </div> -->

            </div>


            <div class="tab-pane fade" id="park_animal">
                <p>park_animal cum soluta nobis est eligendi optio cumque nihil Et harum quidem rerum facilis est et expedita distinctio., similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
                <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil Et harum quidem rerum facilis est et expedita distinctio. impedit quo minus id quod maxime</p>
                <p class="mb-0">placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="park_zone">
                <p> park_zone aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="park_vehicle">
                <p> park_vehicle aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="about_park">
                <p>about_park aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="flora_fauna">
                <p> flora_fauna aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="how_to_reach">
                <p> how_to_reach aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
            <div class="tab-pane fade" id="map">
                <p>map aborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio cupiditate non provident praesentium</p>
                <p class="mb-0">deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.similique sunt in culpa qui officia Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
            </div>
        </div>
    </div>
</div>

<!-- </div> -->