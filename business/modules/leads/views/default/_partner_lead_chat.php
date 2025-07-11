 <?php

    use common\models\GeneralModel;
    use common\models\leads\Lead;
    use yii\bootstrap5\Html;
    use yii\helpers\Url;

    ?>
 <div class="chatMainParent d-flex justify-content-between align-items-center">
     <div class="chatHeader d-flex align-items-center gap-3 ">
         <div class="chatuserProfile">
             <img src="<?= !empty($model->user) ? $model->user->profile_display_image : ''; ?>" alt="" srcset="">
         </div>
         <div class="chatUserName">
             <a href=""><?= !empty($model->name) ? $model->name : ''; ?></a>
         </div>
     </div>
     <div class="UserInfobx d-flex align-items-center gap-4">
         <?php if ($model->status == Lead::STATUS_ACTIVE) { ?>
             <div class="sharBtn">
                 <?= Html::button('Share Itinerary & Quotation', [
                        'value' => Url::to(['quotation', 'id' => $model->id]),
                        'class' => 'quotation-button',
                    ]) ?>
             </div>
             <div class="callOption">
                 <?php if ($chat->operator->is_phone_no_verified == 1 && !empty($chat->operator->phone_no) && $chat->user->is_mobile_no_verified == 1 && !empty($chat->user->mobile_no)) { ?>
                     <a href="<?= Url::toRoute(['make-call-on-chat', 'id' => $model->id, 'chat_hash' => $chat->chat_hash]) ?>" class="callHere"><i class="fa-solid fa-phone"></i></a>
                 <?php } ?>
             </div>
             <div class="callOption">
                 <?= Html::button('<i class="fa-solid fa-image"></i>', [
                        'value' => Url::to(['send-gallery', 'id' => $model->id]),
                        'class' => 'callHere image-button',
                    ]) ?>
             </div>
         <?php } ?>
         <!--          
         <div class="callOption">
             <a href="" class="callHere"><i class="fas fa-ellipsis-v"></i></a>
         </div> -->
     </div>
 </div>
 <div class="chatWriteBody">
     <?php
        if ($chats = $chat->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
            foreach ($chats as $chat_message) {
                if (Yii::$app->user->identity && $chat_message->created_by == Yii::$app->user->identity->id) {
        ?>


                 <?php if ($chat_message->is_quotation_message == 1) { ?>
                     <div class="d-flex justify-content-center mt-5">
                         <div class="ItineraryQuotationarea">
                             <div class="topTitle pb-3">
                                 <h3 class="text-center">Itinerary & Quotation</h3>
                             </div>
                             <div class="discriptionsCenter">
                                 <p class="mb-1"><span>Park:</span> <b><?= $chat_message->quote->park_label ?? '' ?></b> </p>
                                 <p class="mb-1"><span>Safaris:</span><b> <?= $chat_message->quote->safaris ?? '' ?></b></p>
                                 <p class="mb-1"><span>Travelers:</span><b> <?= $chat_message->quote->travelers ?? '' ?></b></p>
                                 <p class="mb-1"><span>Stay Category:</span> <b><?= $chat_message->quote->staycatgory_lable ?? '' ?></b></p>
                                 <p class="mb-1"><span>Start Date:</span><b> <?= date('M d, Y', strtotime($chat_message->quote->start_date)) ?? '' ?></b></p>
                                 <p class="mb-1"><span>End Date:</span><b> <?= date('M d, Y', strtotime($chat_message->quote->end_date)) ?? '' ?></b></p>
                                 <p class="mb-2"><strong>Note:</strong><br> <?= $chat_message->quote->addional_notes ?? '' ?></p>
                                 <div class="d-flex align-items-center justify-content-between gap-3 mb-1">
                                     <div>
                                         <p>
                                             <span style="color: red;"><i>Quotation Valid Until:</i></span>
                                             <b><i><?= $chat_message->quote->validity_date ?? '' ?></i></b>
                                         </p>
                                     </div>
                                     <div class="d-flex align-items-center gap-1">

                                         <img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="20" height="20">
                                         <span><b style="font-size: 20px;"><?= GeneralModel::number_format_indian($chat_message->quote->net_payment_price) ?? '' ?></b></span>

                                     </div>
                                 </div>
                                 <p class="mb-1"><span>Read Our:</span><a href="https://www.walkintothewild.in/refund-and-cancellation-policy" target="_blank">Cancellation Policy</a></p>

                             </div>
                             <div class="recievedTime">
                                 <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                             </div>
                         </div>
                     </div>
                     <?php } else if ($chat_message->gallery != null) {
                        $gallery_data = json_decode($chat_message->gallery, true);
                        if ($gallery_data) { ?>

                         <div class="d-flex justify-content-end mt-5">
                             <div class="galleryBox bg-transparent">
                                 <div class="pb-2 d-flex justify-content-end">
                                     <h3 class="text-center"><?= isset($gallery_data['title']) ? $gallery_data['title'] : '' ?></h3>
                                 </div>
                                 <div class="gallery-container">
                                     <?php if ($gallery_data['images']) {
                                            foreach ($gallery_data['images'] as $image) {  ?>
                                             <div class="single-image" data-fancybox="gallery" data-caption="Image 4">
                                                 <img src="<?= isset($image['gallery_image_path']) ? $image['gallery_image_path'] : '' ?>" alt="<?= isset($image['title']) ? $image['title'] : ''  ?>" title="<?= isset($image['caption']) ? $image['caption'] : '' ?>">
                                                 <div class="image-caption"><?= isset($image['caption']) ? $image['caption'] : '' ?></div>
                                             </div>

                                     <?php }
                                        } ?>
                                 </div>

                             </div>
                         </div>
                     <?php }
                    } else if ($chat_message->is_call_message == 1) { ?>
                     <div class="d-flex justify-content-end">
                         <div class="sentChat himselfVoiceCall">
                             <div class="innerBg d-flex align-items-center gap-3">
                                 <div class="callIcons">
                                     <a href=""><i class="fa-solid fa-phone"></i></a>
                                 </div>
                                 <div class="voiceText">
                                     <h3 class="pb-2"><?= $chat_message->message ?></h3>
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
                    } else { ?>
                     <div class="d-flex justify-content-end">
                         <div class="sentChat">
                             <p><?= $chat_message->message ?></p>
                             <div class="timeingNotified d-flex justify-content-end pe-2">
                                 <div class="d-flex gap-3">
                                     <div class="currentTime">
                                         <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                     </div>
                                     <div class="tiknotified">
                                         <i class="fa-solid fa-check-double"></i>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 <?php } ?>

             <?php
                } else { ?>
                 <?php if ($chat_message->is_call_request == 1) { ?>
                     <div class="d-flex justify-content-start">
                         <div class="sentChat incomingVoiceCall">
                             <div class="innerBg innerincomingCall d-flex align-items-center gap-3">
                                 <div class="callIcons">
                                     <a href=""><i class="fa-solid fa-phone"></i></a>
                                 </div>
                                 <div class="voiceText">
                                     <h3 class="pb-2"><?= $chat_message->message ?></h3>
                                     <div class="recievedTime">
                                         <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                     </div>
                                 </div>
                             </div>

                         </div>
                     </div>
                 <?php } else { ?>
                     <div class="receivedChat mt-5">
                         <p><?= $chat_message->message ?></p>
                         <div class="recievedTime">
                             <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                         </div>
                     </div>

     <?php }
                }
            }
        }
        ?>
 </div>


 <div class="modal fade" id="galleryAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header flageHeader">
                 <h6 class="modal-title fs-5" id="exampleModalLabel">
                     Gallery Selection
                 </h6>
             </div>

             <div class="modal-body modal_form">
                 <div id='modalContent'></div>
             </div>

         </div>
     </div>
 </div>


 <div class="modal fade" id="quotationAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header flageHeader">
                 <h6 class="modal-title fs-5" id="exampleModalLabel">
                     Quotation Form
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


    $('.image-button').on('click', function () {
        $('#galleryAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

     $('.quotation-button').on('click', function () {
        $('#quotationAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});


JS;
    $this->registerJs($script);

    ?>

 <?php
    $js = <<<JS
(function () {
    const chatBody = document.querySelector('.chatWriteBody');
    if (!chatBody) return;

    /* scroll to last message right away */
    chatBody.scrollTop = chatBody.scrollHeight;

    /* keep jumping to the bottom whenever a new
       node is inserted (works for AJAX / Pjax /
       WebSocket updates, etc.)                       */
    const observer = new MutationObserver(() => {
        chatBody.scrollTop = chatBody.scrollHeight;
    });
    observer.observe(chatBody, { childList: true });

    /* optional: if you use Pjax to refresh the chat list */
    $(document).on('pjax:end', '#chat-pjax', () => {
        chatBody.scrollTop = chatBody.scrollHeight;
    });
})();
JS;

    $this->registerJs($js, \yii\web\View::POS_READY);
    ?>