<?php

namespace weikaiiii\backgroundTranslationI18n\models;

use Yii;

/**
 * This is the model class for table "translate_json_value".
 *
 * @property int $id
 * @property int $key_id
 * @property string $lang_code
 * @property string $value 译文
 */
class TranslateJsonValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translate_json_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key_id'], 'integer'],
            [['value'], 'string'],
            [['lang_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_id' => 'Key ID',
            'lang_code' => 'Lang Code',
            'value' => 'Value',
        ];
    }
}
