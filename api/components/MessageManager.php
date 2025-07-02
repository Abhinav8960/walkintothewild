<?php
// @api/components/MessageManager.php
namespace api\components;

use Yii;
use yii\base\Component;

class MessageManager extends Component
{
    public $messageFile = '@api/config/messages.php';
    public $cacheDuration = 3600; // Cache for 1 hour
    public $cacheKey = 'app_flash_messages';

    private $_messages;

    public function init()
    {
        parent::init();
        $this->loadMessages();
    }

    protected function loadMessages()
    {

        $cache = Yii::$app->cache;

        // Try to get messages from cache
        $messages = $cache->get($this->cacheKey);

        if ($messages === false) {
            // If not in cache, load from file
            $filePath = Yii::getAlias($this->messageFile);
            if (file_exists($filePath)) {
                $messages = require $filePath;
                // Store in cache
                $cache->set($this->cacheKey, $messages, $this->cacheDuration);
            } else {
                $messages = [];
                Yii::warning("Message file not found: {$filePath}", __METHOD__);
            }
        }
        $this->_messages = $messages;
    }

    /**
     * Retrieves a message by its key.
     *
     * @param string $key The key of the message.
     * @param array $params Optional parameters to be replaced in the message (e.g., ['{username}' => 'John Doe']).
     * @param string|null $default The default message if the key is not found.
     * @return string The message.
     */

    public function getMessage($key, $params = [], $default = null)
    {
        if (!is_string($key) || empty($key)) {
            Yii::warning("getMessage() called with invalid or empty key: " . print_r($key, true), __METHOD__);
            return $default === null ? '' : $default;
        }

        $parts = explode('.', $key);
        $currentLevel = $this->_messages;

        foreach ($parts as $index => $part) {
            if (!is_array($currentLevel) || !isset($currentLevel[$part])) {
                return $default === null ? '' : $default;
            }
            $currentLevel = $currentLevel[$part];
        }

        if (!is_string($currentLevel)) {
            return $default === null ? '' : $default;
        }

        $message = $currentLevel;
        $message = strtr($message, $params);
        $message = preg_replace('/\{[^\}]+\}/', '', $message);
        return trim($message);
    }

    /**
     * Clears the cached messages. Useful when you update the messages.php file.
     */
    // public function clearCache()
    // {
    //     \Yii::$app->cache->delete($this->cacheKey);
    //     return true;
    // }

    // public static function clearAllCache()
    // {
    //     $manager = new self();
    //     return $manager->clearCache();
    // }

    public function clearCache($cache = null)
    {
        $cache = $cache ?: \Yii::$app->cache;
        $cache->delete($this->cacheKey);
        return true;
    }
}
