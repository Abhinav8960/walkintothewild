<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$budget = [];
if ($safari_operator->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($safari_operator->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($safari_operator->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatoractivties($safari_operator->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}

// $html_park = '';
$park = GeneralModel::operatorpark($safari_operator->id);
// foreach ($park as $key => $role) {
//     if (isset(GeneralModel::safariparkoption()[$key])) {
//         $html_park .= GeneralModel::safariparkoption()[$key] . ', ';
//     }
// }
?>
<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['business' => 'active', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="col-md-3 mb-3">
                            <a class="btn_newsafari organizeBtn" href="/profile/business/edit-request"><i class="fas fa-edit me-1"></i>Update Business</a>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">
                                <div class="safri_tour">
                                    <div class="topics_listing">
                                        <ul id="tabList">
                                            <li><a class="tab-items active_safri" data-tab="tab21">
                                                    <div class="numparks">Overview</div><i class="fa-solid fa-chevron-right"></i>
                                                </a></li>
                                            <li><a class="tab-items " data-tab="tab22">
                                                    <div class="numparks">Get A Free Quote</div><i class="fa-solid fa-chevron-right"></i>
                                                </a></li>
                                            <li><a class="tab-items" data-tab="tab23">
                                                    <div class="numparks">User Review</div><i class="fa-solid fa-chevron-right"></i>
                                                </a></li>
                                            <li><a class="tab-items " data-tab="tab24">
                                                    <div class="numparks">Followers</div><i class="fa-solid fa-chevron-right"></i>
                                                </a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xxl-10 col-xl-9">
                                <div class="tab-content_tour active " id="tab21">
                                    <!-- Safari Parks content goes here -->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="<?= $safari_operator->Imagepath ?>" style="width:100%;">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-box">
                                                <p>
                                                    <span>Business Name:</span><?= $safari_operator->business_name ?>
                                                </p>
                                                <p>
                                                    <span>Address: </span><?= $safari_operator->address ?>
                                                </p>
                                                <p>
                                                    <span>Phone Number: </span><?= $safari_operator->phone_no ?>
                                                </p>
                                                <p>
                                                    <span>Email Address: </span><?= $safari_operator->email ?>
                                                </p>
                                                <p>
                                                    <span>Alternate Phone Number: </span><?= $safari_operator->operator_phone_no ?>
                                                </p>
                                                <p>
                                                    <span>Alternate Email Address: </span><?= $safari_operator->operator_email ?>
                                                </p>
                                                <p>
                                                    <span>Registered Name: </span><?= $safari_operator->register_comapany_name ?>
                                                </p>
                                                <p>
                                                    <span>Category: </span><?php


                                                                            if ($safari_operator->category_id) {
                                                                                echo isset(GeneralModel::operatorcategory()[$safari_operator->category_id]) ? GeneralModel::operatorcategory()[$safari_operator->category_id] : '';
                                                                            } ?>
                                                </p>
                                                <p>
                                                    <span>Approved Status:</span>
                                                    <?php
                                                    if ($safari_operator->is_approved) {
                                                        echo isset(GeneralModel::yesnooption()[$safari_operator->is_approved]) ? GeneralModel::yesnooption()[$safari_operator->is_approved] : '';
                                                    } else {
                                                        echo 'No';
                                                    }
                                                    ?>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-box">
                                                <p>
                                                    <span>Instagram Link: </span><a href="<?= $safari_operator->instagram_url ?>" target="_blank"><?= $safari_operator->instagram_url ?></a>
                                                </p>
                                                <p>
                                                    <span>Facebook Link: </span><a href="<?= $safari_operator->facebook_url ?>" target="_blank"><?= $safari_operator->facebook_url ?></a>
                                                </p>
                                                <p>
                                                    <span>Youtube Link: </span><a href="<?= $safari_operator->youtube_link ?>" target="_blank"><?= $safari_operator->youtube_link ?></a>
                                                </p>

                                                <p>
                                                    <span>Website: </span><a href="<?= $safari_operator->website ?>"><?= $safari_operator->website ?></a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-box">

                                                <p>
                                                    <span>Rating: </span><?= $safari_operator->google_rating ?>
                                                </p>
                                                <p>
                                                    <span>Cancellation: </span><?= isset($safari_operator->has_cancellation_policy) ? GeneralModel::yesnooption()[$safari_operator->has_cancellation_policy] : '' ?>
                                                </p>
                                                <p>
                                                    <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                                                </p>
                                                <p>
                                                    <span>Offers Other Wildlife Activities: </span><?= substr($html, 0, -2) ?>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="text-box">
                                            <p>
                                                <span>About Business: </span><?= $safari_operator->about_business ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <h5>Park List</h5>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <td>Park Name</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $srn = 1;
                                                foreach ($park as $key => $park_name) {
                                                ?>
                                                    <tr>
                                                        <td><?= $srn ?></td>
                                                        <td><?= $park_name ?></td>
                                                    </tr>
                                                <?php

                                                    $srn++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-content_tour" id="tab22">
                                    <!-- Safari Parks content goes here -->
                                    <div class="table-responsive">
                                        <?= GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'columns' => [
                                                [
                                                    'class' => 'yii\grid\SerialColumn',
                                                    'contentOptions' => ['style' => 'width: 2%;'],
                                                ],
                                                'park.title:raw:Park Name',
                                                [
                                                    'label' => 'Name',
                                                    'contentOptions' => ['style' => 'width: 10%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->full_name;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Email',
                                                    'contentOptions' => ['style' => 'width: 10%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->email;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Phone Number',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->phone_no;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Safaris',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->safaris;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Travelers',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->travelers;
                                                    }
                                                ],
                                                'staycatgory.title:raw:Stay Category',
                                                [
                                                    'label' => 'Start Date',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->start_date;
                                                    }
                                                ],
                                                [
                                                    'label' => 'End Date',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->end_date;
                                                    }
                                                ],
                                                [
                                                    'label' => 'IP Address',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->ip_address;
                                                    }
                                                ],
                                                [
                                                    'label' => 'OS/Platform',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->os;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Browser',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->browser;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Request Time',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'dateTime',
                                                    'value' => function ($model) {
                                                        return $model->created_at;
                                                    }
                                                ],
                                            ],
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="tab-content_tour" id="tab23">
                                    <!-- Safari Parks content goes here -->
                                    <div class="table-responsive">
                                        <?= GridView::widget([
                                            'dataProvider' => $review_dataProvider,
                                            'columns' => [
                                                [
                                                    'class' => 'yii\grid\SerialColumn',
                                                    'contentOptions' => ['style' => 'width: 2%;'],
                                                ],
                                                'park.title:raw:Park Name',
                                                'user.name',
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
                                                    'label' => 'IP Address',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->user_ip_address;
                                                    }
                                                ],
                                                [
                                                    'label' => 'OS/Platform',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->user_platform;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Browser',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->user_browser;
                                                    }
                                                ],
                                                [
                                                    'label' => 'Deview',
                                                    'contentOptions' => ['style' => 'width: 5%;'],
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return $model->user_device;
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
                                                        return   Html::Button('View', ['value' => "/profile/business/flagview?id=$model->id&safari_operator_id=$model->safari_operator_id", 'class' => 'btn btn_newsafari flagBtn', 'title' => 'View Flages']);
                                                    }
                                                ],
                                            ],
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="tab-content_tour " id="tab24">
                                    <div class="searchSafari_parks mb-4">
                                        <div class="table-responsive">
                                            <?= GridView::widget([
                                                'dataProvider' => $follow_dataProvider,
                                                'columns' => [
                                                    [
                                                        'class' => 'yii\grid\SerialColumn',
                                                        'contentOptions' => ['style' => 'width: 2%;'],
                                                    ],
                                                    [
                                                        'header' => 'User',
                                                        'value' => function ($model) {
                                                            if ($user = $model->user) {
                                                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                                                            }
                                                            return $model->user_id;
                                                        },
                                                        'format' => 'raw',
                                                    ],
                                                    [
                                                        'label' => 'Follow Start Time',
                                                        'value' => function ($model) {
                                                            return $model->follow_datetime;
                                                        }
                                                    ],
                                                    [
                                                        'label' => 'IP Address',
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return $model->user_ip_address;
                                                        }
                                                    ],
                                                    [
                                                        'label' => 'OS/Platform',
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return $model->user_platform;
                                                        }
                                                    ],
                                                    [
                                                        'label' => 'Browser',
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return $model->user_browser;
                                                        }
                                                    ],
                                                    [
                                                        'label' => 'Deview',
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return $model->user_device;
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
        </div>
    </div>
</div>

<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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