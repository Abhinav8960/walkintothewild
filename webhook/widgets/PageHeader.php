<?php

namespace backend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 * 
 * Usage example
 * 
 * $this->title = 'Dashboard';
 * $this->params['breadcrumbs'][] =  ['label' => 'Venue', 'url' => ''];
 * $this->params['breadcrumbs'][] = $this->title;
 * 
 * $this->params['title'] = 'Dashboard';
 * $this->params['buttons'][] = Html::a('Create', ['create'], ['class' => 'btn btn-primary me-3']);
 * $this->params['buttons'][] = Html::a('<i class="las la-file-excel"></i>' . 'Download Report', ['/report'], ['class' => 'btn btn-secondary me-3']);
 */
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
