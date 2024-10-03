<?php

use common\interfaces\StatusInterface;
use common\models\operator\SafariOperator;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>
<div class="container-lg mt-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-4 align-items-center flex-wrap">
                <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
                <?php if ($safari_operator->status == SafariOperator::STATUS_ACTIVE) { ?>
                    <div class="d-flex align-items-center mt-xl-0 mt-2">
                        <button class="btn_newsafari organizeBtn newbg departureBtn py-2 rounded-2 " value="<?= \yii\helpers\Url::toRoute(['create-fixed-departure']) ?>">+ Create Fixed Departure </button>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 ">
            <div class="card account-settingside ">
                <div class="card-body p-4">
                    <div class="row">
                        <?php if ($safari_operator->status != SafariOperator::STATUS_ACTIVE) {
                            echo $this->context->module->account_deactivate_message;
                        } ?>
                        <?php
                        Pjax::begin([
                            'id' => 'grid-data',
                            'enablePushState' => FALSE,
                            'enableReplaceState' => FALSE,
                            'timeout' => FALSE,
                        ]);
                        ?>
                        <?php

                        echo $this->render('_search', ['searchModel' => $searchModel]);

                        if ($models = $fixed_safari_provider->getModels()) {
                            echo '<div class="row">';
                            foreach ($models as $share_safari) {

                                echo '<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">';
                                echo $this->render('_shared_safari_card', ['share_safari' => $share_safari]);
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo 'No Share Safari Created';
                        } ?>
                        <div class="col-md-12 ">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $fixed_safari_provider,
                                    'layout' => '{summary}<br>{pager}',
                                ]); ?>
                            </div>
                        </div>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="departure-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Organize a New Fixed Departure</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body ">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

function departurefunction() {
	$('.departureBtn').on('click', function () {
        $('#departure-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
departurefunction();
             
JS;
$this->registerJs($script);
?>