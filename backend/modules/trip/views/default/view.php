<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Package';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/park/safari/default/index'];
$this->params['breadcrumbs'][] = "Package View";
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Edit Profile', ['/trip/profile/index', 'package_id' => $model->id], ['class' => 'btn btn-orange ', 'title' => 'Edit']);
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-2">
                <img src="<?= $model->imagepath ?>">
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Package Name : </span><?= $model->package_name ?>
                    </p>
                    <p>
                        <span>Info : </span>
                        <?php $html = '';
                        $html .= 'Number Of Day    : ' . $model->no_of_day . '<br>';
                        $html .= 'Number Of Night  : ' . $model->no_of_night . '<br>';
                        $html .= 'Number Of Safari : ' . $model->no_of_safari . '<br>';
                        $html .= 'Start Location   : ' . $model->start_location . '<br>';
                        $html .= 'End Location     : ' . $model->end_location . '<br>';
                        echo $html;
                        ?>
                    </p>
                    <p>
                        <span>Cost Per Person : </span>
                        <?php echo $model->cost_per_person;
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Stay Category : </span>
                        <?php echo isset($model->stay_category_id) ? GeneralModel::packageoption()[$model->stay_category_id] : '';
                        ?>
                    </p>
                    <p>
                        <span>Feature : </span>
                        <?php
                        $html = '';
                        $features = $model->packagefeatures;
                        foreach ($features as $key => $feature) {
                            if (isset(GeneralModel::packagefeatureoption()[$feature->feature_id])) {
                                $html .= GeneralModel::packagefeatureoption()[$feature->feature_id] . ', ';
                            }
                        }
                        echo $html;
                        ?>
                    </p>
                    <p>
                        <span>Included : </span>
                        <?php
                        $html = '';
                        $included = $model->packageincluded;
                        foreach ($included as $key => $data) {
                            if (isset(GeneralModel::packageincludeoption()[$data->include_id])) {
                                $html .= GeneralModel::packageincludeoption()[$data->include_id] . ', ';
                            }
                        }
                        echo $html;
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-box">
                <p>
                    <span>Package Description : </span><?= $model->package_description ?>
                </p>

            </div>
        </div>
    </div>

</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>