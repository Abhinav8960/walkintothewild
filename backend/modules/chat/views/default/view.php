<?php

use common\models\chat\ChatMessage;
use common\models\GeneralModel;
use yii\bootstrap5\Html;
use yii\data\Pagination;
use yii\helpers\Url;

?>

<div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="<?= $user && $user->profile_display_image ? $user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
            class="rounded me-2"
            style="width: 40px; height: 40px; object-fit: cover;">
        <h5 class="mb-0"><?= Html::encode($model->displayLabelUser) ?></h5>

        <strong class="fs-1 mb-3">↔</strong>

        <img src="<?= $recipient && $recipient->profile_display_image ? $recipient->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
            class="rounded me-2"
            style="width: 40px; height: 40px; object-fit: cover;">
        <h5 class="mb-0"><?= Html::encode($model->displayLabelRecipient) ?></h5>
    </div>
    <!-- <div class="d-flex align-items-center">
        <strong class="text-danger"><?= $model->chat_type ? '(' . GeneralModel::chattype($model->chat_type) . ')' : '' ?></strong>
    </div> -->
    <div>
        <?php if ($model->lead_id != null) { ?>
            <?= $this->params['buttons'][] = Html::button('View Lead Details', ['value' => Url::toRoute(['view-lead-details', 'chat_id' => $model->id]), 'class' => 'btn btn-info pop-up me-2', 'title' => 'View Lead Details']); ?>
        <?php } ?>
    </div>
</div>

