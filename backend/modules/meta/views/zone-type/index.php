<?php

$this->title = 'Zone Type';
$this->params['breadcrumbs_home_url'] = '/meta/zone-type';
$this->params['breadcrumbs'][] =  ['label' => 'Meta', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;


?>

<div class="card">

    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>

        <div class="row">
            <div class="col-md-12 table-responsive">
            <table class="table table-striped table-bordered table_design">
                    <thead>
                        <tr>
                            <th style="width: 5%!important;">Sr. No.</th>
                            <th style="width: 20%!important;">Name</th>
                            <th style="width: 20%!important;">Color Code</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($models) { // $this->title = 'Area in '.$city_name->response['0']->city;
                            $i = 1;
                            foreach ($models as $model) { ?>

                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $model->name ?></td>
                                    <td><?= $model->color_code ?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>