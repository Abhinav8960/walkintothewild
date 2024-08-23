<li><span class="iconSize copytoclipboard" data-href="<?php echo preg_replace("/^http:/i", "https:", Yii::$app->request->absoluteUrl); ?>"><i class="fa-solid fa-link"></i></span></li>

<?php
$script = <<< JS
$(document).ready(function() {
    function copyHandler(e) {
        var text = $('.copytoclipboard').attr('data-href');
        e.clipboardData.setData('text', text);
        e.preventDefault();
    }
    function copyToClipboard() {
        $('.copytoclipboard').on('click', function () {
            document.addEventListener('copy', copyHandler);
            document.execCommand('copy');
            document.removeEventListener('copy', copyHandler);
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