<?php

use yii\db\Migration;
use yii\db\Schema;

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
            'latitude' => $this->double(6),
            'longitude' => $this->double(6),
            'pack_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-wolf-pack_id',
            'wolf',
            'pack_id'
        );

        $this->addForeignKey(
            'fk-wolf-pack_id',
            'wolf',
            'pack_id',
            'pack',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-wolf-pack_id',
            'wolf'
        );
        $this->dropIndex(
            'idx-wolf-pack_id',
            'wolf'
        );
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
