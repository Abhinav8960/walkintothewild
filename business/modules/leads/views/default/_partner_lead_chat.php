 <?php

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
         <div class="sharBtn">
             <button type="btn" class="">
                 Share Itinerary & Quotation
             </button>
         </div>
         <div class="callOption">
             <a href="<?= Url::toRoute(['make-call-on-chat', 'id' => $model->id]) ?>" class="callHere"><i class="fa-solid fa-phone"></i></a>
         </div>
         <div class="callOption">
             <?= Html::button('<i class="fa-solid fa-image"></i>', [
                    'value' => Url::to(['send-gallery', 'id' => $model->id]),
                    'class' => 'callHere image-button',
                ]) ?>
         </div>
         <div class="callOption">
             <a href="" class="callHere"><i class="fas fa-ellipsis-v"></i></a>
         </div>
     </div>
 </div>
 <div class="chatWriteBody">
     <?php
        if ($chats = $chat->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
            foreach ($chats as $chat_message) {
                if (Yii::$app->user->identity && $chat_message->created_by == Yii::$app->user->identity->id) {
        ?>
                 <div class="d-flex justify-content-end">

                     <?php if ($chat_message->message != 'Gallery') { ?>
                         <div class="sentChat">
                             <p><?= $chat_message->message ?></p>
                             <div class="timeingNotified d-flex justify-content-end pe-2">
                                 <div class="d-flex gap-3">
                                     <div class="currentTime">
                                         <span><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                                     </div>
                                     <div class="tiknotified">
                                         <i class="fa-solid fa-check-double"></i>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <?php } else {
                            $gallery_data = json_decode($chat_message->gallery, true);
                            if ($gallery_data) { ?>

                     <?php }
                        } ?>
                 </div>
             <?php
                } else { ?>
                 <div class="receivedChat">
                     <p><?= $chat_message->message ?></p>
                     <div class="recievedTime">
                         <span><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                     </div>
                 </div>
     <?php }
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


 <?php
    $script = <<< JS


    $('.image-button').on('click', function () {
        $('#galleryAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
    $this->registerJs($script);

    //     $script = <<< JS
    // $(document).ready(function() {

    //     function sendmessage(){
    //         $.ajax({
    //             type: 'POST',
    //             url: '/leads/default/send-message',
    //             data:$("#chatmessageform").serialize(),
    //             success:function(data){
    //                 $('#chat-message').val('');
    //                 location.reload();
    //             },
    //             dataType:'html'
    //         });   
    //     }

    //     $('#message_sent_btn').click(function(){
    //         sendmessage();
    //     });

    //     $('#chat-message').keydown(function(e) {
    //         if (e.keyCode === 13) { 
    //             if (e.shiftKey) {
    //                 return ;
    //             } else {
    //                 e.preventDefault(); 
    //                 sendmessage();
    //             }
    //         }
    //     });
    // });
    // JS;
    //     $this->registerJs($script);
    ?>