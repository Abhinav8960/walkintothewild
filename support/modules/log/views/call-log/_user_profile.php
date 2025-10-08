<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = 'Profile : ' . $user->username;
$this->params['breadcrumbs_home_url'] = '/user/default/index';
$this->params['breadcrumbs'][] =  ['label' => 'User', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <?= Html::img($user->profile_display_image ? $user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:100%; height:auto;"]) ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Login ID :</strong> <?= $user->username ?></p>
                        <p><strong>Name :</strong> <?= $user->name ?></p>
                        <p><strong>Joined At : </strong><?= date('Y-m-d h:i:s', $user->created_at) ?></p>
                        <p><strong>Roles :</strong><?= $user->rolelabels ?></p>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <?= Html::a('<i class="fa fa-eye text-white"></i> View Complete Profile', Yii::$app->params['frontend_url'] . '/profile/user/' . $user->user_handle, ['target' => "_blank", 'class' => 'btn btn-success', 'title' => 'View User Profile', 'data-bs-toggle' => "tooltip"]) ?>
                        </div>
                    </div>


                    <div class="assign-tabs py-3">
                        <div class="container-fluid">
                            <div class="card shadow-sm border-0 rounded-3">
                                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">
                                        <i class="bi bi-chat-dots text-primary me-2"></i> Chat
                                    </h5>
                                </div>
                                <div class="card-body p-3" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
                                    <?php if (isset($chat)){?>
                                        <?= $this->render('_chatbox', ['safari_operator_id' => $safari_operator_model->id,'chat' => $chat,'safari_operator_model' => $safari_operator_model]); 
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>