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
  public $delete_flag;
  public $ignore_flag;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {


    return [
      [['delete_flag', 'ignore_flag'], 'safe']
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'delete_flag' => 'Delete',
      'ignore_flag' => 'Ignored',
    ];
  }
}
