<?php

$chat_message_list = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->all();
?>

<?php if ($chat->is_quote_accept == 1) { ?>
    <div class="chat-message-container" id="chat-message-container">
        <?php
        if ($chat_message_list) {
            foreach ($chat_message_list as $chat_message) { ?>
                <div class="chat-message pt-3">
                    <?php if ($login_user && $chat_message->created_by == $login_user->id) { ?>
                        <div class="reciverchta">
                            <div class="text-right text-justify message_body_right position-relative">
                                <?= $chat_message->message ?>
                            </div>
                        </div>
                    <?php  } else { ?>
                        <div class="text-justify message_body_left position-relative">
                            <?= $chat_message->message ?>
                        </div>
                    <?php } ?>
                </div>
        <?php  }
        } ?>
    </div>
    <div class="chat-send-message-form pt-3">
        <form id="chatmessageform" method="post">
            <div class="lead emoji-picker-container w-100 submit_on_enter">
                <div class="character-count">
                    <span id="char-count">500</span> characters remaining
                </div>

                <textarea type="text" rows="1" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Type a Message" id="chat-message" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['message']) ? Yii::$app->request->post('Chat')['message'] : '' ?>" maxlength="500"></textarea>

                <div class="sendMassege">
                    <div class="chat-sendbtn">
                        <i class="fa fa-paper-plane " id="message_sent_btn"></i>
                    </div>

                </div>
            </div>
            <div class="d-flex align-items-center">
            </div>

            <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">

            <input type="hidden" name="Chat[chat_id]" value="<?= $chat_id ?>">

            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

        </form>

    </div>

<?php } else { ?>
    <div class="chat-message-container" id="chat-message-container">
        <!-- quote sent by viewport -->
        <?php
        $quote_message = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->one();
        if ($chat->created_by == $login_user->id) { ?>
            <div class="chat-message text-center pt-3">
                <div class="text-justify message_body_center position-relative">
                    <?= $quote_message->message ?>
                    <hr>
                    <?php
                    if ($chat->quote_price <> '') { // Price Set  
                    ?>
                        <?php
                        $quote_price_max = $chat->quote_price_max;
                        if ($quote_price_max <> '') {
                            $quote_price_max = " - " . $quote_price_max;
                        }
                        echo 'Quote From ', $chat_person_name, ' : <b>Rs. ', $chat->quote_price, $quote_price_max, '</b>';
                        if ($chat->quote_more_detail == 1) {
                            echo '<br><span class="text-danger">More details needed; this may affect the quoted price.</span>';
                        }
                        ?>
                        <div class="chat-send-message-form">
                            <form id="chatmessageform" method="post">
                                <div class="lead emoji-picker-container w-100 submit_on_enter">
                                    <input type="hidden" name="Chat[message]" class="form-control chat-message-input submit_on_enter" id="chat-message" value="Thanks for sharing" maxlength="500"></input>
                                    <div class="sendMassege btn sendMassegebtn form-control" id="message_sent_btn">
                                        Accept
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                </div>

                                <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">

                                <input type="hidden" name="Chat[chat_id]" value="<?= $chat_id ?>">

                                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

                            </form>

                        </div>
                        <i class="text-small"> <span class="text-danger">*</span> Upon accepting the quote, you'll be able to chat with the operator and your profile will become visible to them.</i>
                    <?php
                    } else {
                        // Price Not Set
                        echo 'Quote Price is not yet estimated by <b>' . $chat_person_name . '</b>';
                    ?>

                    <?php } ?>
                </div>
            </div>



        <?php } else { ?>
            <!-- quote recivied by viewport/operator -->
            <?php
            if ($quote_message) { ?>
                <div class="chat-message text-center pt-3">
                    <div class="text-justify message_body_center position-relative">
                        <?= $quote_message->message ?>
                        <hr>
                        <?php
                        if ($chat->quote_price == '') { // Price Not Yet Set  
                        ?>
                            <div class="chat-send-message-form">
                                <form id="chatmessageform" method="post">
                                    <div class="lead emoji-picker-container w-100 submit_on_enter">

                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                            <div class=" text-black fw-bold">
                                                Estimate quote<br>
                                                <span class="character-count error_display text-danger"></span>
                                            </div>
                                            <div class="position-relative">

                                                <div class="d-flex justify-content-center">
                                                    <input type="number" max="9999999" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Rs. 00000" id="chat-message-min" onkeypress="return this.value.length < 7 && event.charCode >= 48 && event.charCode <= 57;" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['message']) ? Yii::$app->request->post('Chat')['message'] : '' ?>"></input> -
                                                    <input type="number" max="9999999" name="Chat[quote_price_max]" class="form-control chat-message-input submit_on_enter" placeholder="Rs. 00000" id="chat-message-max" onkeypress="return this.value.length < 7 && event.charCode >= 48 && event.charCode <= 57;" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['quote_price_max']) ? Yii::$app->request->post('Chat')['quote_price_max'] : '' ?>"></input>
                                                </div>

                                                <div class="sendMassege" style="top: -22px; position: absolute; right: 0;">
                                                    <div class="chat-sendbtn">
                                                        <i class="fa fa-paper-plane " id="message_sent_btn_price"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $script = <<< JS
                                        $(document).ready(function() {
                                            $('#message_sent_btn_price').click(function(){

                                                let formValid =false;
                                                min_price = Number($('#chat-message-min').val());
                                                max_price = Number($('#chat-message-max').val());

                                                if(min_price>0 && max_price>0){
                                                    if(min_price>=9999999){
                                                        $('#chat-message-min').addClass('is-invalid').removeClass('is-valid');
                                                        $('.error_display').html('Price is Required');
                                                    }else{
                                                        $('#chat-message-min').removeClass('is-invalid').addClass('is-valid');
                                                        $('.error_display').html('');
                                                    }
                                                    if(max_price>=9999999){
                                                        $('#chat-message-max').addClass('is-invalid').removeClass('is-valid');
                                                        $('.error_display').html('Price is Required');
                                                    }else{
                                                        $('#chat-message-max').addClass('is-valid');
                                                        $('.error_display').html('');
                                                    }

                                                    if(min_price>max_price){
                                                        $('#chat-message-max').addClass('is-invalid');
                                                        $('.error_display').html('Max Price Should be greater then min price');
                                                    }else{
                                                        formValid=true;
                                                    }
                                                    if(formValid){
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '/chat/default/sendmessage',
                                                            data:$("#chatmessageform").serialize(),
                                                            success:function(data){
                                                                $('#chat-message-min').val('');
                                                                $('#chat-message-max').val('');
                                                                location.reload();
                                                            },
                                                            dataType:'html'
                                                        });
                                                    }
                                                }else{
                                                    $('#chat-message-min').addClass('is-invalid').removeClass('is-valid');
                                                    $('#chat-message-max').addClass('is-invalid').removeClass('is-valid');
                                                    $('.error_display').html('Estimate Price is Required');
                                                }
                                            });
                                        });
                                        JS;
                                    $this->registerJs($script);
                                    ?>

                                    <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">

                                    <input type="hidden" name="Chat[chat_id]" value="<?= $chat_id ?>">

                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                                    <div class="form-check py-3">
                                        <input class="form-check-input" type="checkbox" value="1" name="Chat[quote_more_detail]" id="quote_more_detail">
                                        <label class="form-check-label " style="font-weight: 500;" for="quote_more_detail">
                                            More details needed; this may affect the quoted price.
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <span class="text-small d-flex gap-1 fw-semibold"> <span class="text-danger">*</span> Once your quotation is accepted, you'll be able to contact and chat with the user directly.</span>
                        <?php
                        } else {
                            // Price is Set Waiting for Accpect 
                            $quote_price_max = $chat->quote_price_max;
                            if ($quote_price_max <> '') {
                                $quote_price_max = " - " . $quote_price_max;
                            }
                            echo 'Estimate Quote Price : <b>Rs. ', $chat->quote_price, $quote_price_max, '</b>';
                            if ($chat->quote_more_detail == 1) {
                                echo '<br><span class="text-danger">More details needed; this may affect the quoted price.</span>';
                            }
                        ?>

                        <?php } ?>
                    </div>
                </div>
            <?php
            } ?>
        <?php }
        ?>
    </div>
<?php } ?>