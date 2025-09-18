<?php

use api\models\chat\ChatMessage;
use business\assets\AppAsset;
use common\models\GeneralModel;
use yii\bootstrap5\LinkPager;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\JqueryAsset;

JqueryAsset::register($this);
$this->title = 'Fixed Departure';
?>

<div class="card" style="margin-top: 90px;">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $shareSafariDataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {

                            return $model->share_safari_title <> '' ? $model->share_safari_title : 'Untitled';
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->cut_off_date) ? date('Y-m-d', strtotime($model->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Safaris',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Price',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-5">
            <p class="mb-3 text-center" style="background-color: #237729; border-radius:5px; color: #f2eded !important;">Intrested User</p>
            <div class="card">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($dataProvider->getModels() as $chat) {
                            if ($user = $chat->user) { ?>
                                <li class="p-1 border-bottom bg-body-tertiary">
                                    <a href="#!" class="d-flex justify-content-between user-chat-trigger" data-chat-id="<?= $chat->id ?>">
                                        <div class="d-flex flex-row">
                                            <img src="<?= $user->profile_display_image ?>" alt="avatar"
                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="30">
                                            <div class="pt-2">
                                                <p class="fw-bold mb-0"><?= $user->name ?></p>
                                            </div>
                                            <?php if ($booked = ChatMessage::find()->where(['chat_id' => $chat->id])->andWhere(['IS NOT', 'transaction_id', NULL])->limit(1)->one()) { ?>
                                                <span class="m-2 badge bg-success" style="height: 20px;">Booked</span>
                                            <?php } ?>
                                        </div>
                                        <div class="pt-2 ms-2">
                                            <span class="float-end me-2">
                                                <p><?= date('Y-m-d H:i A', $chat->last_message_at) ?></p>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                    <div class="mt-3">
                        <?= LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['class' => 'pagination justify-content-center'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledPageCssClass' => 'disabled',
                            'activePageCssClass' => 'active',
                        ]) ?>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-7" style="background-color: #f0f8ff; margin-bottom:22px;">
            <div class="chats_wrapper">
            </div>
        </div>

    </div>
</div>

<style>
    .msg_history {
        height: 875px !important;
        overflow-y: auto;
    }
</style>

<?php
$chatUrl = Url::to(['/sharesafari/default/user-chat']);
$initialChatId = isset($chat_id) ? $chat_id : '';

$this->registerJs(
    <<<JS
    function loadChat(chatId) {
        $.ajax({
            url: '{$chatUrl}',
            type: 'GET',
            data: { chat_id: chatId },
            success: function(response) {
                $('.chats_wrapper').html(response);
                $('.user-chat-trigger').closest('li').removeClass('active-user');
                $('.user-chat-trigger[data-chat-id="' + chatId + '"]').closest('li').addClass('active-user');
            },
            error: function() {
                alert('Failed to load chat.');
            }
        });
    }

    $(document).on('click', '.user-chat-trigger', function(e) {
        e.preventDefault();
        var chatId = $(this).data('chat-id');
        loadChat(chatId);
    });

    var initialChatId = '{$initialChatId}';
    if (initialChatId) {
        loadChat(initialChatId);
    }
JS
);
?>

<style>
    .details-packages {
        margin-bottom: 20px;
    }

    .thead-details th {
        background-color: #C4E3BD !important;
        padding: 15px;
        text-align: left;
        font-weight: unset;
        color: #333;
    }

    .tbody-leads td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    .tbody-leads tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbody-leads tr:hover {
        background-color: #f0f8ff;
    }

    .display-image {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .price-container {
        display: flex;
        align-items: center;
    }

    .rupee-icon {
        width: 15px;
        margin-right: 5px;
        margin-bottom: 2px;
    }

    .active-user {
        background-color: #e0f7fa !important;
        border-left: 4px solid #00796b;
    }

    p {
        color: #333 !important;
    }
</style>