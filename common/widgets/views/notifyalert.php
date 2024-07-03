   
<?php
$script = <<< JS
    $(function(){

        function success_notify(){
            return notif({
                type: "{$type}",
                msg: "{$message}",
                position: "right",
            });
        }
       
        success_notify(); 
             
    });
JS;
$this->registerJs($script);
?>
            
            
        