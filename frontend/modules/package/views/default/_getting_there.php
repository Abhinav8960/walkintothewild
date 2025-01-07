<div class="itenary-title">
    <h6 class="fs-6 fw-bold pb-2">GETTING THERE</h6>
</div>
<?php if ($package->getting_there) { ?>
    <div class="itenary_text inclusions">
        <p><?= $package->getting_there ?></p>
    </div>
<?php } else {  ?>
    <div class="itenary_text inclusions">
        <p>The organizer has not provided any information.</p>
    </div>
<?php } ?>