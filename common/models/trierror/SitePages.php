<?php

namespace common\models\trierror;

use Yii;

/**
 * This is the model class for table "site_pages".
 *
 * @property int $id
 * @property int $content_id
 * @property string|null $content_type
 * @property string|null $url
 * @property string|null $slug
 * @property string|null $last_update_at
 * @property int $exist_in_xml
 * @property string|null $xml_created_at
 * @property int $counter
 * @property int $status
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class SitePages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'exist_in_xml', 'counter', 'status'], 'integer'],
            [['last_update_at', 'xml_created_at', 'updated_at', 'created_at'], 'safe'],
            [['content_type'], 'string', 'max' => 155],
            [['url'], 'string', 'max' => 555],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'content_type' => 'Content Type',
            'url' => 'Url',
            'slug' => 'Slug',
            'last_update_at' => 'Last Update At',
            'exist_in_xml' => 'Exist In Xml',
            'xml_created_at' => 'Xml Created At',
            'counter' => 'Counter',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
