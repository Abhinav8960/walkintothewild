<div class="itenary-title">
    <h6 class="fs-5 pb-2" style="padding-bottom: 0 !important;">GETTING THERE</h6>
</div>
<?php if ($share_safari->getting_there) { ?>
    <div class="itenary_text">
        <p><?= $share_safari->getting_there ?></p>
    </div>
<?php } else {  ?>
    <div class="itenary_text">
        <p>The organizer has not provided any information.</p>
    </div>
<?php } ?>