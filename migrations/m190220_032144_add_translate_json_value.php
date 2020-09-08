<?php

use yii\db\Migration;

/**
 * Class m190220_032144_add_translate_json_value
 */
class m190220_032144_add_translate_json_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('translate_json_value',[
            'id'=>$this->primaryKey(11),
            'key_id'=>$this->integer(11),
            'lang_code'=>$this->string('5'),
            'value'=>$this->text()->comment('Translation'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190220_032144_add_translate_json_value cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190220_032144_add_translate_json_value cannot be reverted.\n";

        return false;
    }
    */
}
