
<?php

$login_user = Yii::$app->user->identity;
$login_user_id = $login_user->id;
$script = <<< JS
    function success_notify(notice_data){
        $.ajax({
            url: '/site/notification?notice_id='+notice_data.id+'&update_is_seen=1',
            type: 'POST',
        });
        return notif({
            type: 'notification',
            msg: notice_data.shortmessage,
            position: "right",
        });
    }             
JS;
$this->registerJs($script);
?>

<?php
$PUSHER_AUTH_KEY = Yii::$app->params['PUSHER_AUTH_KEY'];
$cluster = Yii::$app->params['PUSHER_CLUSTER'];
$script = <<< JS
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{$PUSHER_AUTH_KEY}', {
        cluster: '{$cluster}'
    });

    var channel = pusher.subscribe('UserNotificationChannel');
    channel.bind('UserEvent', function(data) {
        if($login_user_id==data.user_id){
            success_notify(data);
        }
    });                  
JS;
$this->registerJs($script);
?>