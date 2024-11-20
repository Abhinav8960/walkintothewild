<?php

namespace api\models\suggestions;


class SafariSuggestions extends \common\models\suggestions\SafariSuggestions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['park_id', 'master_suggestion_id', 'you_are_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_agent', 'ip_address'], 'required'],
            [['user_agent', 'email', 'name'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
        ];
    }

}
