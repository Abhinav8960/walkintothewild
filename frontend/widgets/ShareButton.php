<?php

namespace frontend\widgets;

/**
 * This is just an example.
 */
class ShareButton extends \yii\base\Widget
{
	/**
	 * @var string box alignment - horizontal, vertical
	 */
	public $style;


	public $data_via;


	/**
	 * @var array available social media share buttons 
	 * like - facebook, googleplus, linkedin, twitter
	 */

	public $networks = ['facebook', 'googleplus', 'linkedin', 'twitter', 'whatsapp', 'instagram', 'telegram', 'clipboard'];


	/**
	 * The extension initialisation
	 *
	 * @return nothing
	 */

	public function init()
	{
		parent::init();
	}


	public function run()
	{
		$rendered = '';
		foreach ($this->networks as $params) :
			$rendered .= $this->render('sharebutton/' . $params);
		endforeach;

		return $this->render('sharebutton/sharebutton', ['rendered' => $rendered]);
	}
}
