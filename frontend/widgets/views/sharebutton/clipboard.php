<li><span class="iconSize copytoclipboard" data-href="<?php echo Yii::$app->request->absoluteUrl; ?>"><i class="fa-solid fa-link"></i></span></li>

<?php
$script = <<< Js

$(document).ready(function() {
    function copyToClipboard() {
        $('.copytoclipboard').on('click', function () {
            var temp = $("<input>");
            $("body").append(temp);
            temp.val($(this).attr('data-href')).select();
            document.execCommand("copy");
            temp.remove();
            alert('Link Copied');
        });
    }
    copyToClipboard();
});


Js;
$this->registerJs($script);
?>