<ul class="nav nav-pills">
    <li><a href="/profile/index" class="nav-link <?= isset($profile) ? $profile : '' ?>">Profile</a></li>
    <li><a href="/profile/activity" class=" nav-link <?= isset($activity) ? $activity : '' ?>">Activity</a></li>
    <li><a href="/profile/contribution" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
    <li><a href="/profile/photo" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photo</a></li>
    <li><a href="/profile/article" class="nav-link <?= isset($article) ? $article : '' ?>">Article</a></li>
    <li><a href="/profile/share-safari" class="nav-link <?= isset($share_safari) ? $share_safari : '' ?>">Share Safari</a></li>
</ul>