<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;
use common\models\operator\SafariOperatorRating;

$review_count = SafariOperatorRating::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->count();
$shared_safaries_count = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'host_user_id' => $operator->user_id])->count();

?>

<div class="row  mt-4 pt-4 itenary_tabs justify-content-center">
    <div class="col-lg-12 col-xl-10 safartabs position-relative">
        <ul class="nav nav-tabs d-none d-lg-flex gap-2" role="tablist">
            <li class="nav-item"><a class="nav-link <?= $active == 'package' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/package', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Packages</i>
                </a></li>
            <li class="nav-item"><a class="nav-link <?= $active == 'sharedsafari' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Shared Safari</i>
                </a></li>
            <li class="nav-item"><a class="nav-link <?= $active == 'park' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/view', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Parks</i>
                </a></li>
            <li class="nav-item"><a class="nav-link <?= $active == 'reviewlist' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Review</i>
                </a></li>
            <li class="nav-item"><a class="nav-link <?= $active == 'article' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/article', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Article</i>
                </a></li>
            <li class="nav-item"><a class="nav-link <?= $active == 'contact' ? 'active' : '' ?>" href="<?= Url::toRoute(['/operator/default/contact', 'slug' => $operator->slug, '#' => 'memberview']) ?>">
                    Contact</i>
                </a></li>
        </ul>

    </div>
</div>

<style>
    /* Flex container styles */
    .d-flex {
        display: flex;
    }

    /* Gap between items on medium and larger screens */
    .gap-md-5 {
        gap: 20px;
        /* Adjust as needed */
    }

    /* Gap between items on smaller screens */
    .gap-2 {
        gap: 5px;
        /* Adjust as needed */
    }

    /* Phone and email container styles */
    .phone,
    .email {
        position: relative;
        font-family: "Roboto", sans-serif;
        font-size: var(--fs-18);
        font-weight: 600;
        padding: 10px 0px;
        display: block;
        color: var(--background-primary);
    }

    /* Styling for links (Call and Email) */
    /* .phone a,
    .email a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    } */

    /* Hover effect for links */
    .phone a:hover,
    .email a:hover {
        background-color: #f0f0f0;
        /* Change background color on hover */
    }

    /* Styling for icons */
    .phone i,
    .email i {
        font-size: 1.2rem;
        /* Adjust icon size */
        margin-right: 8px;
        /* Space between icon and text */
    }

    /* Styling for dropdowns (phone numbers and email addresses) */
    .phone .phone-numbers,
    .email .email-addresses {
        display: none;
        position: absolute;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 5px;
        z-index: 10;
    }

    /* Show dropdowns on hover */
    .phone:hover .phone-numbers,
    .email:hover .email-addresses {
        display: block;
    }

    /* Styling for links inside dropdowns */
    .phone .phone-numbers a,
    .email .email-addresses a {
        display: block;
        color: #333;
        text-decoration: none;
        margin-top: 5px;
        transition: color 0.3s ease;
    }

    /* Hover effect for links inside dropdowns */
    .phone .phone-numbers a:hover,
    .email .email-addresses a:hover {
        color: #007bff;
        /* Change color on hover */
    }
</style>