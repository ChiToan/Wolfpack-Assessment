<?php

use yii\db\Migration;

/**
 * Class m200825_191012_wolf
 */
class m200825_191012_wolf extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wolf', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'gender' => $this->string(),
            'birthdate' => $this->date(),
            'latitude' => $this->decimal(10,6),
            'longitude' => $this->decimal(11,6),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('wolf');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200825_191012_wolf cannot be reverted.\n";

        return false;
    }
    */
}
