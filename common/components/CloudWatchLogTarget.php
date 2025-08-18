<?php

namespace common\components; // Or 'app\components', depending on your project structure

use Yii;
use yii\log\Target;
use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\Exception\AwsException;
use yii\helpers\VarDumper; // Added for robust non-string message handling

class CloudWatchLogTarget extends Target
{
    public $region;
    public $logGroup;
    public $logStream;
    public $awsAccessKeyId; // Only if not using IAM roles (less secure)
    public $awsSecretAccessKey; // Only if not using IAM roles (less secure)

    private $_client;
    private $_sequenceToken = null;

    public function init()
    {
        parent::init();

        $config = [
            'region' => $this->region,
            'version' => 'latest', // Use the latest API version
        ];

        // Only add credentials if explicitly provided (not recommended for EC2/ECS)
        if ($this->awsAccessKeyId && $this->awsSecretAccessKey) {
            $config['credentials'] = [
                'key' => $this->awsAccessKeyId,
                'secret' => $this->awsSecretAccessKey,
            ];
        }

        $this->_client = new CloudWatchLogsClient($config);

        // Fetch initial sequence token for the log stream
        // This is crucial for PutLogEvents. If stream doesn't exist, create it.
        try {
            $result = $this->_client->describeLogStreams([
                'logGroupName' => $this->logGroup,
                'logStreamNamePrefix' => $this->logStream, // Use prefix to find exact match
                'limit' => 1
            ]);

            $streamExists = false;
            if (!empty($result['logStreams'])) {
                foreach ($result['logStreams'] as $stream) {
                    if ($stream['logStreamName'] === $this->logStream) {
                        $this->_sequenceToken = $stream['uploadSequenceToken'] ?? null;
                        $streamExists = true;
                        break;
                    }
                }
            }

            if (!$streamExists) {
                // Try to create the log group first if it doesn't exist
                try {
                    $this->_client->createLogGroup([
                        'logGroupName' => $this->logGroup,
                    ]);
                } catch (AwsException $e) {
                    // Ignore if log group already exists, otherwise log error
                    if ($e->getAwsErrorCode() !== 'ResourceAlreadyExistsException') {
                        Yii::error("Failed to create log group '{$this->logGroup}': " . $e->getMessage(), __METHOD__);
                        // If log group creation failed for other reasons, we might not be able to create stream
                        // You might want to halt further stream creation attempts here.
                    }
                }

                // Now try to create the log stream
                try {
                    $this->_client->createLogStream([
                        'logGroupName' => $this->logGroup,
                        'logStreamName' => $this->logStream,
                    ]);
                    // After creation, sequence token is null, AWS assigns it on first PutLogEvents
                    $this->_sequenceToken = null;
                } catch (AwsException $e) {
                    Yii::error("Failed to create log stream '{$this->logStream}' in group '{$this->logGroup}': " . $e->getMessage(), __METHOD__);
                }
            }
        } catch (AwsException $e) {
            Yii::error("Failed to describe log stream '{$this->logStream}' in group '{$this->logGroup}': " . $e->getMessage(), __METHOD__);
        }
    }

    public function export()
    {
        if (empty($this->messages)) {
            return;
        }

        $logEvents = [];
        foreach ($this->messages as $message) {
            // $message is an array: [0 => text, 1 => level, 2 => category, 3 => timestamp, 4 => traces, 5 => memory usage]
            $logMessage = $this->formatMessage($message); // This calls the public formatMessage

            $logEvents[] = [
                'timestamp' => (int)($message[3] * 1000), // CloudWatch expects milliseconds, $message[3] is timestamp
                'message' => $logMessage,
            ];
        }

        // CloudWatch Logs requires events to be in chronological order by timestamp
        usort($logEvents, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        // Split logs into chunks if necessary (max 1MB per PutLogEvents call)
        // This is a basic chunking. For very high volume, a more sophisticated
        // chunking logic might be needed that also considers event count (max 10,000)
        // and message size.
        $chunks = array_chunk($logEvents, 1000); // Process in batches of 1000 events

        foreach ($chunks as $chunk) {
            try {
                $params = [
                    'logGroupName' => $this->logGroup,
                    'logStreamName' => $this->logStream,
                    'logEvents' => $chunk, // Use the current chunk
                ];

                if ($this->_sequenceToken !== null) {
                    $params['sequenceToken'] = $this->_sequenceToken;
                }

                $result = $this->_client->putLogEvents($params);
                $this->_sequenceToken = $result['nextSequenceToken'];

            } catch (AwsException $e) {
                // Log the error to a fallback target (e.g., file system or Sentry)
                // This is crucial to avoid losing log data when CloudWatch is unavailable
                Yii::error("Failed to send logs to CloudWatch Logs: " . $e->getMessage(), __METHOD__);

                // If sequence token error, we might need to re-fetch it or give up for this batch
                if ($e->getAwsErrorCode() === 'InvalidSequenceTokenException' || $e->getAwsErrorCode() === 'DataAlreadyAcceptedException') {
                    // Try to re-fetch the sequence token and retry for the next export cycle
                    // This can happen if another process sent logs, or due to race conditions.
                    Yii::warning("CloudWatch sequence token error. Attempting to refresh token for next batch. Error: " . $e->getMessage(), __METHOD__);
                    $this->_sequenceToken = null; // Mark for re-fetch on next init/export
                } else {
                    // For other errors, keep sequence token as is or reset if fatal
                    $this->_sequenceToken = null; // Reset to try fetching on next export
                }
            }
        }
    }

    /**
     * Formats a log message for display as a string.
     * Must be public to override yii\log\Target::formatMessage().
     * @param array $message The log message to be formatted.
     * @param string|null $token This parameter is present in yii\log\Target::formatMessage() signature.
     * @return string The formatted log message.
     */
    public function formatMessage($message, $token = null) // <<< CHANGED TO PUBLIC
    {
        // $message is an array: [0 => text, 1 => level, 2 => category, 3 => timestamp, 4 => traces, 5 => memory usage]
        $text = $message[0];
        $level = $message[1];
        $category = $message[2];
        $timestamp = $message[3];
        $traces = isset($message[4]) ? $message[4] : [];

        $levelName = \Yii\log\Logger::getLevelName($level);

        // Ensure $text is a string. If it's an object/array, convert it.
        if (!is_string($text)) {
            $text = VarDumper::export($text);
        }

        // --- Choose one of the following formatting options ---

        // Option A: Basic format (similar to default FileTarget)
        // return date('Y-m-d H:i:s', $timestamp) . " [{$levelName}][{$category}] " . $text;

        // Option B: JSON format (more robust for CloudWatch Insights queries) - RECOMMENDED
        return json_encode([
            'timestamp' => (int)($timestamp * 1000), // Milliseconds
            'level' => $levelName,
            'category' => $category,
            'message' => $text,
            'trace' => $traces, // Include trace info if available
            'env' => YII_ENV, // Global Yii constant, provides environment (e.g., 'dev', 'prod')
            'hostname' => gethostname(), // Useful for multi-server deployments
            'process_id' => getmypid(), // Useful for debugging specific processes
            // Add other contextual data as needed (e.g., user ID, request ID if available)
        ]);
    }
}