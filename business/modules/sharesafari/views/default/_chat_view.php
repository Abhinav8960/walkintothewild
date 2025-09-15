<?php

use api\models\chat\ChatMessage;
use business\assets\AppAsset;
use common\models\GeneralModel;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\web\JqueryAsset;


$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);
JqueryAsset::register($this);

$this->title = 'Fixed Departure';
?>

<div class="title">
    <p style="font-weight: 700; font-size:25px"><?= $this->title ?></p>
</div>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="details-packages mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-details">
                        <tr>
                            <th>Title</th>
                            <th>Cut Off Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>No of Safari</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-leads py-3">
                        <tr>
                            <td><?= $share_safari->share_safari_title ?></td>

                            <td><?= $share_safari->cut_off_date ?></td>
                            <td><?= $share_safari->start_date ?></td>
                            <td><?= $share_safari->end_date ?></td>
                            <td><?= $share_safari->no_of_safari ?></td>
                            <td>
                                <div class="price-container">
                                    <span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>
                                    <span style="font-weight: bold; color: #2E8B57;"><?= GeneralModel::number_format_indian($share_safari->cost_per_person) ?></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <p class="mb-3 text-center" style="background-color: #C4E3BD; border-radius:5px">Intrested User</p>
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
                                        <div class="pt-2">
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

        <div class="col-lg-7">
            <div class="chats_wrapper">
            </div>
        </div>

    </div>
</div>


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