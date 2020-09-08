<?php

use yii\db\Migration;

/**
 * Class m190220_024743_add_translate_json_table
 */
class m190220_024743_add_translate_json_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('translate_json_key',[
           'id'=>$this->primaryKey(11),
           'category_name'=>$this->string('255')->comment('Class name'),
            'key'=>$this->string('255')->comment('Key name'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190220_024743_add_translate_json_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190220_024743_add_translate_json_table cannot be reverted.\n";

        return false;
    }
    */
}
