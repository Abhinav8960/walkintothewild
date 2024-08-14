<?php

namespace common\models\sharesafari\form;

use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\User;
use Yii;
use yii\base\Model;


/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class ShareSafariCommentFlagActionForm extends model
{
  public $flag_action;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {


    return [
      [['flag_action'], 'safe']
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'flag_action' => 'Action'
    ];
  }
}
