<ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="/manage/package/view?package_id=<?= $package->id ?>" class="nav-link <?= isset($quote_active) ? $quote_active : '' ?>" id="home-tab">Request Quote</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/package/comment?package_id=<?= $package->id ?>" class="nav-link <?= isset($comment_active) ? $comment_active : '' ?>" id="profile-tab">Comment</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/package/book-now?package_id=<?= $package->id ?>" class="nav-link <?= isset($booknow_active) ? $booknow_active : '' ?>" id="profile-tab">Book Now</a>
    </li>
</ul>