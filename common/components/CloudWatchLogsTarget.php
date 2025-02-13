<?php
namespace common\components;

use yii\log\Target;
use Aws\CloudWatchLogs\CloudWatchLogsClient;

class CloudWatchLogsTarget extends Target
{
    /**
     * @var string AWS Region
     */
    public $region = 'ap-south-1';

    /**
     * @var string AWS Access Key ID
     */
    public $accessKeyId;

    /**
     * @var string AWS Secret Access Key
     */
    public $secretAccessKey;

    /**
     * @var string Log Group Name
     */
    public $logGroupName;

    /**
     * @var string Log Stream Name
     */
    public $logStreamName;

    /**
     * @inheritdoc
     */
    public function export()
    {
        $client = new CloudWatchLogsClient([
            'region' => $this->region,
            'version' => 'latest',
            'credentials' => [
                'key' => $this->accessKeyId,
                'secret' => $this->secretAccessKey,
            ],
        ]);
      
        
        foreach ($this->messages as $message) {
            $logEvents = [];
            foreach ($message['messages'] as $logMessage) {
                $logEvents[] = [
                    'Timestamp' => $message['timestamp'] * 1000, // Convert to milliseconds
                    'Message' => $logMessage,
                ];
            }
           
            try {
                $result = $client->putLogEvents([
                    'LogGroupName'  => $this->logGroupName,
                    'LogStreamName' => $this->logStreamName,
                    'LogEvents'    => $logEvents,
                    'SequenceToken' => isset($lastSequenceToken) ? $lastSequenceToken : null,
                ]);

                $lastSequenceToken = $result['nextSequenceToken'];
            } catch (\Exception $e) {
                // Handle exceptions (e.g., log the error, retry)
                echo "Error sending logs to CloudWatch: " . $e->getMessage();
                \Yii::error("Error sending logs to CloudWatch: " . $e->getMessage(), __METHOD__);
            }
        }
        print_r( $logEvents);
        
        die('lklkkl');
    }
}