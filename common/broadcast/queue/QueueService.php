<?php

namespace common\broadcast\queue;

class QueueService
{
    protected $db;

    public function __construct()
    {
        // Use the database component from the framework
        $this->db = \Yii::$app->db;
    }

    /**
     * Add an event to the queue.
     */
    public function addToQueue($event)
    {
        $model = new \common\models\EventQueue();
        $model->event_type = get_class($event);
        $model->event_data = json_encode($event);
        $model->created_at = date('Y-m-d H:i:s');
        $model->processed_at = null;
        if ($model->save()) {
            echo "Event queued for user {$event->userId}\n";
        } else {
            echo "Failed to queue event: " . json_encode($model->getErrors()) . "\n";
        }
    }

    /**
     * Process all queued events.
     */
    public function processQueue()
    {

        $events = \common\models\EventQueue::find()
            ->where(['processed_at' => null])
            ->all();

        foreach ($events as $event) {
            $event = json_decode($event->event_data); // Recreate the event object
            echo "Processing queued event for user {$event->userId}\n";

            // Logic to send the event (e.g., call BroadcastService::sendImmediately)
            $broadcastService = new \common\broadcast\services\BroadcastService();
            $broadcastService->sendImmediately($event);

            $event->processed_at = date('Y-m-d H:i:s');
            $event->save();
            
        }
    }
}
