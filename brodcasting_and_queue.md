<?php
use common\events\user\NewUserRegistration;
use common\services\BroadcastService;

$event = new NewUserRegistration(1, 'user@example.com', 'John Doe', '1234567890');
$broadcastService = new BroadcastService();

// Send immediately
$broadcastService->send($event, true);

// Queue for later
$broadcastService->send($event, false);

// Process the queue (e.g., in a cron job or worker script)
$queueService = new \common\queue\QueueService();
$queueService->processQueue();