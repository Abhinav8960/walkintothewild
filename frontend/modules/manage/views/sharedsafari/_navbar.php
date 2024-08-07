<ul class="nav nav-tabs border-bottom p" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/view?id=<?= $share_safari->id ?>" class="nav-link <?= isset($interested_active) ? $interested_active : '' ?>" id="home-tab">Interested</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/comment?id=<?= $share_safari->id ?>/1" class="nav-link <?= isset($comment_active) ? $comment_active : '' ?>" id="profile-tab">Comment</a>
    </li>
</ul>