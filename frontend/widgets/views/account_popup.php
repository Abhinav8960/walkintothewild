<?php

use yii\helpers\Url;

?>
<div class="modal fade _standard-text " id="popupModal" tabindex="-1" aria-labelledby="flagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center" style="background-color: #09422d;">
                <h4 class="modal-title w-100 text-center" id="exampleModalLabel">Alert</h4>
                <button type="button" class="btn_close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <div id='departuremodalContent'>
                    <h6 class="text-center"><a href="<?= Url::toRoute(['/account/default/registration-operator']) ?>">Click Here to Update Account. </a></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById('popupModal'));
        modal.show();
    });
</script>