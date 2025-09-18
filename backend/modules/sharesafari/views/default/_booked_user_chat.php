 <?php

    use common\models\GeneralModel;
    use common\models\partnergallery\PartnerGalleryVersion;
    use yii\bootstrap5\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;

    $this->title = 'Booked Users';


    ?>

 <div class="card" style="margin-top: 90px;">
     <div class="card-body">
         <div id="w1-button" class="mb-3"></div>
         <div class="table-responsive">
             <?= GridView::widget([
                    'dataProvider' => $shareSafariDataProvider,
                    'layout' => "{items}",
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


 <div class="row chat-below mt-2">
     <div class="row">
         <div class="col-lg-12">
             <div class="card-header d-flex justify-content-between align-items-center">
                 <div class="d-flex align-items-center">
                     <img src="<?= !empty($chat->user) ? $chat->user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
                         class="rounded me-2"
                         style="width: 40px; height: 40px; object-fit: cover;">
                     <h5 class="mb-0"><?= !empty($chat->user->name) ? $chat->user->name : ''; ?></h5>
                 </div>
             </div>
             <div class="messaging">
                 <div class="mesgs">
                     <div class="msg_history" id="chatBox">
                         <?php
                            if ($chats = $chat->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
                                foreach ($chats as $chat_message) {
                                    if (Yii::$app->user->identity && $chat_message->created_by == $chat->recipient_user_id) {
                            ?>
                                     <?php
                                        if ($chat_message->partner_gallery_version_id != null) {
                                            $partner_gallery_version = PartnerGalleryVersion::find()->where(['id' => $chat_message->partner_gallery_version_id])->limit(1)->one();
                                            $gallery_data = json_decode($partner_gallery_version->live_images, true);
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
                                                 <p style="color:white !important;"><?= nl2br(Html::encode(GeneralModel::maskContactInfoInString($chat_message->message)))  ?></p>
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
                                     <?php } else if ($chat_message->is_call_message == 1) { ?>
                                         <div class="d-flex justify-content-start m-2">
                                             <div class="receivedChat incomingVoiceCall">
                                                 <div class="innerBg d-flex align-items-center gap-3">
                                                     <div class="callIcons">
                                                         <a href=""><i class="fa-solid fa-phone"></i></a>
                                                     </div>
                                                     <div class="voiceText">
                                                         <h3 style="padding-right: 20px;">
                                                             <?= $chat_message->message ?>
                                                         </h3>
                                                         <div class="recievedTime">
                                                             <span style="color: white;"><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <?php } else if ($chat_message->transaction_id > 0) {
                                            if ($trans_details = $chat_message->transaction) { ?>
                                             <div class="receivedChat mt-5">
                                                 <div class="mb-0">
                                                     <p style="color:green">Booking confirmed</p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Here is your Details:</p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Name: <?= $trans_details->name ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <?php if ($share_safari = $trans_details->share_safari) { ?>
                                                         <p>Shared Safari: <?= $share_safari->share_safari_title ?? '' ?></p>
                                                     <?php
                                                        } ?>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Park: <?= $trans_details->park ? $trans_details->park->title : '' ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Start Date: <?= $trans_details->start_date ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>End Date: <?= $trans_details->end_date ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Number of Safaris: <?= $trans_details->safaris ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Seat: <?= $trans_details->travelers ?? '' ?> </p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Amount: <?= $trans_details->received_amount ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>Reference Id:<?= $trans_details->reference_id ?></p>
                                                 </div>
                                                 <div class="mb-0">
                                                     <p>For any queries or further discussion, message here or call the operator using the call button in chat. Enjoy your upcoming safari!</p>
                                                     <div class="recievedTime">
                                                         <span><?= date('Y-m-d H:i', $chat_message->created_at) ?></span>
                                                     </div>
                                                 </div>
                                             </div>
                                         <?php }
                                        } else { ?>
                                         <div class="receivedChat mt-5">
                                             <p><?= nl2br(Html::encode(GeneralModel::maskContactInfoInString($chat_message->message)))  ?></p>
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
                 </div>
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

     .chat-below {
         background-color: #f9f9f9;
         padding: 15px;
         border-radius: 8px;
         border: 1px solid #ddd;
         margin: 2px;
     }
 </style>