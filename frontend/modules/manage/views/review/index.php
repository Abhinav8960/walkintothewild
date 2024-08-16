<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'review']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $review_dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        'park.title:raw:Park Name',
                                        [
                                            'header' => 'User',
                                            'value' => function ($model) {
                                                if ($user = $model->user) {
                                                    return Html::a(Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded-5 profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name, ['/profile/default/index', 'user_handle' => $user->user_handle]);
                                                }
                                                return $model->user_id;
                                            },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'label' => 'Rating',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->rating;
                                            }
                                        ],
                                        [
                                            'label' => 'Review',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->review;
                                            }
                                        ],
                                        [
                                            'label' => 'Review Time',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'dateTime',
                                            'value' => function ($model) {
                                                return $model->created_at;
                                            }
                                        ],
                                        [
                                            'label' => 'View Flag',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'value' => function ($model) {
                                                return   Html::Button('View', ['value' => Url::toRoute(['/manage/review/flagview', 'id' => $model->id]), 'class' => 'btn btn-info bg-blues py-2 flagBtn', 'title' => 'View Flages']);
                                            }
                                        ],
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Approval Form
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS
    
function writeareviewfunction() {
    $('.flagBtn').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});


}
writeareviewfunction();
    
             
JS;
$this->registerJs($script);
?>