<?php

namespace weikaiiii\backgroundTranslationI18n\models;

use Yii;
use weikaiiii\backgroundTranslationI18n\models\TranslateJsonValue;

/**
 * This is the model class for table "translate_json_key".
 *
 * @property int $id
 * @property string $category_name 类别名称
 * @property string $key key name
 * @property string $value
 */
class TranslateJsonKey extends \yii\db\ActiveRecord
{
    public $file;
    public $lang_code;
    public $value;
    public $value_i18n;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translate_json_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['category_name', 'key'], 'string', 'max' => 100],
            [['lang_code'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'key' => 'Key',
        ];
    }

    public function GetTvalue()
    {
        return $this->hasMany(TranslateJsonValue::className(),['key_id'=>'id']);
    }
}
