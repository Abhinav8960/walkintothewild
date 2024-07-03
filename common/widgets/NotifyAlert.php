<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class NotifyAlert extends Widget
{

    public $alertTypes = [
        'error'   => 'error',
        'danger'  => 'error',
        'success' => 'success',
        'info'    => 'info',
        'warning' => 'warning'
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $flash) {
            if (!isset($this->alertTypes[$type])) {
                continue;
            }

            foreach ((array) $flash as $i => $message) {

                return $this->render('notifyalert', [
                    'message' => $message,
                    'type' => $type,
                    'flashclass' => $this->alertTypes[$type]
                ]);
            }

            $session->removeFlash($type);
        }
    }
}
