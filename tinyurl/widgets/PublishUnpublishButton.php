<?php

namespace tinyurl\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class PublishUnpublishButton extends Widget implements \common\interfaces\StatusInterface
{

    public $published_title = 'Item';
    public $unpublish_title = 'Item';
    public $unpublish_button_title = 'Unpublished';
    public $publish_button_title = 'Published';

    public $model;


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->model->is_published == self::STATUS_ACTIVE) {
            return Html::a($this->unpublish_button_title, ['unpublish', 'id' => $this->model->id], [
                'class' => 'btn btn-outline-danger',
                'style' => 'color:black !important;',
                'title' => $this->unpublish_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->unpublish_button_title . " this " . $this->unpublish_title . " ?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip',
                ],
            ]);
        } else if ($this->model->is_published == self::STATUS_SUSPEND) {
            return Html::a($this->publish_button_title, ['publish', 'id' => $this->model->id], [
                'class' => 'btn btn btn-outline-success',
                'style' => 'color:black !important;',
                'title' => $this->publish_button_title,
                'data' => [
                    'confirm' => "Are You Sure you want to " . $this->publish_button_title . " this " . $this->published_title . "?",
                    'method' => 'post',
                    'bs-toggle' => 'tooltip'
                ],
            ]);
        }
    }
}
