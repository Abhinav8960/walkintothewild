<?php

use yii\bootstrap5\Html;


$this->title = 'Partner Registration';
$this->params['title'] = $this->title;
?>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center p-5 border rounded-4 shadow bg-light" style="border-left: 6px solid #28a745; max-width: 600px;">
        <div class="mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08-.02l3.992-4.99a.75.75 0 1 0-1.15-.96L7.525 9.507 5.384 7.384a.75.75 0 1 0-1.06 1.06l2.646 2.586z"/>
            </svg>
        </div>
        <h2 class="text-success fw-bold mb-2">Thank You!</h2>
        <p class="mb-4 text-muted" style="font-size: 1.1rem;">Your form has been successfully Sent!</p>
        <!-- <?= Html::a('Go to Your Dashboard', ['/'], [
            'class' => 'btn btn-success fw-bold px-5 py-2',
            'style' => 'font-size: 16px; letter-spacing: 0.5px; color: white;',
        ]) ?> -->
    </div>
</div>



