<?php

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class SuspendActiveButton extends Widget implements \common\interfaces\StatusInterface
{

    public $active_title = 'Item';
    public $suspend_title = 'Item';
    public $suspend_button_title = 'Suspend';
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
            return Html::a($this->suspend_button_title, ['suspend', 'id' => $this->model->id, 'corporate_id' => $this->corporate_id, 'center_id' => $this->center_id], [
                'class' => 'btn btn-icon btn-sm btn-outline-danger',
                'title' => $this->suspend_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->suspend_button_title . " this " . $this->suspend_title . " ?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip',
                ],
            ]);
        } else if ($this->model->status == self::STATUS_SUSPEND) {
            return Html::a($this->active_button_title, ['active', 'id' => $this->model->id, 'corporate_id' => $this->corporate_id, 'center_id' => $this->center_id], [
                'class' => 'btn btn-icon btn-sm btn btn-outline-success',
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
