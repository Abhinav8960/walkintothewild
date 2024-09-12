<?php

use yii\helpers\Url;

?>

<!-- <div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/chat']) ?>" class="nav-link mb-2 <?= $active == 'message' ? 'active' : '' ?>">Messages</a>
    <a href="<?= Url::toRoute(['/chat/safarioperator']) ?>" class="nav-link mb-2 <?= $active == 'safarioperator' ? 'active' : '' ?>">Safari Operator</a>
</div> -->

<style>
    .chat-card-sidebar {

        max-height: 92vh;
        height: 88vh;
        width: 100%;
    }

    /* .chat_box.card{

        max-height: 80vh;
        height: 80vh;
        width: 100%;  
    } */

    .chat-cardlist {

        max-height: 80vh;
        height: 80vh;
        width: 100%;
        overflow-y: auto;
    }

    .chat-cardlist::-webkit-scrollbar-thumb {
        background-color: #107751;
        border: 4px solid transparent;
        border-radius: 8px;
        background-clip: padding-box;
    }

    .chat-cardlist::-webkit-scrollbar {
        width: 10px;
    }

    .chat-message-container {
        height: 64vh;
        overflow-y: auto;
        overflow-x: hidden;
        padding-top: 6px;
        position: relative;
    }

    .chat-message-container::-webkit-scrollbar-thumb {
        background-color: #107751;
        border: 4px solid transparent;
        border-radius: 8px;
        background-clip: padding-box;
    }

    .chat-message-container::-webkit-scrollbar {
        width: 10px;
    }

    .chat-link {
        color: inherit;
        margin-bottom: 10px;
    }

    .chat-sidebar-user-card {

        justify-content: center;
        overflow: hidden;
        padding: 5px;

    }

    .chat-card-sidebar.card {

        border-radius: 10px;
    }

    .chat-sidebar-user-card .user-icon {
        height: 35px;
        width: 35px;
    }

    .chat-sidebar-user-card .chat-user_name {
        padding-left: 10px;
    }


    .selected_chat {
        background-color: #b4e0fe;
        color: #000;
        border-radius: 5px;
    }

    .chat-message-header {
        border-bottom: 1px solid #88888861;
        padding-bottom: 10px;
    }

    .chat-message-header .user-icon {
        height: 45px;
        width: 45px;
        /* border: 1px solid; */
    }

    .chat-message-input {
        border: 1px solid #107751;
    }


    .user-icon-message {
        height: 25px;
    }

    .chat-message .message_body_left {
        background-color: #3db1fc;
        color: #fff;
        max-width: 30rem;
        display: inline-block;
        margin-bottom: 1px;
        padding: 0.5rem 1rem;
        border-bottom-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        /* overflow: hidden; */
        overflow-wrap: break-word;
        word-break: break-word;
        text-align: left;
    }

    .chat-message .message_body_left:before {
        display: block;
        clear: both;
        content: '';
        position: absolute;
        top: -5px;
        left: -8px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 12px 15px 12px;
        border-color: transparent transparent #3db1fc transparent;
        -webkit-transform: rotate(-37deg);
        -ms-transform: rotate(-37deg);
        transform: rotate(-37deg);
        text-align: justify;
    }

    .chat-message .message_body_right {
        color: #000;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 400;
        padding: 15px;
        background-color: #f5f5f5;
        max-width: 30rem;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-left-radius: 10px;
        position: relative;
        display: inline-block;
        text-align: justify;
    }

    .chat-message .message_body_right:before {
        display: block;
        clear: both;
        content: '';
        position: absolute;
        bottom: -2px;
        right: -7px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 12px 15px 12px;
        border-color: transparent transparent #f5f5f5 transparent;
        -webkit-transform: rotate(37deg);
        -ms-transform: rotate(37deg);
        transform: rotate(37deg);
        z-index: 1;
    }

    .reciverchta {

        display: flex;
        justify-content: end;
    }

    #message_sent_btn {
        cursor: pointer;
    }

    .chat-user_name .lastmassge {
        font-size: 0.9rem;
        overflow: hidden;
        -o-text-overflow: ellipsis !important;
        text-overflow: ellipsis !important;
        white-space: nowrap;

    }

    .character-count {
        font-style: italic;
        padding-bottom: 5px;
        font-size: 0.8rem;
        color: #888;
        margin-top: 5px;
    }

    .character-count.warning {
        color: red !important;
    }
</style>