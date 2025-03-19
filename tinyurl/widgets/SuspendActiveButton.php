<?php

namespace tinyurl\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class SuspendActiveButton extends Widget implements \common\interfaces\NewStatusInterface
{

    public $active_title = 'Item';
    public $suspend_title = 'Item';
    public $suspend_button_title = 'Deactivate';
    public $active_button_title = 'Active';

    public $model;

    public $corporate_id;
    public $center_id;


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->model->status == self::STATUS_ACTIVE) {
            return Html::a($this->suspend_button_title, ['suspend', 'id' => $this->model->id], [
                'class' => 'btn btn-outline-danger',
                'style' => 'color:black !important;',
                'title' => $this->suspend_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->suspend_button_title . " this " . $this->suspend_title . " ?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip',
                ],
            ]);
        } else if ($this->model->status == self::STATUS_SUSPEND) {
            return Html::a($this->active_button_title, ['active', 'id' => $this->model->id], [
                'class' => 'btn btn btn-outline-success',
                'style' => 'color:black !important;',
                'title' => $this->active_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->active_button_title . " this " . $this->active_title . "?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip'
                ],
            ]);
        } elseif ($this->model->status == self::STATUS_DELETE) {
            return Html::a($this->active_button_title, ['active', 'id' => $this->model->id], [
                'class' => 'btn btn btn-outline-success',
                'style' => 'color:black !important;',
                'title' => $this->active_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->active_button_title . " this " . $this->active_title . "?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip'
                ],
            ]);
        }
    }
}