<div class="messaging">
    <div class="mesgs">
        <div class="msg_history" id="chatBox">

            <?php
            if ($model) {
                if ($chats = $model->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
                    foreach ($chats as $chat_message) {
                        if ($chat_message->created_by == $model->recipient_user_id) {
            ?>
                            <?php if ($chat_message->is_quotation_message == 1) { ?>
                                <div class="d-flex justify-content-center m-2">
                                    <div class="ItineraryQuotationarea">
                                        <div class="topTitle pb-3">
                                            <h3 class="text-center">Itinerary & Quotation</h3>
                                        </div>
                                        <div class="discriptionsCenter">
                                            <p class="mb-1"><span>Park:</span> <b><?= $chat_message->quote->park_label ?? '' ?></b> </p>
                                            <p class="mb-1"><span>Safaris:</span><b> <?= $chat_message->quote->safaris ?? '' ?></b></p>
                                            <p class="mb-1"><span>Travelers:</span><b> <?= $chat_message->quote->travelers ?? '' ?></b></p>
                                            <p class="mb-1"><span>Stay Category:</span> <b><?= $chat_message->quote->staycatgory_lable ?? '' ?></b></p>

                                            <p class="mb-1"><span>Start Date:</span><b><?= !empty($chat_message->quote->start_date) ? date('M d, Y', strtotime($chat_message->quote->start_date)) : '' ?></b></p>
                                            <p class="mb-1"><span>End Date:</span><b><?= !empty($chat_message->quote->end_date) ? date('M d, Y', strtotime($chat_message->quote->end_date)) : '' ?></b></p>
                                            <p class="mb-2"><strong>Note:</strong><br> <?= $chat_message->quote->addional_notes ?? '' ?></p>
                                            <div class="d-flex align-items-center justify-content-between gap-3 mb-1">
                                                <div>
                                                    <p>
                                                        <span style="color: red;"><i>Quotation Valid Until:</i></span>
                                                        <b><i><?= $chat_message->quote->validity_date ?? '' ?></i></b>
                                                    </p>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">

                                                    <img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20" height="20">
                                                    <span><b style="font-size: 20px;"><?= GeneralModel::number_format_indian($chat_message->quote->net_payment_price) ?? '' ?></b></span>
                                                </div>
                                            </div>
                                            <p class="mb-1"><span>Read Our:</span><a href="https://www.walkintothewild.in/refund-and-cancellation-policy" target="_blank">Cancellation Policy</a></p>

                                        </div>
                                        <div class="recievedTime d-flex justify-content-end">
                                            <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php } else if ($chat_message->gallery != null) {
                                $gallery_data = json_decode($chat_message->gallery, true);
                                if ($gallery_data) { ?>

                                    <div class="d-flex justify-content-end m-2">
                                        <div class="galleryBox bg-transparent">
                                            <div class="pb-2 d-flex justify-content-end">
                                                <h3 class="text-center"><?= isset($gallery_data['title']) ? $gallery_data['title'] : '' ?></h3>
                                            </div>
                                            <div class="gallery-container">
                                                <?php if ($gallery_data['images']) {
                                                    foreach ($gallery_data['images'] as $image) { ?>
                                                        <div class="single-image" data-fancybox="gallery" data-caption="Image 4">
                                                            <img src="<?= isset($image['gallery_image_path']) ? $image['gallery_image_path'] : '' ?>" alt="<?= isset($image['title']) ? $image['title'] : '' ?>" title="<?= isset($image['caption']) ? $image['caption'] : '' ?>">
                                                            <div class="image-caption"><?= isset($image['caption']) ? $image['caption'] : '' ?></div>
                                                        </div>

                                                <?php }
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                <?php }
                            } else if ($chat_message->is_call_message == 1) { ?>
                                <div class="d-flex justify-content-end m-2">
                                    <div class="sentChat himselfVoiceCall">
                                        <div class="innerBg d-flex align-items-center gap-3">
                                            <div class="callIcons">
                                                <a href=""><i class="fa-solid fa-phone"></i></a>
                                            </div>
                                            <div class="voiceText">
                                                <h3 style="padding-right: 20px;">
                                                    <?php if ($chat_message->status == 0) { ?>
                                                        <p class="fst-italic"><?= $chat_message->message ?></p>
                                                    <?php } else { ?>
                                                        <p><?= $chat_message->message ?></p>
                                                    <?php } ?>
                                                </h3>

                                                <?php if (!empty($chat_message->recordingUrl)) { ?>
                                                    <audio controls style="margin-top: 10px; width:225px">
                                                        <source src="<?= $chat_message->recordingUrl ?>" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                <?php } ?>

                                                <div class="currentTime">
                                                    <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php } elseif ($chat_message->is_system_generated == 1) { ?>
                                <div class="d-flex justify-content-center m-2">
                                    <div class="ItineraryQuotationarea">
                                        <div class="topTitle pb-3">
                                            <h6 class="text-center"><?= $chat_message->message ?></h6>
                                        </div>
                                        <div class="recievedTime d-flex justify-content-end">
                                            <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            } else {
                            ?>
                                <div class="d-flex justify-content-end m-2">
                                    <div class="sentChat">
                                        <?php if ($chat_message->status == 0) { ?>
                                            <p class="fst-italic"><?= $chat_message->message ?></p>
                                        <?php } else { ?>
                                            <p><?= $chat_message->message ?></p>
                                        <?php } ?>
                                        <div class="timeingNotified d-flex justify-content-end pe-2">
                                            <div class="d-flex gap-3">
                                                <?php if ($chat_message->is_edited) { ?>
                                                    <div class="currentTime">
                                                        <span><?= 'Edited' . ' ' . date('Y-m-d h:i A', $chat_message->created_at) ?></span>
                                                    </div>
                                                    <div class="tiknotified">
                                                        <i class="fa-solid fa-check-double" style="color: #ffffff;"></i>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="currentTime">
                                                        <span><?= date('Y-m-d h:i A', $chat_message->created_at) ?></span>
                                                    </div>
                                                    <div class="tiknotified">
                                                        <i class="fa-solid fa-check-double" style="color: #ffffff;"></i>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php
                        } else {
                        ?>
                            <?php if ($chat_message->is_call_request == 1) { ?>
                                <div class="d-flex justify-content-start m-2">
                                    <div class="sentChat incomingVoiceCall">
                                        <div class="innerBg innerincomingCall d-flex align-items-center gap-3">
                                            <div class="callIcons">
                                                <a href=""><i class="fa-solid fa-phone"></i></a>
                                            </div>
                                            <div class="voiceText">
                                                <h3 style="padding-right: 20px;">
                                                    <?php if ($chat_message->status == 0) { ?>
                                                        <p class="fst-italic"><?= $chat_message->message ?></p>
                                                    <?php } else { ?>
                                                        <p><?= $chat_message->message ?></p>
                                                    <?php } ?>
                                                </h3>
                                                <div class="recievedTime">
                                                    <span><?= date('Y-m-d h:i A', $chat_message->created_at) ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php } elseif (!empty($chat_message->transaction_id)) {
                            ?>
                                <div class="d-flex justify-content-center m-2">
                                    <div class="ItineraryQuotationarea">
                                        <div class="topTitle pb-3">
                                            <h3 class="text-center">Booking <?= $chat_message->transaction->is_payment_received == 1 ? 'Successful' : 'Failed' ?></h3>
                                        </div>
                                        <div class="discriptionsCenter">
                                            <p class="mb-1"><span>Name:</span> <b><?= $chat_message->transaction->name ?? '' ?></b> </p>
                                            <p class="mb-1"><span>Shared Safari:</span> <b><?= $chat_message->transaction->share_safari->share_safari_title ?? '' ?></b> </p>
                                            <p class="mb-1"><span>Park:</span> <b><?= $chat_message->transaction->park_label ?? '' ?></b> </p>
                                            <p class="mb-1"><span>Start Date:</span><b><?= !empty($chat_message->transaction->start_date) ? date('M d, Y', strtotime($chat_message->transaction->start_date)) : '' ?></b></p>
                                            <p class="mb-1"><span>End Date:</span><b><?= !empty($chat_message->transaction->end_date) ? date('M d, Y', strtotime($chat_message->transaction->end_date)) : '' ?></b></p>
                                            <p class="mb-1"><span>Number of Safaris:</span><b> <?= $chat_message->transaction->safaris ?? '' ?></b></p>
                                            <p class="mb-1"><span>Seat:</span><b> <?= $chat_message->transaction->travelers ?? '' ?></b></p>
                                            <p class="mb-1"><span>Amount:</span><b> <?= $chat_message->transaction->received_amount ?? '' ?></b></p>
                                            <p class="mb-1"><span>Reference ID:</span> <b><?= $chat_message->transaction->reference_id ?? '' ?></b></p>


                                            <p class="mb-1">For any queries or further discussion, message here or call the operator using the call button in chat. Enjoy your upcoming safari!</p>

                                        </div>
                                        <div class="recievedTime d-flex justify-content-end">
                                            <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else { ?>
                                <div class="receivedChat m-2">
                                    <?php if ($chat_message->status == 0) { ?>
                                        <p class="fst-italic"><?= $chat_message->message ?></p>
                                    <?php } else { ?>
                                        <p><?= $chat_message->message ?></p>
                                    <?php } ?>
                                    <?php if ($chat_message->is_edited) { ?>
                                        <div class="recievedTime">
                                            <span><?= 'Edited' . ' ' . date('Y-m-d h:i A', $chat_message->created_at) ?></span>
                                        </div>
                                    <?php } else { ?>
                                        <div class="recievedTime">
                                            <span><?= date('Y-m-d h:i A', $chat_message->created_at) ?></span>
                                        </div>
                                    <?php } ?>
                                </div>

            <?php
                            }
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
</div>


<div class="modal fade" id="viewleaddetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    View Lead Details
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>


<style>
    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }


    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 100%;
    }



    .messaging {
        padding: 0 0 50px 0;
    }

    .msg_history {
        height: 516px;
        overflow-y: auto;
    }


    .receivedChat p {

        font-size: 14px;
        color: #131313;
    }

    .receivedChat {

        max-width: 380px;
        background: #eaeaea;
        padding: 15px 12px;
        border-radius: 0px 15px 15px 15px;
    }

    .recievedTime span {
        color: #000000;
        font-size: 12px;
    }

    .ItineraryQuotationarea {

        min-width: 480px;
        background-color: #fafafa;
        padding: 15px;
        border-radius: 15px;
    }

    .topTitle h3 {

        font-size: 18px;
        font-weight: 700;
    }


    .discriptionsCenter p {

        font-size: 12px;
        color: #421421;
    }


    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: end;
    }

    .gallery-container .single-image {
        display: block;
        width: 300px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }


    .gallery-container img {
        width: 100%;
        height: auto;
        display: block;
    }


    .sentChat {

        max-width: 340px;
        background-color: #09432D;
        padding: 7px 7px 20px 10px;
        border-radius: 15px 0px 15px 15px;
    }

    .sentChat {

        margin-top: 50px;
    }

    .sentChat p {
        color: #fff;
        font-size: 12px;

    }


    .sentChat.himselfVoiceCall {

        max-width: 300px !important;
        background-color: #144D37 !important;
    }

    .currentTime span {

        color: #fff;
        font-size: 12px;

    }

    .voiceText h3 {

        color: #fff;
        font-size: 15px;
        font-weight: 400;
    }

    .callIcons {

        width: 35px;
        height: 35px;
        background-color: #242626;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .callIcons a i {

        color: #fff !important;
        font-size: 15px;
    }

    .voiceText a i {
        color: #fff !important;
        font-size: 15px;
    }
</style>


<?php
$js = <<<JS

    \$('.pop-up').on('click', function () {
        // console.log('Clicked:', \$(this).attr('value'));
        \$('#viewleaddetails').modal('show')
            .find('#modalContent')
            .load(\$(this).attr('value'));
    });

    (function () {
        const chatBox = document.querySelector('#chatBox');
        if (!chatBox) return;

        chatBox.scrollTop = chatBox.scrollHeight;

        const observer = new MutationObserver(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        });
        observer.observe(chatBox, { childList: true });

        \$(document).on('pjax:end', '#chat-pjax', () => {
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    })();
    JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>