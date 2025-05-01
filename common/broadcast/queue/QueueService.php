<?php

namespace common\queue;

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
        $this->db->createCommand()->insert('event_queue', [
            'event_type' => get_class($event),
            'event_data' => json_encode($event),
            'created_at' => date('Y-m-d H:i:s'),
        ])->execute();

        echo "Event queued for user {$event->userId}\n";
    }

    /**
     * Process all queued events.
     */
    public function processQueue()
    {
        $events = $this->db->createCommand("SELECT * FROM event_queue WHERE processed_at IS NULL")
            ->queryAll();

        foreach ($events as $row) {
            $event = json_decode($row['event_data']); // Recreate the event object
            echo "Processing queued event for user {$event->userId}\n";

            // Logic to send the event (e.g., call BroadcastService::sendImmediately)
            $broadcastService = new \common\broadcast\services\BroadcastService();
            $broadcastService->sendImmediately($event);

            // Mark the event as processed
            $this->db->createCommand()->update('event_queue', [
                'processed_at' => date('Y-m-d H:i:s'),
            ], ['id' => $row['id']])->execute();
        }
    }
}
