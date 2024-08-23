<li><span class="iconSize copytoclipboard" data-href="<?php echo preg_replace("/^http:/i", "https:", Yii::$app->request->absoluteUrl); ?>"><i class="fa-solid fa-link"></i></span></li>

<?php
$script = <<< JS
$(document).ready(function() {
    function copyToClipboard() {
        $('.copytoclipboard').on('click', function () {
            var temp = $("<input>");
            $("body").append(temp);
            temp.val($(this).attr('data-href')).select();
            temp.focus();
            document.execCommand("copy");
            temp.remove();
            return notif({
                type: 'success',
                msg: 'Link Copied',
                position: "right",
            });
        });
    }
    copyToClipboard();
});
JS;
$this->registerJs($script);
?>

<style>
    .copytoclipboard {
        display: list-item !important;
    }
</style>