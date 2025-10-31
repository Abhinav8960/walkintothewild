<?php

namespace developer\widgets;

use Yii;
use yii\base\Widget;


class PageHeader extends Widget
{

    public $subtitle;
    public $subsubtitle;
    public $title;
    public $display = TRUE;
    public $buttons = [];

    /**
     * {@inheritdoc}
     */
    public function run()
    {

        if ($this->display) {
            if (!empty($this->subtitle) || !empty($this->title) || !empty($this->buttons)) {
                return $this->render('pageheader', [
                    'subtitle' => $this->subtitle,
                    'subsubtitle' => $this->subsubtitle,
                    'title' => $this->title,
                    'buttons' => $this->buttons
                ]);
            }
        }
    }
}
