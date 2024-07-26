<?php

use yii\helpers\Url;

?>

<!-- <div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/chat']) ?>" class="nav-link mb-2 <?= $active == 'message' ? 'active' : '' ?>">Messages</a>
    <a href="<?= Url::toRoute(['/chat/safarioperator']) ?>" class="nav-link mb-2 <?= $active == 'safarioperator' ? 'active' : '' ?>">Safari Operator</a>
</div> -->

<style>
    .chat-card-sidebar {
        max-height: 80vh;
        height: 80vh;
        overflow: scroll;
        border-right: 2px solid #aaa;
    }

    .chat-card-sidebar::-webkit-scrollbar-thumb {
        background-color: #107751;
        border: 4px solid transparent;
        border-radius: 8px;
        background-clip: padding-box;
    }

    .chat-card-sidebar::-webkit-scrollbar {
        width: 10px;
    }

    .chat-message-container {
        height: 70vh;
        overflow: scroll;
        padding-top: 6px;
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
        padding: 10px;
        border-bottom: 1px solid #aaaa;
        justify-content: center;
    }

    .chat-sidebar-user-card .user-icon {
        height: 45px;
    }

    .chat-sidebar-user-card .chat-user_name {
        padding-left: 10px;
    }

    .selected_chat {
        background-color: #107751;
        color: #fff;
        border-radius: 5px;
    }

    .chat-message-header {
        border-bottom: 2px solid #107751;
        padding-bottom: 10px;
    }

    .chat-message-header .user-icon {
        height: 45px;
    }

    .chat-message-input {
        border: 1px solid #107751;
    }

    .chat-sendbtn {
        font-size: 30px;
        color: #107751;
        padding-left: 10px;
    }

    .user-icon-message {
        height: 25px;
    }

    .chat-message .message_body_left {
        background-color: #334651;
        color: #fff;
        margin-right: 55%;
        border-bottom-right-radius: 8px 8px;
        margin-bottom: 1px;
        padding: 3px;
    }

    .chat-message .message_body_right {
        background-color: #009378;
        color: #fff;
        margin-left: 55%;
        margin-bottom: 1px;
        border-bottom-left-radius: 8px 8px;
        padding: 3px;
    }
</style>