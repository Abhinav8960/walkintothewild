<?php

use yii\bootstrap5\Html;
?>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center p-5 border rounded-4 shadow bg-light" style="border-left: 6px solid rgb(103, 3, 13); max-width: 600px;">
        <div class="mb-3">
            <!-- Red exclamation icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 16 16">
                <!-- Red circle background -->
                <circle cx="8" cy="8" r="8" fill="#dc3545" />
                <!-- White exclamation mark -->
                <path fill="#ffffff" d="M7.002 5a.905.905 0 0 1 1.996 0l-.35 4.5a.55.55 0 0 1-1.096 0L7.002 5z" />
                <circle cx="8" cy="11" r="1" fill="#ffffff" />
            </svg>

        </div>
        <h2 class="text-danger fw-bold mb-2">Account Deactivated</h2>
        <p class="mb-4 text-muted" style="font-size: 1.1rem;">
            Your account has been deactivated. Please contact the administrator for further assistance.
        </p>
    </div>
</div>