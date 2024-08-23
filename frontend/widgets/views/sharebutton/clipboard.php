<li class="copytoclipboard"><span class="iconSize copytoclipboardSpan" data-href="<?php echo preg_replace("/^http:/i", "https:", Yii::$app->request->absoluteUrl); ?>"><i class="fa-solid fa-link"></i></span></li>
<li class="copytoclipboardModal"><span class="iconSize copytoclipboardModalSpan" data-href="<?php echo preg_replace("/^http:/i", "https:", Yii::$app->request->absoluteUrl); ?>"><i class="fa-solid fa-link"></i></span></li>

<?php
$script = <<< JS
$(document).ready(function() {
    function copyToClipboard() {
        $('.copytoclipboardSpan').on('click', function () {
            var temp = $("<input>");
            $("body").append(temp);
            temp.val($(this).attr('data-href')).select();
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
    .copytoclipboardModal {
        display: none;
    }

    .modal-content .copytoclipboardModal {
        display: list-item;
    }

    .modal-content .copytoclipboard {
        display: none;
    }
</style>


<script>
    function copyToClipboardModal() {
        $('.copytoclipboardModalSpan').on('click', function() {
            text = $(this).attr('data-href');
            if (window.location.protocol !== 'https:') {
                console.warn('Clipboard API requires HTTPS');
                // return;
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    return notif({
                        type: 'success',
                        msg: 'Link Copied',
                        position: "right",
                    });
                }).catch(function(error) {
                    console.error('Failed to copy text: ', error);
                    copyToClipboardFallback(text);
                });
            } else {
                copyToClipboardFallback(text);
            }
        });
    }

    function copyToClipboardFallback(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Fallback: Copying text command was ' + msg);
            return notif({
                type: 'success',
                msg: 'Link Copied',
                position: "right",
            });
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        document.body.removeChild(textArea);
    }
</script>