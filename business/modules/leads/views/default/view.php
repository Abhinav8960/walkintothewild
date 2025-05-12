<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

?>


<div class="d-flex justify-content-between align-items-center mt-5">
    <!-- <h3 class="mt-5">Leads : <?= $model->name ?>, Quotation Received On <?= date('d M, Y h:i A', $model->created_at) ?></h3> -->
    <h3 class="mt-5">Leads </h3>
</div>




<div class="row mb-5  mt-4 itenary_tabs">
    <div class="col-lg-9 col-xl-9 safartabs position-relative">

        <table class="table table-bordered">
            <thead>
                <th>Source</th>
                <th>Safaris</th>
                <th>Travelers</th>
                <th>Accomodation</th>
                <th>Travel Date looking For</th>
                <th>Lead Received Date</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?= $model->sourceLabel ?>
                    </td>
                    <td>
                        <?= !empty($model->safaris) ? $model->safaris : ''; ?>
                    </td>
                    <td>
                        <?= !empty($model->travelers) ? $model->travelers : '' ?>
                    </td>
                    <td>
                        <?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?>
                    </td>
                    <td>
                        <?php
                        $str =  date('d M, Y', strtotime($model->from_date));
                        if (!empty($model->to_date)) {
                            $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                        }
                        echo $str;
                        ?>
                    </td>
                    <td>
                        <?= date('d M, Y h:i A', $model->created_at) ?>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="card">
            <div class="card-body" id="quotation-form" value="/leads/default/quotation?id=<?= $model->id ?>">

            </div>
        </div>

    </div>

    <div class="col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4>Quatations</h4>
                
            </div>
            
        </div>
    </div>

</div>

<?php
$script = <<< JS
    
		$('#quotation-form').load($('#quotation-form').attr('value'));

JS;
$this->registerJs($script);
?>